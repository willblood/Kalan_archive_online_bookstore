<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use App\Models\Book;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!auth()->user()->is_admin) {
                return redirect('/')->with('error', 'Unauthorized access.');
            }
            return $next($request);
        });
    }

    public function index()
    {
        \Log::info('DashboardController@index executed', [
            'user_id' => auth()->id(),
        ]);

        $data = [];

        // Total Sales
        $data['totalSales'] = Order::sum('total_amount');

        // Total Orders
        $data['totalOrders'] = Order::count();

        // Total Users
        $data['totalUsers'] = User::count();

        // Total Products
        $data['totalProducts'] = Book::count();

        // Sales Data for Chart
        $sales = Order::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(total_amount) as total')
        )
        ->groupBy('month')
        ->orderBy('month')
        ->get();

        $data['salesLabels'] = $sales->pluck('month')->map(function ($month) {
            return date('F', mktime(0, 0, 0, $month, 1)); // Convert month number to name
        })->toArray();

        $data['salesData'] = $sales->pluck('total')->toArray();

        // Top Products Data for Chart
        $topProducts = Book::withCount('orderItems') // Use the defined relationship
            ->orderBy('order_items_count', 'desc')
            ->take(5)
            ->get();

        $data['topProductsLabels'] = $topProducts->pluck('title')->toArray();
        $data['topProductsData'] = $topProducts->pluck('order_items_count')->toArray();

        // Pass the data to the view
        return view('admin.dashboard', compact('data'));
    }
}
