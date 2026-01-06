<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Upazila;

class LocationController extends Controller
{
    public function district()
    {
        $districts = District::orderBy('name')->get();

        return $this->success($districts, 'Districts retrieved successfully.');
    }

    public function upazila($district_id)
    {
        $upazillas = Upazila::where('district_id', $district_id)->orderBy('name')->get();

        return $this->success($upazillas, 'Upazillas retrieved successfully.');
    }
}
