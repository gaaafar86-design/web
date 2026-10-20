<?php

namespace App\Http\Controllers\Admin;

use App\Models\Blog;
use App\Models\Plan;
use App\Models\User;
use App\Models\Order;
use App\Models\Property;
use Illuminate\View\View;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    /**
     * Display the admin panel.
     *
     * @return View
     */
    public function index(): View
    {
        $postCount = Blog::count();
        $totalPackages = Plan::count();
        $totalUsers = User::where('status', 1)->count();
        $totalOrders = Order::where('status', 1)->count();
        $totalProperties = Property::where('status', 1)->count();
        $totalSubscribers = Subscriber::where('status', 1)->count();
        return view(
            'admin.index',
            compact(
                'postCount',
                'totalUsers',
                'totalPackages',
                'totalOrders',
                'totalProperties',
                'totalSubscribers',
            )
        );
    }
}
