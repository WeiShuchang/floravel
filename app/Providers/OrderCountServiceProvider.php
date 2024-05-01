<?php

// app/Providers/OrderCountServiceProvider.php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Order;
use Illuminate\Support\Facades\View;

class OrderCountServiceProvider extends ServiceProvider
{
    public function boot()
    {
        View::composer('*', function ($view) {
            $user = auth()->user();

            $pendingCount = 0;
            $shippingCount = 0;
            $deliveredCount = 0;
            if ($user) {
            $pendingCount = Order::where('user_id', $user->id)
                                ->where('pending', true)
                                ->count();
            $shippingCount = Order::where('user_id', $user->id)
                                ->where('pending', false)
                                ->where('is_delivered', false)
                                ->count();
            $deliveredCount = Order::where('user_id', $user->id)
                                ->where('pending', false)
                                ->where('is_delivered', true)
                                ->count();
            }

            $view->with('pendingCount', $pendingCount)
                 ->with('shippingCount', $shippingCount)
                 ->with('deliveredCount', $deliveredCount);
        });
    }

    public function register()
    {
        //
    }
}
