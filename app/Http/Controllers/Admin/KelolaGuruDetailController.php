<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KelolaGuruDetailController extends Controller
{
    public function update(Request $request, $id)
    {
        $guru = Guru::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nip' => 'nullable|string|max:20|unique:guru,nip,' . $id,
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:L,P',
            'alamat' => 'nullable|string',
            'no_telp' => 'nullable|string|max:15',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $guru->update($request->all());

        return redirect()->route('admin.guru')->with('success', 'Data guru berhasil diperbarui.');
    }
}