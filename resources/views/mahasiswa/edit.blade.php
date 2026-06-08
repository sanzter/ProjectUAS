@extends('main')

@section('title', 'Edit Mahasiswa')

@section('content')
    <form action="{{ route('mahasiswa.update', $mahasiswa->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group mb-2">
            <label>Nama Mahasiswa</label>
            <input type="text" name="nama" class="form-control"
                   value="{{ old('nama', $mahasiswa->nama) }}">
        </div>
        @error('nama')
            <div class="text-danger">{{ $message }}</div>
        @enderror

        <div class="form-group mb-2">
            <label>NPM</label>
            <input type="text" name="npm" class="form-control"
                   value="{{ old('npm', $mahasiswa->npm) }}">
        </div>
        @error('npm')
            <div class="text-danger">{{ $message }}</div>
        @enderror

        <div class="form-group mb-2">
            <label>Foto Lama</label><br>

            @if ($mahasiswa->foto)
                <img src="{{ asset('storage/fotos/' . $mahasiswa->foto) }}"
                     alt="Foto Mahasiswa"
                     width="120">
            @else
                <p>Foto Tidak Tersedia</p>
            @endif
        </div>

        <div class="form-group mb-2">
            <label>Ganti Foto</label>
            <input type="file" name="foto" class="form-control">
            <small class="text-muted">Kosongkan jika tidak ingin mengganti foto.</small>
        </div>
        @error('foto')
            <div class="text-danger">{{ $message }}</div>
        @enderror

        <div class="form-group mb-2">
            <label>Program Studi</label>
            <select name="prodi_id" class="form-control">
                <option value="">Pilih Prodi</option>

                @foreach ($prodi as $row)
                    <option value="{{ $row->id }}"
                        {{ old('prodi_id', $mahasiswa->prodi_id) == $row->id ? 'selected' : '' }}>
                        {{ $row->nama_prodi }}
                    </option>
                @endforeach
            </select>
        </div>
        @error('prodi_id')
            <div class="text-danger">{{ $message }}</div>
        @enderror

        <button type="submit" class="btn btn-primary mt-2">Update</button>
        <a href="{{ route('mahasiswa.index') }}" class="btn btn-secondary mt-2">Kembali</a>
    </form>
@endsection