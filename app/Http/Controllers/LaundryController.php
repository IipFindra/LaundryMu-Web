<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;

class LaundryController extends Controller
{
    public function getServices()
    {
        $services = Service::all();
        return response()->json([
            'success' => true,
            'data' => $services
        ]);
    }

    public function getOrders(Request $request)
    {
        $orders = $request->user()->orders()->with('service')->get();
        return response()->json([
            'success' => true,
            'data' => $orders
        ]);
    }
}
