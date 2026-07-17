<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            ['id' => 1, 'code' => 'ITEM-001', 'name' => 'Item 1', 'slug' => 'item-1', 'description' => 'Item 1 description', 'stock' => 10],
            ['id' => 2, 'code' => 'ITEM-002', 'name' => 'Item 2', 'slug' => 'item-2', 'description' => 'Item 2 description', 'stock' => 10],
            ['id' => 3, 'code' => 'ITEM-003', 'name' => 'Item 3', 'slug' => 'item-3', 'description' => 'Item 3 description', 'stock' => 10],
            ['id' => 4, 'code' => 'ITEM-004', 'name' => 'Item 4', 'slug' => 'item-4', 'description' => 'Item 4 description', 'stock' => 10],
            ['id' => 5, 'code' => 'ITEM-005', 'name' => 'Item 5', 'slug' => 'item-5', 'description' => 'Item 5 description', 'stock' => 10],
            ['id' => 6, 'code' => 'ITEM-006', 'name' => 'Item 6', 'slug' => 'item-6', 'description' => 'Item 6 description', 'stock' => 10],
            ['id' => 7, 'code' => 'ITEM-007', 'name' => 'Item 7', 'slug' => 'item-7', 'description' => 'Item 7 description', 'stock' => 10],
            ['id' => 8, 'code' => 'ITEM-008', 'name' => 'Item 8', 'slug' => 'item-8', 'description' => 'Item 8 description', 'stock' => 10],
            ['id' => 9, 'code' => 'ITEM-009', 'name' => 'Item 9', 'slug' => 'item-9', 'description' => 'Item 9 description', 'stock' => 10],
            ['id' => 10, 'code' => 'ITEM-010', 'name' => 'Item 10', 'slug' => 'item-10', 'description' => 'Item 10 description', 'stock' => 10],
            ['id' => 11, 'code' => 'ITEM-011', 'name' => 'Item 11', 'slug' => 'item-11', 'description' => 'Item 11 description', 'stock' => 10],
            ['id' => 12, 'code' => 'ITEM-012', 'name' => 'Item 12', 'slug' => 'item-12', 'description' => 'Item 12 description', 'stock' => 10],
            ['id' => 13, 'code' => 'ITEM-013', 'name' => 'Item 13', 'slug' => 'item-13', 'description' => 'Item 13 description', 'stock' => 10],
            ['id' => 14, 'code' => 'ITEM-014', 'name' => 'Item 14', 'slug' => 'item-14', 'description' => 'Item 14 description', 'stock' => 10],
            ['id' => 15, 'code' => 'ITEM-015', 'name' => 'Item 15', 'slug' => 'item-15', 'description' => 'Item 15 description', 'stock' => 10],
            ['id' => 16, 'code' => 'ITEM-016', 'name' => 'Item 16', 'slug' => 'item-16', 'description' => 'Item 16 description', 'stock' => 10],
            ['id' => 17, 'code' => 'ITEM-017', 'name' => 'Item 17', 'slug' => 'item-17', 'description' => 'Item 17 description', 'stock' => 10],
            ['id' => 18, 'code' => 'ITEM-018', 'name' => 'Item 18', 'slug' => 'item-18', 'description' => 'Item 18 description', 'stock' => 10],
            ['id' => 19, 'code' => 'ITEM-019', 'name' => 'Item 19', 'slug' => 'item-19', 'description' => 'Item 19 description', 'stock' => 10],
            ['id' => 20, 'code' => 'ITEM-020', 'name' => 'Item 20', 'slug' => 'item-20', 'description' => 'Item 20 description', 'stock' => 10],
        ];

        foreach ($items as $item) {
            Item::create($item);
        }
    }
}
