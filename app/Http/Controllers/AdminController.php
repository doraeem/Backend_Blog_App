<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Blog;
use App\Models\Review;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function getDashboardData()
    {
        try {
            // Get counts for dashboard
            $totalBlogs = Blog::count();
            $totalUsers = User::count();
            

            return response()->json([
                'totalBlogs' => $totalBlogs,
                'totalUsers' => $totalUsers,
               
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to load dashboard data'], 500);
        }
    }
}
