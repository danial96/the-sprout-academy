<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locations = [
            [
                'name' => 'SEMINOLE',
                'slug' => 'seminole',
                'address' => '9259 Park Blvd, Seminole, FL 33777',
                'phone' => '727-399-2483',
                'fax' => '',
                'email' => 'seminole@sproutacademy.com',
                'hours_of_operation' => 'Monday-Friday – 7:00 a.m. to 6:00 p.m (toddlers 7:30 a.m. to 5:30 p.m.)',
                'google_maps_address' => '9259 Park Blvd, Seminole, FL 33777',
                'virtual_tour_image' => null, // Will be uploaded via admin
                'virtual_tour_label' => 'FRONT OFFICE',
                'home_page_image' => null, // Will be uploaded via admin
                'display_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'ST. PETERSBURG',
                'slug' => 'st-petersburg',
                'address' => '5610 54th Ave N., St Petersburg, FL 33709',
                'phone' => '727-541-6260',
                'fax' => '',
                'email' => 'Sheena@the-sprout-academy.com',
                'hours_of_operation' => 'Monday-Friday – 6:30 a.m. to 6:00 p.m',
                'google_maps_address' => '5610 54th Ave N., St Petersburg, FL 33709',
                'virtual_tour_image' => null,
                'virtual_tour_label' => null,
                'home_page_image' => null,
                'display_order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'PINELLAS PARK',
                'slug' => 'pinellas-park',
                'address' => '6552 84th Ave. N., Pinellas Park, FL 33781',
                'phone' => '727-545-9944',
                'fax' => '',
                'email' => 'pinellaspark@sproutacademy.com',
                'hours_of_operation' => 'Monday - Friday: 6:30 AM - 6:00 PM',
                'google_maps_address' => '6552 84th Ave. N., Pinellas Park, FL 33781',
                'virtual_tour_image' => null,
                'virtual_tour_label' => 'FRONT DOOR',
                'home_page_image' => null,
                'display_order' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'MONTESSORI',
                'slug' => 'montessori',
                'address' => '2095 Belleair Road, Clearwater, FL 33764',
                'phone' => '727-535-8512',
                'fax' => '',
                'email' => 'montessori@sproutacademy.com',
                'hours_of_operation' => 'Monday - Friday: 7:00 AM - 6:00 PM',
                'google_maps_address' => '2095 Belleair Road, Clearwater, FL 33764',
                'virtual_tour_image' => null,
                'virtual_tour_label' => 'ENTRY DOOR',
                'home_page_image' => null,
                'display_order' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'LARGO',
                'slug' => 'largo',
                'address' => '1807 S Highland Ave, Largo, FL 33756',
                'phone' => '727-559-1777',
                'fax' => '',
                'email' => 'largo@sproutacademy.com',
                'hours_of_operation' => 'Monday - Friday: 6:30 AM - 6:00 PM',
                'google_maps_address' => '1807 S Highland Ave, Largo, FL 33756',
                'virtual_tour_image' => null,
                'virtual_tour_label' => 'FRONT DOOR',
                'home_page_image' => null,
                'display_order' => 6,
                'is_active' => true,
            ],
        ];

        foreach ($locations as $location) {
            Location::create($location);
        }
    }
}
