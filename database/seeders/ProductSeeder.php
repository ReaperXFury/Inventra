<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductSeeder extends Seeder
{
    private array $colors = [
        'Beverages'      => [37, 99, 235],
        'Snacks'         => [234, 88, 12],
        'Noodles'        => [202, 138, 4],
        'Canned Goods'   => [220, 38, 38],
        'Condiments'     => [147, 51, 234],
        'Rice & Grains'  => [22, 163, 74],
        'Toiletries'     => [8, 145, 178],
        'Household'      => [71, 85, 105],
        'Dairy & Eggs'   => [219, 39, 119],
    ];

    public function run(): void
    {
        Storage::disk('public')->makeDirectory('products');
        $now = now();

        foreach ($this->products() as $i => [$name, $category, $cost, $price, $stock, $min]) {
            $sku  = sprintf('SKU-%04d', 1001 + $i);
            $path = "products/{$sku}.png";

            Storage::disk('public')->put($path, $this->makeImage($name, $category));

            DB::table('products')->updateOrInsert(
                ['sku' => $sku],
                [
                    'name'            => $name,
                    'category'        => $category,
                    'cost_price'      => $cost,
                    'selling_price'   => $price,
                    'stock_quantity'  => $stock,
                    'min_stock_level' => $min,
                    'photo_path'      => $path,
                    'is_active'       => 1,
                    'created_at'      => $now,
                    'updated_at'      => $now,
                ]
            );
        }
    }

    private function makeImage(string $name, string $category): string
    {
        [$r, $g, $b] = $this->colors[$category] ?? [71, 85, 105];

        $img   = imagecreatetruecolor(400, 400);
        $bg    = imagecolorallocate($img, $r, $g, $b);
        $dark  = imagecolorallocate($img, (int) ($r * 0.7), (int) ($g * 0.7), (int) ($b * 0.7));
        $white = imagecolorallocate($img, 255, 255, 255);
        imagefill($img, 0, 0, $bg);

        // Initials: draw small, then scale up so the text is big
        $words    = preg_split('/\s+/', trim(preg_replace('/[^A-Za-z0-9 ]/', '', $name)));
        $initials = strtoupper(substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));

        $small = imagecreatetruecolor(40, 30);
        imagefill($small, 0, 0, imagecolorallocate($small, $r, $g, $b));
        imagestring($small, 5, (int) ((40 - 9 * strlen($initials)) / 2), 7, $initials,
            imagecolorallocate($small, 255, 255, 255));
        imagecopyresized($img, $small, 80, 40, 0, 0, 240, 180, 40, 30);

        // Bottom band with category and product name
        imagefilledrectangle($img, 0, 270, 400, 400, $dark);

        $cat = strtoupper($category);
        imagestring($img, 3, (int) ((400 - 7 * strlen($cat)) / 2), 282, $cat, $white);

        $y = 310;
        foreach (explode("\n", wordwrap($name, 32, "\n", true)) as $line) {
            imagestring($img, 5, (int) ((400 - 9 * strlen($line)) / 2), $y, $line, $white);
            $y += 24;
        }

        ob_start();
        imagepng($img);

        return ob_get_clean();
    }

    // [name, category, cost, selling price, stock, min stock level]
    private function products(): array
    {
        return [
            // Beverages
            ['Coca-Cola 1.5L', 'Beverages', 58, 70, 24, 6],
            ['Sprite 1.5L', 'Beverages', 58, 70, 20, 6],
            ['Royal Tru-Orange 1L', 'Beverages', 34, 42, 18, 6],
            ['C2 Green Tea Apple 230ml', 'Beverages', 14, 18, 36, 10],
            ['Bottled Water 500ml', 'Beverages', 8, 12, 48, 12],
            ['Milo Sachet 24g', 'Beverages', 8, 11, 60, 15],
            ['Nescafe 3-in-1 Original 26g', 'Beverages', 6, 8, 3, 10],
            ['Great Taste White Sachet 30g', 'Beverages', 5.5, 7.5, 80, 20],

            // Snacks
            ['Piattos Cheese 40g', 'Snacks', 15, 20, 30, 8],
            ['Nova Country Cheddar 40g', 'Snacks', 15, 20, 28, 8],
            ['Chippy BBQ 27g', 'Snacks', 8, 11, 45, 10],
            ['Oishi Prawn Crackers 60g', 'Snacks', 12, 16, 25, 8],
            ['Skyflakes Crackers 10s', 'Snacks', 22, 28, 20, 6],
            ['Fita Crackers 10s', 'Snacks', 20, 26, 4, 6],
            ['Cloud 9 Chocolate Bar 20g', 'Snacks', 6, 8, 50, 12],

            // Noodles
            ['Lucky Me Pancit Canton Original 60g', 'Noodles', 12, 16, 70, 15],
            ['Lucky Me Beef Na Beef 55g', 'Noodles', 8.5, 11, 55, 15],
            ['Lucky Me Chicken Mami 55g', 'Noodles', 8.5, 11, 52, 15],
            ['Nissin Cup Noodles Seafood 40g', 'Noodles', 24, 30, 15, 5],

            // Canned Goods
            ['Ligo Sardines Green 155g', 'Canned Goods', 18, 23, 40, 10],
            ['555 Sardines Tomato 155g', 'Canned Goods', 17, 22, 38, 10],
            ['Argentina Corned Beef 150g', 'Canned Goods', 32, 40, 22, 6],
            ['Century Tuna Flakes in Oil 155g', 'Canned Goods', 32, 40, 2, 6],
            ["Hunt's Pork & Beans 230g", 'Canned Goods', 24, 31, 18, 6],

            // Condiments
            ['Datu Puti Soy Sauce 385ml', 'Condiments', 14, 18, 30, 8],
            ['Datu Puti Vinegar 385ml', 'Condiments', 12, 16, 30, 8],
            ['UFC Banana Ketchup 320g', 'Condiments', 22, 28, 24, 6],
            ['Knorr Sinigang Mix 22g', 'Condiments', 7, 10, 45, 12],
            ['Ajinomoto 50g', 'Condiments', 8, 11, 40, 10],
            ['Iodized Salt 500g', 'Condiments', 10, 14, 35, 10],
            ['Silver Swan Patis 385ml', 'Condiments', 13, 17, 5, 8],

            // Rice & Grains
            ['Sinandomeng Rice 1kg', 'Rice & Grains', 46, 54, 100, 25],
            ['Jasmine Rice 1kg', 'Rice & Grains', 55, 65, 80, 20],
            ['Baguio Cooking Oil 1L', 'Rice & Grains', 75, 90, 24, 6],
            ['White Sugar 1kg', 'Rice & Grains', 70, 82, 30, 8],
            ['Brown Sugar 1kg', 'Rice & Grains', 62, 72, 28, 8],
            ['Bihon Pancit 227g', 'Rice & Grains', 28, 35, 16, 5],

            // Toiletries
            ['Safeguard Bar Soap 60g', 'Toiletries', 22, 28, 30, 8],
            ['Head & Shoulders Sachet 12ml', 'Toiletries', 5, 7, 90, 20],
            ['Colgate Toothpaste 50g', 'Toiletries', 28, 35, 20, 6],
            ['Surf Powder Sachet 66g', 'Toiletries', 8, 11, 60, 15],
            ['Downy Sachet 20ml', 'Toiletries', 5.5, 7.5, 70, 15],
            ['Reach Toothbrush', 'Toiletries', 20, 28, 3, 6],

            // Household
            ['Zonrox Bleach 250ml', 'Household', 14, 18, 25, 8],
            ['Joy Dishwashing Liquid 250ml', 'Household', 30, 38, 18, 6],
            ['Matchbox 10s', 'Household', 6, 9, 40, 10],
            ['Garbage Bags Medium 10s', 'Household', 25, 35, 15, 5],

            // Dairy & Eggs
            ['Alaska Evaporada 154ml', 'Dairy & Eggs', 16, 21, 32, 8],
            ['Alaska Condensada 300ml', 'Dairy & Eggs', 32, 41, 20, 6],
            ['Fresh Eggs Medium (1pc)', 'Dairy & Eggs', 8, 10, 90, 30],
        ];
    }
}