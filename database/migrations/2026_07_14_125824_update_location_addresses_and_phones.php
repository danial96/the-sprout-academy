<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $updates = [
            'seminole' => [
                'address' => '9259 Park Blvd, Seminole, FL 33777',
                'phone' => '727-399-2483',
                'fax' => '',
                'google_maps_address' => '9259 Park Blvd, Seminole, FL 33777',
            ],
            'st-petersburg' => [
                'address' => '5610 54th Ave N., St Petersburg, FL 33709',
                'phone' => '727-541-6260',
                'fax' => '',
                'google_maps_address' => '5610 54th Ave N., St Petersburg, FL 33709',
            ],
            'pinellas-park' => [
                'address' => '6552 84th Ave. N., Pinellas Park, FL 33781',
                'phone' => '727-545-9944',
                'fax' => '',
                'google_maps_address' => '6552 84th Ave. N., Pinellas Park, FL 33781',
            ],
            'largo' => [
                'address' => '1807 S Highland Ave, Largo, FL 33756',
                'phone' => '727-559-1777',
                'fax' => '',
                'google_maps_address' => '1807 S Highland Ave, Largo, FL 33756',
            ],
            'montessori' => [
                'address' => '2095 Belleair Road, Clearwater, FL 33764',
                'phone' => '727-535-8512',
                'fax' => '',
                'google_maps_address' => '2095 Belleair Road, Clearwater, FL 33764',
            ],
        ];

        foreach ($updates as $slug => $data) {
            DB::table('locations')->where('slug', $slug)->update($data);
        }
    }

    public function down(): void
    {
        $rollback = [
            'seminole' => [
                'address' => '7985 113th St N, Seminole, FL 33772',
                'phone' => '(727) 953-5544',
                'fax' => '(727) 953-5545',
                'google_maps_address' => '7985 113th St N, Seminole, FL 33772',
            ],
            'st-petersburg' => [
                'address' => '1100 1st Ave N, St. Petersburg, FL 33701',
                'phone' => '727-541-6260',
                'fax' => '727-851-9975',
                'google_maps_address' => '1100 1st Ave N, St. Petersburg, FL 33701',
            ],
            'pinellas-park' => [
                'address' => '5995 Park Blvd, Pinellas Park, FL 33781',
                'phone' => '(727) 544-5437',
                'fax' => '(727) 544-5438',
                'google_maps_address' => '5995 Park Blvd, Pinellas Park, FL 33781',
            ],
            'largo' => [
                'address' => '1807 Clearwater Largo Rd, Largo, FL 33770',
                'phone' => '(727) 588-5550',
                'fax' => '(727) 588-5551',
                'google_maps_address' => '1807 Clearwater Largo Rd, Largo, FL 33770',
            ],
            'montessori' => [
                'address' => '2255 Countryside Blvd, Clearwater, FL 33763',
                'phone' => '(727) 799-7687',
                'fax' => '(727) 799-7688',
                'google_maps_address' => '2255 Countryside Blvd, Clearwater, FL 33763',
            ],
        ];

        foreach ($rollback as $slug => $data) {
            DB::table('locations')->where('slug', $slug)->update($data);
        }
    }
};
