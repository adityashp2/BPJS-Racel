<?php

namespace Database\Seeders;

use App\Models\JobDivision;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobDivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jobDivisions = [
            ['id' => 1, 'name' => 'Kepesertaan', 'slug' => 'kepesertaan', 'description' => 'Kepesertaan'],
            ['id' => 2, 'name' => 'Keuangan', 'slug' => 'keuangan', 'description' => 'Keuangan'],
            ['id' => 3, 'name' => 'Sekretaris', 'slug' => 'sekretaris', 'description' => 'Sekretaris'],
            ['id' => 4, 'name' => 'Pelayanan', 'slug' => 'pelayanan', 'description' => 'Pelayanan'],
            ['id' => 5, 'name' => 'Customer Service', 'slug' => 'customer-service', 'description' => 'Customer Service'],
            ['id' => 6, 'name' => 'Wasrik', 'slug' => 'wasrik', 'description' => 'Wasrik'],
        ];

        foreach ($jobDivisions as $jobDivision) {
            JobDivision::create($jobDivision);
        }
    }
}
