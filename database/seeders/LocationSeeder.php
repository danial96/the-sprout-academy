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
                'address' => '7985 113th St N, Seminole, FL 33772',
                'phone' => '(727) 953-5544',
                'fax' => '(727) 953-5545',
                'email' => 'seminole@sproutacademy.com',
                'hours_of_operation' => 'Monday-Friday – 7:00 a.m. to 6:00 p.m (toddlers 7:30 a.m. to 5:30 p.m.)',
                'google_maps_address' => '7985 113th St N, Seminole, FL 33772',
                'virtual_tour_image' => null, // Will be uploaded via admin
                'virtual_tour_label' => 'FRONT OFFICE',
                'home_page_image' => null, // Will be uploaded via admin
                'display_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'ST. PETERSBURG',
                'slug' => 'st-petersburg',
                'address' => '1100 1st Ave N, St. Petersburg, FL 33701',
                'phone' => '727-541-6260',
                'fax' => '727-851-9975',
                'email' => 'Sheena@the-sprout-academy.com',
                'hours_of_operation' => 'Monday-Friday – 6:30 a.m. to 6:00 p.m',
                'google_maps_address' => '1100 1st Ave N, St. Petersburg, FL 33701',
                'virtual_tour_image' => null,
                'virtual_tour_label' => null,
                'home_page_image' => null,
                'display_order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'PINELLAS PARK',
                'slug' => 'pinellas-park',
                'address' => '5995 Park Blvd, Pinellas Park, FL 33781',
                'phone' => '(727) 544-5437',
                'fax' => '(727) 544-5438',
                'email' => 'pinellaspark@sproutacademy.com',
                'hours_of_operation' => 'Monday - Friday: 6:30 AM - 6:00 PM',
                'google_maps_address' => '5995 Park Blvd, Pinellas Park, FL 33781',
                'virtual_tour_image' => null,
                'virtual_tour_label' => 'FRONT DOOR',
                'home_page_image' => null,
                'display_order' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'MONTESSORI',
                'slug' => 'montessori',
                'address' => '2255 Countryside Blvd, Clearwater, FL 33763',
                'phone' => '(727) 799-7687',
                'fax' => '(727) 799-7688',
                'email' => 'montessori@sproutacademy.com',
                'hours_of_operation' => 'Monday - Friday: 7:00 AM - 6:00 PM',
                'google_maps_address' => '2255 Countryside Blvd, Clearwater, FL 33763',
                'virtual_tour_image' => null,
                'virtual_tour_label' => 'ENTRY DOOR',
                'home_page_image' => null,
                'display_order' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'LARGO',
                'slug' => 'largo',
                'address' => '1807 Clearwater Largo Rd, Largo, FL 33770',
                'phone' => '(727) 588-5550',
                'fax' => '(727) 588-5551',
                'email' => 'largo@sproutacademy.com',
                'hours_of_operation' => 'Monday - Friday: 6:30 AM - 6:00 PM',
                'google_maps_address' => '1807 Clearwater Largo Rd, Largo, FL 33770',
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
