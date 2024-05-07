<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Flower;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use Illuminate\Http\Request;
use Dompdf\Dompdf;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   
    public function index()
    {
        // Fetch the list of flowers for sale along with their suppliers
        $flowers = Flower::latest()->get();

        // Pass the flowers list to the view
        return view('customer.flowers_list', compact("flowers"));
    }

    /**
     * Show the form for creating a new resource.
     */
    
    public function create($flowerId)
    {
        $flower = Flower::find($flowerId);
        if (!$flower) {
            // Handle the case where the flower is not found, maybe redirect or show an error message
        }

        return view('customer.place_order', compact('flower'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'quantity' => 'required|integer|min:1',
            'shipping_address' => 'required|string|max:255',
        ]);

        // Retrieve the current user's ID
        $userId = auth()->user()->id;

        // Retrieve the flower details from the request
        $flowerId = $request->input('flower_id');
        $flower = Flower::findOrFail($flowerId);

        // Calculate total amount
        $quantity = $request->input('quantity');
        $price = $flower->price;
        $totalAmount = $quantity * $price;

        // Create the order
        $order = new Order;
        $order->user_id = $userId;
        $order->flower_id = $flowerId;
        $order->total_amount = $totalAmount;
        $order->quantity = $quantity; 
        $order->shipping_address = $validatedData['shipping_address'];
        $order->save();

        // Optionally, you can return a response, redirect, or perform any other action
        // For example, redirect to a success page
        return redirect()->route('orders.index')->with('success', 'Order created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }

    public function myOrders()
    {
        // Assuming you have an authenticated user
        $user = auth()->user();
        $flowers = Flower::all();
        $status = null; // Define or set $status to null
        $flowerName = null; // Define or set $flowerName to null
    
        // Fetch orders associated with the current user
        $orders = Order::with('flower') // Eager load the flower relationship
                        ->where('user_id', $user->id)
                        ->latest()
                        ->paginate(10);
    
        return view('customer.my_orders', compact('orders', 'flowers', 'status', 'flowerName'));
    }
    

    public function showAllPendingOrders()
    {
        // Retrieve only pending orders
        $orders = Order::where('pending', true)->where('is_delivered', false)->latest()->paginate(5);
        return view('administrator.orders_list', compact('orders'));
    }
    
    public function ship($orderId)
{
    // Find the order by its ID
    $order = Order::find($orderId);

    // Check if the order exists
    if (!$order) {
        return response()->json(['message' => 'Order not found.'], 404);
    }

    // Update the 'pending' column to false
    $order->pending = false;
    $order->save();

    // Redirect back to the previous page
    return redirect()->route('orders.show_pending_orders')->with('success', 'Order shipped successfully.');
}

    public function showAllShippedOrders()
    {
        // Retrieve only pending orders
        $orders = Order::where('pending', false)->where('is_delivered', false)->paginate(5);
        return view('administrator.shipping', compact('orders'));
    }

    public function markAsDelivered($orderId)
    {
        // Find the order by its ID
        $order = Order::find($orderId);

        // Check if the order exists
        if (!$order) {
            return false;
        }

        // Update the 'is_delivered' column to true
        $order->is_delivered = true;
        $order->pending = false;
        $order->save();

        return redirect()->route('orders.show_shipped_orders')->with('success', 'Order delivered successfully.');
    }

    
    public function showAllDeliveredOrders()
    {
        // Retrieve only pending orders
        $orders = Order::where('pending', false)->where('is_delivered', true)->paginate(5);
        return view('administrator.delivered', compact('orders'));
    }

    public function search(Request $request)
    {
        // Retrieve the search parameters from the request
        $status = $request->input('status');
        $flowerName = $request->input('flower_name');

        // Query to fetch orders based on search criteria
        $ordersQuery = Order::query();

        // Apply filters based on search criteria
        if ($status === 'pending') {
            $ordersQuery->where('pending', true)->where('is_delivered', false);
        } elseif ($status === 'delivered') {
            $ordersQuery->where('is_delivered', true)->where('pending', false);
        } elseif ($status === 'shipped') {
            $ordersQuery->where('pending', false)->where('is_delivered', false);
        }

        if ($flowerName) {
            $ordersQuery->whereHas('flower', function ($query) use ($flowerName) {
                $query->where('name', $flowerName);
            });
        }

        // Fetch paginated orders based on applied filters
        $orders = $ordersQuery->paginate(10);

        // Pass the filtered orders and search parameters to the view
        return view('customer.my_orders', [
            'orders' => $orders,
            'flowers' => Flower::all(), // Assuming Flower model is used and imported
            'status' => $status,
            'flowerName' => $flowerName, // Pass the $flowerName variable to the view
        ]);
    }

    public function exportToPDF(Request $request)
    {
        // Retrieve the search parameters from the request
        $status = $request->input('status');
        $flowerName = $request->input('flower_name');

        // Query to fetch orders based on search criteria
        $ordersQuery = Order::with('flower');

        // Apply filters based on search criteria
        if ($status) {
            $ordersQuery->where('pending', $status === 'pending')
                        ->where('is_delivered', $status === 'delivered');
        }

        if ($flowerName) {
            $ordersQuery->whereHas('flower', function ($query) use ($flowerName) {
                $query->where('name', $flowerName);
            });
        }

        // Fetch the searched orders
        $orders = $ordersQuery->latest()->get();

        $pdf = new Dompdf();
        $pdf->loadHtml(view('customer.my_orders_pdf', compact('orders'))->render());


        // Optionally, you can set additional configuration options for Dompdf here

        // Generate the PDF
        $pdf->render();

        // Return the PDF as a response
        return $pdf->stream('searched_orders.pdf');
    }

    public function reports(Request $request)
    {
        // Fetch all orders without pagination
        $ordersQuery = Order::with('flower')->latest();
    
        // Fetch the flower name from the request
        $flowerName = $request->input('flower_name');
    
        // Set the default value for status if not provided in the request
        $status = $request->input('status', 'any');
    
        // Apply filters based on search criteria
        if ($status === 'pending') {
            $ordersQuery->where('pending', true)->where('is_delivered', false);
        } elseif ($status === 'delivered') {
            $ordersQuery->where('is_delivered', true)->where('pending', false);
        } elseif ($status === 'shipped') {
            $ordersQuery->where('pending', false)->where('is_delivered', false);
        }
    
        if ($flowerName) {
            // Join the flowers table for searching by flower name
            $ordersQuery->join('flowers', 'orders.flower_id', '=', 'flowers.id')
                        ->where('flowers.name', 'LIKE', "%$flowerName%");
        }
    
    
        // Get all the orders matching the criteria
        $allOrders = $ordersQuery->get();
    
        // Initialize status counts for all orders
        $statusCounts = [
            'pending' => 0,
            'delivered' => 0,
            'shipped' => 0,
        ];
    
        // Count the occurrences of each status for all orders
        foreach ($allOrders as $order) {
            if ($order->pending) {
                $statusCounts['pending']++;
            } elseif ($order->is_delivered) {
                $statusCounts['delivered']++;
            } else {
                $statusCounts['shipped']++;
            }
        }
    
        // Prepare data for the pie chart
        $statusLabels = ['Pending', 'Delivered', 'Shipped'];
        $statusData = [
            $statusCounts['pending'],
            $statusCounts['delivered'],
            $statusCounts['shipped'],
        ];

        
        // Paginate the results for display
        $orders = $ordersQuery->paginate(10);
    
        // Pass the filtered orders, search parameters, and pie chart data to the view
        return view('administrator.reports', [
            'orders' => $orders,
            'flowers' => Flower::all(), 
            'status' => $status,
            'flowerName' => $flowerName,
            'statusLabels' => $statusLabels,
            'statusData' => $statusData,
        ]);
    }
    
    
    

    public function search_admin(Request $request)
    {
        $status = $request->input('status');
        $flowerName = $request->input('flower_name');
    
        $ordersQuery = Order::with('flower');
    
        // Join the flowers table for searching by flower name
        $ordersQuery->join('flowers', 'orders.flower_id', '=', 'flowers.id');
    
        // Apply filters based on search criteria
        if ($status === 'pending') {
            $ordersQuery->where('orders.pending', true)->where('orders.is_delivered', false);
        } elseif ($status === 'delivered') {
            $ordersQuery->where('orders.is_delivered', true)->where('orders.pending', false);
        } elseif ($status === 'shipped') {
            $ordersQuery->where('orders.pending', false)->where('orders.is_delivered', false);
        }
    
        if ($flowerName) {
            $ordersQuery->where('flowers.name', 'LIKE', "%$flowerName%");
        }
    
        // Get all the orders matching the criteria
        $allOrders = $ordersQuery->get();
    
        // Initialize status counts for the selected flower
        $statusCounts = [
            'pending' => 0,
            'delivered' => 0,
            'shipped' => 0,
        ];
    
        // Count the occurrences of each status for the selected flower
        foreach ($allOrders as $order) {
            if ($order->pending) {
                $statusCounts['pending']++;
            } elseif ($order->is_delivered) {
                $statusCounts['delivered']++;
            } else {
                $statusCounts['shipped']++;
            }
        }
    
        // Prepare data for the pie chart
        $statusLabels = ['Pending', 'Delivered', 'Shipped'];
        $statusData = [
            $statusCounts['pending'],
            $statusCounts['delivered'],
            $statusCounts['shipped'],
        ];
    
        // Paginate the results for display
        $orders = $ordersQuery->paginate(10);
    
        // Pass the filtered orders, search parameters, and pie chart data to the view
        return view('administrator.reports', [
            'orders' => $orders,
            'flowers' => Flower::all(), 
            'status' => $status,
            'flowerName' => $flowerName,
            'statusLabels' => $statusLabels,
            'statusData' => $statusData,
        ]);
    }
    

}
