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
}