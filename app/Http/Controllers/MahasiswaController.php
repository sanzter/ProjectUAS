<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mahasiswa = Mahasiswa::with('prodi')->get();
        return view('mahasiswa.index', compact('mahasiswa'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $prodi = Prodi::all();
        return view('mahasiswa.create', compact('prodi'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      
        $input = $request->validate([
            'npm' => 'required|unique:mahasiswas,npm',
            'nama' => 'required',
            'prodi_id' => 'required|exists:prodis,id',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096'
        ]);

        if($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $nama_foto = time() . '_' . $foto->getClientOriginalName();
            $foto->storeAs('fotos', $nama_foto, 'public');
        } else {
            $nama_foto  = null;
        }
        $input['foto'] = $nama_foto;
        
        Mahasiswa::create($input);

        return redirect()->route('mahasiswa.index')->with('success', 'Data mahasiswa berhasil disimpan.');

    }

    /**
     * Display the specified resource.
     */
    public function show(Mahasiswa $mahasiswa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mahasiswa $mahasiswa)
    {
        $prodi = Prodi::all();
        return view('mahasiswa.edit', compact('mahasiswa', 'prodi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        $request->validate([
        'nama' => 'required',
        'npm' => 'required|unique:mahasiswas,npm,' . $mahasiswa->id,
        'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'prodi_id' => 'required',
    ]);

    $data = [
        'nama' => $request->nama,
        'npm' => $request->npm,
        'prodi_id' => $request->prodi_id,
    ];

    if ($request->hasFile('foto')) {
        // hapus foto lama jika ada
        if ($mahasiswa->foto && Storage::disk('public')->exists('fotos/' . $mahasiswa->foto)) {
            Storage::disk('public')->delete('fotos/' . $mahasiswa->foto);
        }

        // simpan foto baru
        $file = $request->file('foto');
        $namaFoto = time() . '_' . $file->getClientOriginalName();

        $file->storeAs('fotos', $namaFoto, 'public');

        // simpan nama file ke database
        $data['foto'] = $namaFoto;
    }

    $mahasiswa->update($data);

    return redirect()->route('mahasiswa.index')
        ->with('success', 'Data mahasiswa berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mahasiswa $mahasiswa)
    {
        if ($mahasiswa->foto && Storage::disk('public')->exists('fotos/' . $mahasiswa->foto)) {
        Storage::disk('public')->delete('fotos/' . $mahasiswa->foto);
    }

    $mahasiswa->delete();

    return redirect()->route('mahasiswa.index')
        ->with('success', 'Data mahasiswa berhasil dihapus');
    }
}
