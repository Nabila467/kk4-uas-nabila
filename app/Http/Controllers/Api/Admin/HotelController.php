<?php

namespace App\Http\Controllers\Api\Admin;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $auth = $request->user();


        if ($auth->roles == 'admin') {
            $request->validate([
                'title' => 'required',
                'image' => 'required',
                'description' => 'required',
                'address' => 'required',
                'price' => 'required',
            ]);

            $image = $request->file('image')->store('hotel', 'public');

            $hotel = Hotel::create([
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'image' => $image,
                'description' => $request->description,
                'address' => $request->address,
                'price' => $request->price,
            ]);

            if ($hotel) {
                return ResponseFormatter::success(
                    $hotel,
                    'Data Hotel Berhasil Ditambahkan'
                );
            } else {
                return ResponseFormatter::error(
                    null,
                    'Data Hotel Gagal Ditambahkan',
                    404
                );
            }
        } else {
            return ResponseFormatter::error(
                null,
                'Anda Bukan Admin',
                404
            );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $hotel = Hotel::find($id);

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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $auth = auth()->user();

        if ($auth->roles == 'admin') {
            $hotel = Hotel::find($id);

            if ($hotel) {


                if ($request->file('image') == '') {
                    $image = $hotel->image;
                } else {
                    $image = $request->file('image')->store('hotel', 'public');
                }

                $hotel->update([
                    'title' => $request->title ? $request->title : $hotel->title,
                    'slug' => Str::slug($request->title) ? Str::slug($request->title) : $hotel->slug,
                    'image' => $image ?? $hotel->image ?? null,
                    'description' => $request->description ? $request->description : $hotel->description,
                    'address' => $request->address ? $request->address : $hotel->address,
                    'price' => $request->price ? $request->price : $hotel->price,
                ]);

                return ResponseFormatter::success(
                    $hotel,
                    'Data Hotel Berhasil Diubah'
                );
            } else {
                return ResponseFormatter::error(
                    null,
                    'Data Hotel Gagal Diubah',
                    404
                );
            }
        } else {
            return ResponseFormatter::error(
                null,
                'Anda Bukan Admin',
                404
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = auth()->user();

        if ($user->roles == 'admin') {
            $hotel = Hotel::find($id);

            if ($hotel) {
                $hotel->delete();

                return ResponseFormatter::success(
                    $hotel,
                    'Data Hotel Berhasil Dihapus'
                );
            } else {
                return ResponseFormatter::error(
                    null,
                    'Data Hotel Gagal Dihapus',
                    404
                );
            }
        } else {
            return ResponseFormatter::error(
                null,
                'Anda Bukan Admin',
                404
            );
        }
    }
}
