<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateOrderStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:update-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update order status based on time and shipping method';

    /**
     * Execute the console command.
     */
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
                $required = $order->shipping_method === 'express' ? 2 : 4; // 1+1, 1+3
                if ($days >= $required) {
                    $order->status = 'completed';
                    $order->save();
                }
            }
        }

        $this->info('Order status updated.');
    }
}
