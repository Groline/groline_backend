<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\Invoice;
use App\Models\Item;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        // ─── Order 1 (user 1, region 1) ──────────────────
        $product1 = Product::where('name_fr', 'Mitigeur cuisine chrome Grohe')->first();
        $product2 = Product::where('name_fr', 'Lavabo suspendu Villeroy & Boch')->first();

        if ($product1 && $product2) {
            $cart1 = Cart::firstOrCreate(
                ['user_id' => 1, 'type' => 'order'],
                ['user_id' => 1, 'type' => 'order']
            );

            Item::firstOrCreate(
                ['cart_id' => $cart1->id, 'product_id' => $product1->id],
                [
                    'name_fr' => $product1->name_fr,
                    'name_ar' => $product1->name_ar,
                    'name_en' => $product1->name_en,
                    'unit_price' => $product1->unit_price,
                    'pack_price' => $product1->pack_price,
                    'pack_units' => $product1->pack_units,
                    'type' => 'unit',
                    'quantity' => 2,
                    'discount' => 0,
                    'amount' => $product1->unit_price * 2,
                ]
            );

            Item::firstOrCreate(
                ['cart_id' => $cart1->id, 'product_id' => $product2->id],
                [
                    'name_fr' => $product2->name_fr,
                    'name_ar' => $product2->name_ar,
                    'name_en' => $product2->name_en,
                    'unit_price' => $product2->unit_price,
                    'pack_price' => $product2->pack_price,
                    'pack_units' => $product2->pack_units,
                    'type' => 'unit',
                    'quantity' => 1,
                    'discount' => 0,
                    'amount' => $product2->unit_price,
                ]
            );

            $order1 = Order::firstOrCreate(
                ['cart_id' => $cart1->id],
                [
                    'user_id' => 1,
                    'region_id' => 1,
                    'phone' => '0555123456',
                    'status' => 'pending',
                    'longitude' => 3.0588,
                    'latitude' => 36.7538,
                    'delivery_time' => now(),
                    'note' => 'Livrer le matin si possible.',
                ]
            );

            Invoice::firstOrCreate(
                ['order_id' => $order1->id],
                [
                    'purchase_amount' => $cart1->items()->sum('amount'),
                    'tax_amount' => 0,
                    'discount_amount' => 0,
                    'total_amount' => $cart1->items()->sum('amount'),
                    'is_paid' => 'no',
                    'payment_method' => 'cash',
                ]
            );
        }

        // ─── Order 2 (user 2, region 1) ──────────────────
        $product3 = Product::where('name_fr', 'Tube PVC 32mm (3 mètres)')->first();
        $product4 = Product::where('name_fr', 'Robinet d\'arrêt 15/21')->first();

        if ($product3 && $product4) {
            $cart2 = Cart::firstOrCreate(
                ['user_id' => 2, 'type' => 'order'],
                ['user_id' => 2, 'type' => 'order']
            );

            Item::firstOrCreate(
                ['cart_id' => $cart2->id, 'product_id' => $product3->id],
                [
                    'name_fr' => $product3->name_fr,
                    'name_ar' => $product3->name_ar,
                    'name_en' => $product3->name_en,
                    'unit_price' => $product3->unit_price,
                    'pack_price' => $product3->pack_price,
                    'pack_units' => $product3->pack_units,
                    'type' => 'unit',
                    'quantity' => 5,
                    'discount' => 0,
                    'amount' => $product3->unit_price * 5,
                ]
            );

            Item::firstOrCreate(
                ['cart_id' => $cart2->id, 'product_id' => $product4->id],
                [
                    'name_fr' => $product4->name_fr,
                    'name_ar' => $product4->name_ar,
                    'name_en' => $product4->name_en,
                    'unit_price' => $product4->unit_price,
                    'pack_price' => $product4->pack_price,
                    'pack_units' => $product4->pack_units,
                    'type' => 'unit',
                    'quantity' => 3,
                    'discount' => 0,
                    'amount' => $product4->unit_price * 3,
                ]
            );

            $order2 = Order::firstOrCreate(
                ['cart_id' => $cart2->id],
                [
                    'user_id' => 2,
                    'region_id' => 1,
                    'phone' => '0555987654',
                    'status' => 'accepted',
                    'longitude' => 3.0520,
                    'latitude' => 36.7500,
                    'delivery_time' => now()->addDays(2),
                    'note' => null,
                ]
            );

            Invoice::firstOrCreate(
                ['order_id' => $order2->id],
                [
                    'purchase_amount' => $cart2->items()->sum('amount'),
                    'tax_amount' => 0,
                    'discount_amount' => 0,
                    'total_amount' => $cart2->items()->sum('amount'),
                    'is_paid' => 'no',
                    'payment_method' => 'cash',
                ]
            );
        }

        // ─── Order 3 (user 3, region 2) ──────────────────
        $product5 = Product::where('name_fr', 'Chauffe-eau électrique 50L')->first();

        if ($product5) {
            $cart3 = Cart::firstOrCreate(
                ['user_id' => 3, 'type' => 'order'],
                ['user_id' => 3, 'type' => 'order']
            );

            Item::firstOrCreate(
                ['cart_id' => $cart3->id, 'product_id' => $product5->id],
                [
                    'name_fr' => $product5->name_fr,
                    'name_ar' => $product5->name_ar,
                    'name_en' => $product5->name_en,
                    'unit_price' => $product5->unit_price,
                    'pack_price' => $product5->pack_price,
                    'pack_units' => $product5->pack_units,
                    'type' => 'unit',
                    'quantity' => 1,
                    'discount' => 0,
                    'amount' => $product5->unit_price,
                ]
            );

            $order3 = Order::firstOrCreate(
                ['cart_id' => $cart3->id],
                [
                    'user_id' => 3,
                    'region_id' => 2,
                    'phone' => '0555222333',
                    'status' => 'delivered',
                    'longitude' => -0.6382,
                    'latitude' => 35.6969,
                    'delivery_time' => now()->subDays(3),
                    'note' => 'Appeler avant livraison.',
                ]
            );

            Invoice::firstOrCreate(
                ['order_id' => $order3->id],
                [
                    'purchase_amount' => $cart3->items()->sum('amount'),
                    'tax_amount' => 0,
                    'discount_amount' => 0,
                    'total_amount' => $cart3->items()->sum('amount'),
                    'is_paid' => 'yes',
                    'paid_at' => now()->subDays(3),
                    'payment_method' => 'cash',
                ]
            );
        }
    }
}
