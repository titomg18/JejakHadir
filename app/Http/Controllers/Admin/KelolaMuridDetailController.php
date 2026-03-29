<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Murid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KelolaMuridDetailController extends Controller
{
    public function edit($id)
    {
        $murid = Murid::with('user')->findOrFail($id);
        return view('Admin.edit-murid-detail', compact('murid'));
    }

    public function update(Request $request, $id)
    {
        $murid = Murid::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nis' => 'nullable|string|max:20|unique:murid,nis,' . $id,
            'nisn' => 'nullable|string|max:20|unique:murid,nisn,' . $id,
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:L,P',
            'alamat' => 'nullable|string',
            'no_telp_orang_tua' => 'nullable|string|max:15',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $murid->update($request->all());

        return redirect()->route('admin.murid')->with('success', 'Data murid berhasil diperbarui.');
    }
}