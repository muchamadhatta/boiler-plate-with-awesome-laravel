<?php

namespace App\Http\Controllers\Referensi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Referensi\DokumenLegalitas;
use Exception;
use Illuminate\Support\Facades\DB;


class DokumenLegalitasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = DokumenLegalitas::where('status', '1')->paginate(10);
        return view('DokumenLegalitas.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('DokumenLegalitas.edit');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = $request->validate([
            'dokumen' => ['required', 'string'],
        ]);

        DB::beginTransaction();
        $return_status = 'Valid';

        try {
            $data = DokumenLegalitas::create([
                'dokumen' => $validation['dokumen'],
                'status' => '1',
                'user_input' => auth()->user()->id,
                'tanggal_input' => date('Y-m-d H:i:s'),
            ]);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e);
        }

        return redirect()->route('Daftar DokumenLegalitas');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = DokumenLegalitas::findOrFail($id);
        return view('DokumenLegalitas.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validation = $request->validate([
            'dokumen' => ['required', 'string'],
        ]);
        DB::beginTransaction();
        $return_status = 'Valid';

        try {
            $data = DokumenLegalitas::findOrFail($id);
            $data->update([
                'dokumen' => $validation['dokumen'],
                'status' => '1',
                'user_update' => auth()->user()->id,
                'tanggal_update' => date('Y-m-d H:i:s'),
            ]);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e);
        }

        return redirect()->route('Daftar DokumenLegalitas');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = DokumenLegalitas::findOrFail($id);
        $data->update([
            'status' => '0',
            'user_update' => auth()->user()->id,
            'tanggal_update' => date('Y-m-d H:i:s'),
        ]);
        return redirect()->route('Daftar DokumenLegalitas')->with('success', 'Dokumen Legalitas berhasil dihapus');
    }
}