<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a printable version of the order.
     */
    public function print(Order $order)
    {
        return view('orders.print', compact('order'));
    }
}
