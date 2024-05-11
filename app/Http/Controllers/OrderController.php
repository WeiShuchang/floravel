<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Flower;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use Illuminate\Http\Request;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   
     public function index()
     {
         // Fetch the list of flowers for sale along with their suppliers
         $flowers = Flower::latest()->paginate(6);
     
         // Pass the paginated flowers list to the view
         return view('customer.flowers_list', compact('flowers'));
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
            'flower_id' => 'required|exists:flowers,id',
            'quantity' => ['required', 'integer', 'min:1'],
            'shipping_address' => 'required|string|max:255',
        ]);

        // Retrieve the flower object from the database
        $flower = Flower::findOrFail($validatedData['flower_id']);

        // Check if the requested quantity exceeds available stocks
        if ($validatedData['quantity'] > $flower->stocks) {
            return redirect()->back()->withErrors(['quantity' => 'The requested quantity exceeds available stocks.'])->withInput();
            // The `withInput()` method will flash the old input data to the session
        }

        // Create the order
        $order = new Order();
        $order->user_id = auth()->id(); // Associate the current user with the order
        $order->flower_id = $validatedData['flower_id'];
        $order->quantity = $validatedData['quantity'];
        $order->shipping_address = $validatedData['shipping_address'];
        $order->total_amount = $validatedData['quantity'] * $flower->price;
        $order->save();

        // Redirect with success message
        return redirect()->route('orders.index')->with('success', 'Order placed successfully.');
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
                        ->where('is_cancelled', false)
                        ->where('is_confirmed', false)
                        ->latest()
                        ->paginate(10);
    
        return view('customer.my_orders', compact('orders', 'flowers', 'status', 'flowerName'));
    }
    

    public function showAllPendingOrders()
    {
        // Retrieve only pending orders
        $orders = Order::where('pending', true)->where('is_delivered', false)->where('is_cancelled', false)->latest()->paginate(5);
        return view('administrator.orders_list', compact('orders'));
    }

    public function ship($orderId)
    {
        // Find the order by its ID
        $order = Order::find($orderId);
    
        if (!$order) {
            return response()->json(['message' => 'Order not found.'], 404);
        }
    
        // Deduct the quantity from the stocks of the flower
        $flower = $order->flower;
        $flower->stocks -= $order->quantity;
        $flower->save();

        $order->pending = false;
        $order->save();
    
        // You can add any other necessary logic for shipping here, like updating the order status, etc.
    
        return redirect()->route('orders.show_pending_orders')->with('success', 'Order shipped successfully.');
    }
   

    public function showAllShippedOrders()
    {
        // Retrieve only pending orders
        $orders = Order::where('pending', false)->where('is_delivered', false)->where('is_cancelled', false)->where('is_confirmed', false)->latest()->paginate(5);
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
        $orders = Order::where('pending', false)->where('is_delivered', true)->latest()->paginate(5);
        return view('administrator.delivered', compact('orders'));
    }




    //Eto search sa myorders ng User
    public function search(Request $request)
    {
        // Retrieve the search parameters from the request
        $status = $request->input('status');
        $flowerName = $request->input('flower_name');
        $user = auth()->user();

        // Query to fetch orders based on search criteria
        $ordersQuery = Order::with('flower')
        ->where('is_cancelled', false)
        ->where('is_confirmed', false)
        ->where('user_id', $user->id)
        ->latest('orders.created_at');

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

    //eto pag-export sa my_orders_pdf.blade.php
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
    // Get the current date
    $currentDate = date('F j, Y'); 
    // Create a new Dompdf instance
    $pdf = new Dompdf();
    // Load HTML content into Dompdf
    $pdf->loadHtml(view('customer.my_orders_pdf', compact('orders', 'currentDate'))->render());
    // Render PDF
    $pdf->render();
    // Logo para sa na-export na file
    $logos = [
        [
            'path' => public_path('images/logo.png'),
            'position' => ['x' => 2, 'y' => 5],
            'size' => ['width' => 220, 'height' => 80]
        ],
        [
            'path' => public_path('images/logo.png'),
            'position' => ['x' => 400, 'y' => 5],
            'size' => ['width' => 220, 'height' => 80]
        ],
      
    ];

    // Add the logos to the PDF
    foreach ($logos as $logo) {
        $pdf->getCanvas()->image(
            $logo['path'], 
            $logo['position']['x'], 
            $logo['position']['y'], 
            $logo['size']['width'], 
            $logo['size']['height']
        );
    }

    // Return the PDF as a response
    return $pdf->stream('searched_orders.pdf');
}

    //dito ung reports sa admin side
    public function reports(Request $request)
    {
        // Fetch all orders without pagination
        $ordersQuery = Order::with('flower')->where('is_cancelled', false)->with('user')->latest();
    
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

    //eto ung search sa admin reports
    public function search_admin(Request $request)
    {
        $status = $request->input('status');
        $flowerName = $request->input('flower_name');
    
        $ordersQuery = Order::with('flower')->where('is_cancelled', false)->latest('orders.created_at');
    
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
    

    //eto un cancel para sa admin, sinisave niya ung reason ng cancel
    public function cancel($orderId)
{
    $order = Order::findOrFail($orderId);
    $order->is_cancelled = true;
    $order->notify_cancel = true;
    $order->pending = false;
    $order->cancel_reason = request('cancel_reason');
    $order->save();

    return redirect()->back()->with('success', 'Order has been canceled successfully.');
}


//eto naman pag nag-cancel ung user
public function cancel_user($orderId)
{
    $order = Order::findOrFail($orderId);
    $order->is_cancelled = true;
    $order->pending = false;
    $order->cancel_reason = request('cancel_reason');
    $order->save();

    return redirect()->route('orders.my_orders')->with('success', 'Order has been canceled successfully.');
}

    //Eto para mapunta user sa cancel form at ilagay reason for cancelling
    public function showCancelForm($id)
    {
        // Retrieve the order based on the provided ID
        $order = Order::findOrFail($id);

        // Pass the order information to the cancel order form view
        return view('customer.cancel_user_order')->with('order', $order);
    }

    //eto para mawala ung "Your Order Has Been Cancelled" na modal pag clinick
    public function notifyCancelled()
{
    // Update notify_cancel to 0 for all orders belonging to the current user
    $user = Auth::user();
    $user->orders()->update(['notify_cancel' => 0]);

    $orders = Order::with('flower') // Eager load the flower relationship
    ->where('user_id', $user->id)
    ->where('is_cancelled', true)
    ->latest()
    ->paginate(10);

    return view('customer.order_history', compact('orders'));
}

    //Para makita ng user ung cancelled at confirmed na order niya
public function viewOrderHistory(){
    // Update notify_cancel to 0 for all orders belonging to the current user
    $user = Auth::user();

    $orders = Order::with('flower') // Eager load the flower relationship
                ->where('user_id', $user->id)
                ->where(function($query) {
                    $query->where('is_cancelled', true)
                          ->orWhere('is_confirmed', true);
                })
                ->latest()
                ->paginate(10);

    return view('customer.order_history', compact('orders'));
}

    //para inconfirm ng user na nadeliver nga ung flower
public function confirmDelivery(Request $request, $orderId)
    {
        // Find the order by ID
        $order = Order::findOrFail($orderId);

        // Update order status
        $order->pending = false;
        $order->is_cancelled = false;
        $order->is_confirmed = true;

        // Save the changes
        $order->save();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Order delivery confirmed successfully.');
    }

    //para makita ni admin lahat ng confirmed at cancelled na order ng lahat ng users
    public function adminOrderHistory()
    {

        $orders = Order::with('flower') // Eager load the flower relationship
                    ->where(function($query) {
                        $query->where('is_cancelled', true)
                            ->orWhere('is_confirmed', true);
                    })
                    ->latest()
                    ->paginate(10);

        return view('administrator.admin_order_history', compact('orders'));
    }



}
