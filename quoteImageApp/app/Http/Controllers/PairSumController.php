<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PairSumController extends Controller
{
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
        
        $result = $this->findUniquePairsWithTargetSum($numbers, $targetSum);
        
        return response()->json([
            'input' => [
                'numbers' => $numbers,
                'targetSum' => $targetSum
            ],
            'pairs' => $result,
            'count' => count($result)
        ]);
    }
    
    private function findUniquePairsWithTargetSum($numbers, $targetSum)
    {
        $answer = [];
        $frequency = [];
        
        foreach ($numbers as $current) {
            $missing = $targetSum - $current;
            
            $missingExists = isset($frequency[$missing]) && $frequency[$missing] > 0;
            
            if ($current === $missing) {
                $validCurrent = isset($frequency[$current]) && $frequency[$current] === 1;
            } else {
                $validCurrent = !isset($frequency[$current]) || $frequency[$current] === 0;
            }
            
            if ($missingExists && $validCurrent) {
                $a = min($current, $missing);
                $b = max($current, $missing);
                $answer[] = [$a, $b];
            }
            
            if (!isset($frequency[$current])) {
                $frequency[$current] = 0;
            }
            $frequency[$current]++;
        }
        
        return $answer;
    }
}