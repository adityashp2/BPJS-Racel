<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemPickup;
use App\Models\JobDivision;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display the dashboard with real-time statistics
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Get current user
        $user = Auth::user();

        // Basic counts method index
        $totalPickups = ItemPickup::count();
        $totalUsers = User::count();
        $recentPickups = ItemPickup::whereDate('taken_date', '>=', now()->subDays(7))->count();
        $totalItems = Item::count();

        // User-specific data
        $userTotalPickups = ItemPickup::where('user_id', $user->id)->count();
        $userRecentPickups = ItemPickup::where('user_id', $user->id)
            ->whereDate('taken_date', '>=', now()->subDays(7))
            ->count();
        $userTotalItems = ItemPickup::where('user_id', $user->id)
            ->distinct('item_id')
            ->count('item_id');
        $userTotalQuantity = ItemPickup::where('user_id', $user->id)
            ->sum('quantity');

        // User recent pickups list
        $userRecentPickupsList = ItemPickup::select('id', 'item_id', 'quantity', 'taken_date', 'created_at')
            ->with('item:id,name')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Low stock items (less than 5 items)
        $lowStockItems = Item::where('stock', '<', 5)
            ->orderBy('stock', 'asc')
            ->limit(5)
            ->get();

        // Top picked up items
        $topPickedItems = Item::select('items.id', 'items.name', 'items.code', 'items.stock', DB::raw('SUM(item_pickups.quantity) as pickup_count'))
            ->leftJoin('item_pickups', 'items.id', '=', 'item_pickups.item_id')
            ->groupBy('items.id', 'items.name', 'items.code', 'items.stock')
            ->orderBy('pickup_count', 'desc')
            ->limit(5)
            ->get();

        // Recent pickups
        $recentPickupsList = ItemPickup::with(['item', 'user'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Monthly pickups data for chart
        $monthlyPickups = $this->getMonthlyPickupsData();
        $monthlyPickupsLabels = $monthlyPickups['labels'];
        $monthlyPickupsData = $monthlyPickups['data'];

        // Pickup distribution by month
        $pickupDistribution = $this->getPickupMonthDistribution();
        $pickupMonthLabels = $pickupDistribution['labels'];
        $pickupMonthData = $pickupDistribution['data'];

        // Division distribution for chart
        $divisionDistribution = $this->getDivisionDistribution();
        $divisionLabels = $divisionDistribution['labels'];
        $divisionData = $divisionDistribution['data'];

        // User monthly pickups data
        $userMonthlyPickups = $this->getUserMonthlyPickupsData($user->id);
        $userMonthlyPickupsLabels = $userMonthlyPickups['labels'];
        $userMonthlyPickupsData = $userMonthlyPickups['data'];

        //mengirim ke view dalam bentuk array
        return view('dashboard', compact(
            'totalPickups',
            'totalUsers',
            'recentPickups',
            'totalItems',
            'lowStockItems',
            'topPickedItems',
            'recentPickupsList',
            'monthlyPickupsLabels',
            'monthlyPickupsData',
            'pickupMonthLabels',
            'pickupMonthData',
            'divisionLabels',
            'divisionData',
            'userTotalPickups',
            'userRecentPickups',
            'userTotalItems',
            'userTotalQuantity',
            'userRecentPickupsList',
            'userMonthlyPickupsLabels',
            'userMonthlyPickupsData'
        ));
    }

    /**
     * Get monthly pickups data for the last 6 months
     *
     * @return array
     */
    private function getMonthlyPickupsData()
    {
        $labels = [];
        $data = [];

        // Get last 6 months
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $labels[] = $month->format('M Y');

            $count = ItemPickup::whereYear('taken_date', $month->year)
                ->whereMonth('taken_date', $month->month)
                ->count();

            $data[] = $count;
        }

        return [
            'labels' => $labels,
            'data' => $data
        ];
    }

    /**
     * Get pickup distribution by month for chart
     *
     * @return array
     */
    private function getPickupMonthDistribution()
    {
        $labels = [];
        $data = [];

        // Use the current year's months
        for ($i = 1; $i <= 12; $i++) {
            $month = Carbon::create(now()->year, $i, 1);
            $labels[] = $month->format('M');

            $count = ItemPickup::whereYear('taken_date', now()->year)
                ->whereMonth('taken_date', $i)
                ->count();

            $data[] = $count;
        }

        return [
            'labels' => $labels,
            'data' => $data
        ];
    }

    /**
     * Get division distribution for chart
     *
     * @return array
     */
    private function getDivisionDistribution()
    {
        $divisions = JobDivision::withCount('users')->get();
        $labels = $divisions->pluck('name')->toArray();
        $data = $divisions->pluck('users_count')->toArray();

        // Optionally, add users without division as 'Unassigned'
        $unassigned = \App\Models\User::whereNull('job_division_id')->count();
        if ($unassigned > 0) {
            $labels[] = 'Unassigned';
            $data[] = $unassigned;
        }

        return [
            'labels' => $labels,
            'data' => $data
        ];
    }

    /**
     * Get monthly pickups data for a specific user for the last 6 months
     *
     * @param int $userId
     * @return array
     */
    private function getUserMonthlyPickupsData($userId)
    {
        $labels = [];
        $data = [];

        // Get last 6 months
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $labels[] = $month->format('M Y');

            $count = ItemPickup::where('user_id', $userId)
                ->whereYear('taken_date', $month->year)
                ->whereMonth('taken_date', $month->month)
                ->count();

            $data[] = $count;
        }

        return [
            'labels' => $labels,
            'data' => $data
        ];
    }
}
