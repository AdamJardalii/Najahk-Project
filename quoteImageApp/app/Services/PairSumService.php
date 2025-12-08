<?php

namespace App\Services;

class PairSumService
{
    public function findUniquePairs(array $numbers, int $targetSum): array
    {
        $pairs     = [];
        $frequency = [];

        foreach ($numbers as $num) {
            $complement = $targetSum - $num;

            $complementExists = isset($frequency[$complement]) && $frequency[$complement] > 0;

            $validCurrent = $num === $complement
                ? isset($frequency[$num]) && $frequency[$num] === 1
                : !isset($frequency[$num]) || $frequency[$num] === 0;

            if ($complementExists && $validCurrent) {
                $pairs[] = [min($num, $complement), max($num, $complement)];
            }

            $frequency[$num] = ($frequency[$num] ?? 0) + 1;
        }

        return $pairs;
    }
}
