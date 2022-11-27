<?php

namespace App\Http\Controllers\Api\User;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Hotel;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    public function index()
    {
        $hotels = Hotel::all();

        if ($hotels) {
            return ResponseFormatter::success(
                $hotels,
                'Data List Hotel Berhasil Diambil'
            );
        } else {
            return ResponseFormatter::error(
                null,
                'Data List Hotel Gagal Diambil',
                404
            );
        }
    }

    public function show(Hotel $hotel)
    {
        if ($hotel) {
            return ResponseFormatter::success(
                $hotel,
                'Data Hotel Berhasil Diambil'
            );
        } else {
            return ResponseFormatter::error(
                null,
                'Data Hotel Gagal Diambil',
                404
            );
        }
    }
}
