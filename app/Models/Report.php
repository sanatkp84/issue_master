<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    
    
    public static function getMonthlyCounts()
    {
        // Create an array to store counts for each month
        $monthlyCounts = [];

        // Fetch counts from the database
        $counts = self::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->get()
            ->pluck('count', 'month')
            ->toArray();

        // Fill in zero counts for months without data
        for ($i = 1; $i <= 12; $i++) {
            $monthlyCounts[$i] = $counts[$i] ?? 0;
        }

        return $monthlyCounts;
    }

    
    
    
}

