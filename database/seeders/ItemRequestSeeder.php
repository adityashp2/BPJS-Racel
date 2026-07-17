<?php

namespace Database\Seeders;

use App\Models\ItemRequest;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ItemRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        if ($users->count() > 0) {
            $itemRequests = [
                [
                    'requested_by' => $users->random()->id,
                    'name' => 'Laptop Dell Inspiron 15',
                    'description' => 'Laptop untuk keperluan kerja sehari-hari dengan spesifikasi Intel Core i5, RAM 8GB, SSD 256GB. Dibutuhkan untuk menunjang produktivitas tim IT.',
                    'status' => 'pending',
                    'request_date' => now()->subDays(2),
                    'created_at' => now()->subDays(2),
                    'updated_at' => now()->subDays(2),
                ],
                [
                    'requested_by' => $users->random()->id,
                    'name' => 'Printer Canon PIXMA',
                    'description' => 'Printer multifungsi untuk keperluan cetak dokumen kantor. Dibutuhkan fitur print, scan, dan copy dengan kualitas hasil yang baik.',
                    'status' => 'approved',
                    'request_date' => now()->subDays(5),
                    'created_at' => now()->subDays(5),
                    'updated_at' => now()->subDays(3),
                ],
                [
                    'requested_by' => $users->random()->id,
                    'name' => 'Monitor LED 24 inch',
                    'description' => 'Monitor tambahan untuk dual screen setup. Resolusi minimal Full HD 1920x1080, dengan port HDMI dan VGA.',
                    'status' => 'rejected',
                    'request_date' => now()->subDays(7),
                    'created_at' => now()->subDays(7),
                    'updated_at' => now()->subDays(4),
                ],
                [
                    'requested_by' => $users->random()->id,
                    'name' => 'Webcam Logitech C920',
                    'description' => 'Webcam untuk keperluan meeting online dan video conference. Kualitas video HD 1080p dengan mikrofon built-in.',
                    'status' => 'pending',
                    'request_date' => now()->subDays(1),
                    'created_at' => now()->subDays(1),
                    'updated_at' => now()->subDays(1),
                ],
                [
                    'requested_by' => $users->random()->id,
                    'name' => 'Kursi Kantor Ergonomis',
                    'description' => 'Kursi kantor dengan desain ergonomis untuk menunjang kenyamanan kerja. Dilengkapi dengan penyangga punggung dan lengan yang dapat disesuaikan.',
                    'status' => 'approved',
                    'request_date' => now()->subDays(10),
                    'created_at' => now()->subDays(10),
                    'updated_at' => now()->subDays(8),
                ],
                [
                    'requested_by' => $users->random()->id,
                    'name' => 'Headset Wireless',
                    'description' => 'Headset wireless untuk keperluan komunikasi dan meeting online. Dengan noise cancelling dan battery life minimal 8 jam.',
                    'status' => 'pending',
                    'request_date' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ];

            foreach ($itemRequests as $request) {
                ItemRequest::create($request);
            }
        }
    }
}
