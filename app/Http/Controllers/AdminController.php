<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index()
    {
        $totalUsers = User::count();
        $totalNotes = Note::count();
        $usersWithNotes = User::has('notes')->count();
        
        // Notes created per day (last 30 days)
        $notesPerDay = Note::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as count')
        )
        ->where('created_at', '>=', now()->subDays(30))
        ->groupBy('date')
        ->orderBy('date')
        ->get();

        // Users registered per day (last 30 days)
        $usersPerDay = User::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as count')
        )
        ->where('created_at', '>=', now()->subDays(30))
        ->groupBy('date')
        ->orderBy('date')
        ->get();

        // Top users by note count
        $topUsers = User::withCount('notes')
            ->orderBy('notes_count', 'desc')
            ->limit(10)
            ->get();

        // Notes per user distribution
        $usersWithCounts = User::withCount('notes')->get();
        $distribution = [
            '0' => 0,
            '1-5' => 0,
            '6-10' => 0,
            '11-20' => 0,
            '20+' => 0
        ];
        
        foreach ($usersWithCounts as $user) {
            $count = $user->notes_count;
            if ($count == 0) {
                $distribution['0']++;
            } elseif ($count <= 5) {
                $distribution['1-5']++;
            } elseif ($count <= 10) {
                $distribution['6-10']++;
            } elseif ($count <= 20) {
                $distribution['11-20']++;
            } else {
                $distribution['20+']++;
            }
        }
        
        $notesDistribution = collect($distribution)->map(function ($count, $range) {
            return (object)['range' => $range, 'count' => $count];
        })->values();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalNotes',
            'usersWithNotes',
            'notesPerDay',
            'usersPerDay',
            'topUsers',
            'notesDistribution'
        ));
    }
}
