<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\PairSumService;

class PairSumController extends Controller
{
    protected PairSumService $pairSumService;

    public function __construct(PairSumService $pairSumService)
    {
        $this->pairSumService = $pairSumService;
    }

    public function solve(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'numbers' => 'required|array',
            'numbers.*' => 'integer',
            'targetSum' => 'required|integer'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'error' => 'Invalid input',
                'messages' => $validator->errors()
            ], 422);
        }
        
        $numbers = $request->input('numbers');
        $targetSum = $request->input('targetSum');
        
        $result =  $this->pairSumService->findUniquePairs($numbers, $targetSum);
        
        return response()->json([
            'input' => [
                'numbers' => $numbers,
                'targetSum' => $targetSum
            ],
            'pairs' => $result,
            'count' => count($result)
        ]);
    }
}