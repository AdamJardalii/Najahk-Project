<?php

namespace App\Services;
use Illuminate\Support\Facades\Http;

class QuoteService
{
    protected string $apiUrl;
    protected string $imageUrl;

    public function __construct()
    {
        $this->apiUrl   = env('QUOTABLE_API_URL');
        $this->imageUrl = env('QUOTE_IMAGE_URL');
    }

    /**
    * Format API response to clean JSON
    */
    public function fetchQuotes(int $page = 1, int $limit = 10): array
    {
        try{
            $response = Http::withOptions(['verify' => false])->get($this->apiUrl, [
                'page' => $page,
                'limit' => $limit,
            ]);

            if (!$response->successful()) {
                \Log::error('QuoteService API error', [
                    'status' => $response->status(),
                    'page'   => $page,
                    'limit'  => $limit
                ]);
                return $this->emptyResponse($page);
            }

            return $this->formatResponse($response->json(), $page);
        }
        catch (RequestException $e) {
            \Log::error('QuoteService HTTP error: '.$e->getMessage(), ['page' => $page, 'limit' => $limit]);
        } catch (\Exception $e) {
            \Log::error('QuoteService error: '.$e->getMessage(), ['page' => $page, 'limit' => $limit]);
        }
        return $this->emptyResponse($page);
    }

    private function formatResponse(array $data, int $page): array
    {
        $results = array_map(fn($quote) => [
            'id'      => $quote['_id'],
            'author'  => $quote['author'],
            'content' => $quote['content'],
            'tags'    => $quote['tags'],
            'image'   => "{$this->imageUrl}/{$quote['_id']}/400/300",
        ], $data['results'] ?? []);

        return [
            'results'    => $results,
            'totalPages' => $data['totalPages'] ?? 0,
            'totalCount' => $data['totalCount'] ?? 0,
            'page'       => $data['page'] ?? $page,
        ];
    }

    /**
     * Return empty response structure
     */
    private function emptyResponse(int $page): array
    {
        return [
            'results'    => [],
            'totalPages' => 0,
            'totalCount' => 0,
            'page'       => $page,
        ];
    }
}
