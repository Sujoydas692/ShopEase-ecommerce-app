<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $districts = [
            "Bagerhat", "Bandarban", "Borguna", "Barishal", "Bhola",
            "Bogra", "B. Baria", "Chandpur", "Chapai Nawabganj",
            "Chattogram", "Chuadanga", "Cox's Bazar", "Comilla",
            "Dhaka", "Dinajpur", "Faridpur", "Feni", "Gaibandha",
            "Gazipur", "Gopalgonj", "Hobigonj", "Jamalpur", "Jessore",
            "Jhalokathi", "Jhenaidah", "Joypurhat", "Khagrachari",
            "Khulna", "Kishoregonj", "Kurigram", "Kushtia",
            "Laxmipur", "Lalmonirhat", "Madaripur", "Magura",
            "Manikgonj", "Meherpur", "Mowlovibazar", "Munshigonj",
            "Mymensingh", "Naogaon", "Norail", "Narayanganj",
            "Narsingdi", "Natore", "Netrakona", "Nilphamari",
            "Noakhali", "Pabna", "Panchagarh", "Patuakhali",
            "Pirojpur", "Rajbari", "Rajshahi", "Rangamati",
            "Rangpur", "Satkhira", "Shariatpur", "Sherpur",
            "Sirajgonj", "Sunamgonj", "Sylhet", "Tangail", "Thakurgaon"
        ];

        foreach ($districts as $district) {
            DB::table('districts')->insert([
                'name' => $district
            ]);
        }
    }
}
