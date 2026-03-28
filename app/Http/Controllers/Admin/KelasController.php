<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::with('waliKelas')->get();
        $gurus = User::where('role', 'guru')->get();
        return view('Admin.kelola-kelas', compact('kelas', 'gurus'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_kelas' => 'required|string|max:255|unique:kelas,nama_kelas',
            'deskripsi' => 'nullable|string',
            'wali_kelas_id' => 'nullable|exists:users,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Kelas::create($request->all());

        return redirect()->route('admin.kelas')->with('success', 'Kelas berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $kelas = Kelas::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nama_kelas' => 'required|string|max:255|unique:kelas,nama_kelas,' . $id,
            'deskripsi' => 'nullable|string',
            'wali_kelas_id' => 'nullable|exists:users,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $kelas->update($request->all());

        return redirect()->route('admin.kelas')->with('success', 'Kelas berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kelas = Kelas::findOrFail($id);
        $kelas->delete();

        return redirect()->route('admin.kelas')->with('success', 'Kelas berhasil dihapus.');
    }

    // Method detail kelas
    public function show($id)
    {
        $kelas = Kelas::with('murids')->findOrFail($id);
        // Ambil murid yang belum memiliki kelas
        $muridTidakBerKelas = User::where('role', 'murid')->whereNull('kelas_id')->get();
        return view('Admin.detail-kelas', compact('kelas', 'muridTidakBerKelas'));
    }

    // Menambah murid ke kelas
    public function addMurid(Request $request, $id)
    {
        $kelas = Kelas::findOrFail($id);
        $request->validate([
            'murid_id' => 'required|exists:users,id',
        ]);

        $murid = User::findOrFail($request->murid_id);
        if ($murid->role !== 'murid') {
            return redirect()->back()->with('error', 'Hanya murid yang dapat ditambahkan ke kelas.');
        }
        if ($murid->kelas_id !== null) {
            return redirect()->back()->with('error', 'Murid sudah memiliki kelas.');
        }

        $murid->kelas_id = $kelas->id;
        $murid->save();

        return redirect()->route('admin.kelas.detail', $kelas->id)->with('success', 'Murid berhasil ditambahkan ke kelas.');
    }

    // Mengeluarkan murid dari kelas
    public function removeMurid($kelasId, $muridId)
    {
        $kelas = Kelas::findOrFail($kelasId);
        $murid = User::where('id', $muridId)->where('kelas_id', $kelasId)->firstOrFail();
        $murid->kelas_id = null;
        $murid->save();

        return redirect()->route('admin.kelas.detail', $kelas->id)->with('success', 'Murid berhasil dikeluarkan dari kelas.');
    }
}