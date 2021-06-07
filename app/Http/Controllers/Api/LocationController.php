<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Province;
use App\Models\Regency;
use App\Models\District;
use App\Models\Village;

class LocationController extends Controller
{
    public function get_provinces()
    {
        return response()->json(
            [
                'success' => true,
                'data' => Province::all(),
            ]
        );
    }

    public function get_regencies($id_province = null)
    {
        if($id_province == null){
            return response()->json(
                [
                    'success' => true,
                    'data' => Regency::all(),
                ]
            );
        }else
        {
            return response()->json(
                [
                    'success' => true,
                    'data' => Regency::where('province_id', $id_province)->get(),
                ]
            );
        }
    }

    public function get_districts($id_regency = null)
    {
        if($id_regency == null){
            return response()->json(
                [
                    'success' => true,
                    'data' => District::all(),
                ]
            );
        }else
        {
            return response()->json(
                [
                    'success' => true,
                    'data' => District::where('regency_id', $id_regency)->get(),
                ]
            );
        }
    }

    public function get_villages($id_district = null)
    {
        if($id_district == null){
            return response()->json(
                [
                    'success' => true,
                    'data' => Village::all(),
                ]
            );
        }
        else
        {
            return response()->json(
                [
                    'success' => true,
                    'data' => Village::where('district_id', $id_district)->get(),
                ]
            );
        }
    }
}
