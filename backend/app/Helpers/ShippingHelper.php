<?php
namespace App\Helpers;

use App\Models\ShippingRule;

class ShippingHelper
{
    public static function getShippingCharge($district_id, $upazila_id)
    {
        if ($upazila_id) {
            $rule = ShippingRule::where('upazila_id', $upazila_id)->first();
            if ($rule) return $rule->charge;
        }

        if ($district_id) {
            $rule = ShippingRule::where('district_id', $district_id)
                                ->whereNull('upazila_id')
                                ->first();
            if ($rule) return $rule->charge;
        }

        return ShippingRule::whereNull('district_id')
            ->whereNull('upazila_id')
            ->value('charge') ?? 0;
    }
}

