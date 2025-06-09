<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\Order;

class UpdateOrderStatus extends Command
{
    protected $signature = 'orders:update-status';

    protected $description = 'Update order status based on time and shipping method';

    public function handle()
    {
        $now = Carbon::now();

        $orders = Order::whereIn('status', ['pending', 'processing'])->get();

        foreach ($orders as $order) {
            if (!$order->payment_confirmed_at) continue;

            $days = $order->payment_confirmed_at->diffInDays($now);

            if ($order->status === 'pending' && $days >= 1) {
                $order->status = 'processing';
                $order->save();
            } elseif ($order->status === 'processing') {
                $required = $order->shipping_method === 'express' ? 2 : 4;
                if ($days >= $required) {
                    $order->status = 'completed';
                    $order->save();
                }
            }
        }

        $this->info('Order status updated.');
    }
}
