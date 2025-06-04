<?php

namespace App\Http\Controllers;

use App\Models\pengaduan;
use App\Models\pengaduanStatus;
use Illuminate\Http\Request;

class PengaduanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:10240',
            'alamat' => 'required|string',
            'pesan' => 'required|string',
        ]);

        $pengaduan = Pengaduan::create([
            'user_id' => auth()->user()->id,
            'alamat' => $request->alamat,
            'pesan' => $request->pesan,
        ]);

        $extensi = $request->file('foto')->getClientOriginalExtension();

        $filename = 'pengaduan-' . $pengaduan->id . '.' . $extensi;

        $path = $request->file('foto')->storeAs('pengaduan_foto', $filename, 'public');

        $pengaduan->foto = $path;
        $pengaduan->save();

        pengaduanStatus::create([
            "pengaduan_id" => $pengaduan->id,
        ]);

        return response()->json([
            'message' => 'Pengaduan berhasil disimpan',
            'data' => $pengaduan
        ]);


    }

    /**
     * Display the specified resource.
     */
    public function show(pengaduan $pengaduan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, pengaduan $pengaduan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(pengaduan $pengaduan)
    {
        //
    }
}
