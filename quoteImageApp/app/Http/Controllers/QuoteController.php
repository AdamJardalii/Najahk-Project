<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Services\QuoteService;

class QuoteController extends Controller
{
    
    protected $quoteService;

    public function __construct(QuoteService $quoteService)
    {
        $this->quoteService = $quoteService;
    }    
    
    public function index(Request $request, QuoteService $service)
    {
        try {
            $page = $request->query('page', 1);
            $limit = $request->query('limit', 10);

            $cacheKey = "quotes_page_{$page}_limit_{$limit}";
            $data = Cache::remember($cacheKey, now()->addMinutes(5), function () use ($page, $limit) {
                return $this->quoteService->fetchQuotes($page, $limit);
            });

            
            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        }
        catch (\Exception $e) {
            \Log::error('Error fetching quotes: '.$e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch quotes. Please try again later.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
