<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    /**
     * Display a listing of all orders with related agent and plan data.
     *
     * This method retrieves all orders from the database,
     * eager loads their associated agent and plan relationships,
     * and passes the result to the admin order index view.
     *
     * @return View
     */
    public function index(): View
    {
        $orders = Order::with('agent', 'plan')->get();
        return view('admin.order.index', compact('orders'));
    }

    /**
     * Display the invoice view for a specific order.
     *
     * This method receives an Order instance via route-model binding,
     * eager loads its related agent and plan data,
     * and returns the invoice view for admin review or printing.
     *
     * @param Order $order
     * @return View
     */
    public function invoice(Order $order): View
    {
        $order->load('agent', 'plan');
        return view('admin.order.invoice', compact('order'));
    }
}
