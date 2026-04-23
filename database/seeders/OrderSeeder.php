<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Book;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $books = Book::all();
        $users = User::all();
        
        if ($books->isEmpty()) {
            $this->command->warn('No books found. Please seed books first.');
            return;
        }

        $statuses = ['pending', 'processing', 'shipped', 'completed', 'cancelled'];
        $paymentMethods = ['transfer', 'cod', 'ewallet', 'credit_card'];
        $paymentStatuses = ['unpaid', 'paid'];
        
        $customers = [
            ['name' => 'Budi Santoso', 'email' => 'budi@example.com', 'phone' => '08123456789'],
            ['name' => 'Siti Rahmawati', 'email' => 'siti@example.com', 'phone' => '08198765432'],
            ['name' => 'Ahmad Wijaya', 'email' => 'ahmad@example.com', 'phone' => '08123123123'],
            ['name' => 'Dewi Lestari', 'email' => 'dewi@example.com', 'phone' => '08187654321'],
            ['name' => 'Eko Prasetyo', 'email' => 'eko@example.com', 'phone' => '08156789012'],
            ['name' => 'Rina Susanti', 'email' => 'rina@example.com', 'phone' => '08134567890'],
            ['name' => 'Joko Widodo', 'email' => 'joko@example.com', 'phone' => '08145678901'],
            ['name' => 'Maya Anindita', 'email' => 'maya@example.com', 'phone' => '08167890123'],
        ];

        foreach ($customers as $index => $customer) {
            $user = $users->random();
            
            $order = Order::create([
                'user_id' => $user->id,
                'order_number' => 'ORD-' . date('Ymd') . '-' . str_pad($index + 1, 4, '0', STR_PAD_LEFT),
                'total_amount' => 0,
                'status' => $statuses[array_rand($statuses)],
                'payment_method' => $paymentMethods[array_rand($paymentMethods)],
                'payment_status' => $paymentStatuses[array_rand($paymentStatuses)],
                'customer_name' => $customer['name'],
                'customer_email' => $customer['email'],
                'customer_phone' => $customer['phone'],
                'shipping_address' => 'Jl. ' . ['Sudirman', 'Thamrin', 'Gatot Subroto', 'Asia Afrika'][array_rand(['Sudirman', 'Thamrin', 'Gatot Subroto', 'Asia Afrika'])] . ' No. ' . rand(1, 200) . ', Jakarta ' . ['Pusat', 'Selatan', 'Barat', 'Timur'][array_rand(['Pusat', 'Selatan', 'Barat', 'Timur'])],
                'notes' => rand(0, 1) ? 'Tolong kirim dengan bubble wrap. Terima kasih!' : null,
                'created_at' => now()->subDays(rand(0, 7)),
            ]);

            // Add random items to order
            $itemCount = rand(1, 4);
            $totalAmount = 0;

            $availableBooks = $books->where('price', '>', 0);
            
            if ($availableBooks->isEmpty()) {
                $this->command->warn('No books with prices found for order ' . $order->order_number);
                continue;
            }

            for ($i = 0; $i < $itemCount; $i++) {
                $book = $availableBooks->random();
                $quantity = rand(1, 3);
                $price = $book->price ?? 50000;
                $subtotal = $price * $quantity;

                OrderItem::create([
                    'order_id' => $order->id,
                    'book_id' => $book->id,
                    'quantity' => $quantity,
                    'price' => $price,
                    'subtotal' => $subtotal,
                ]);

                $totalAmount += $subtotal;
            }

            $order->update(['total_amount' => $totalAmount]);
        }

        $this->command->info('Created ' . count($customers) . ' sample orders.');
    }
}
