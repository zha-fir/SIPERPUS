<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Insiden;

class InsidenController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');
        $query = Insiden::query();

        if ($status) {
            $query->where('status', $status);
        }

        $insidens = $query->orderBy('created_at', 'desc')->get();

        return view('insiden.index', compact('insidens', 'status'));
    }

    public function show($id)
    {
        $insiden = Insiden::findOrFail($id);
        return view('insiden.show', compact('insiden'));
    }

    public function update(Request $request, $id)
    {
        $insiden = Insiden::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:Menunggu,Diproses,Selesai,Ditolak',
            'prioritas' => 'required|in:Rendah,Sedang,Tinggi,Kritis',
            'tanggapan_admin' => 'nullable|string'
        ]);

        $insiden->update([
            'status' => $request->status,
            'prioritas' => $request->prioritas,
            'tanggapan_admin' => $request->tanggapan_admin
        ]);

        return redirect()->route('insiden.show', $id)->with('success', 'Tiket insiden berhasil diperbarui.');
    }
}
