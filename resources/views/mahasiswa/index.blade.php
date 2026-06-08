@extends('main')

@section('title', 'Mahasiswa')

@section('content')
<a href="{{ route('mahasiswa.create') }}" class="btn btn-primary mb-2">Tambah Mahasiswa</a>

<table class="table table-bordered">
    <tr>
        <th>No</th>
        <th>Nama</th>
        <th>NPM</th>
        <th>Foto</th>
        <th>Program Studi</th>
        <th>Aksi</th>
    </tr>

    @foreach($mahasiswa as $key => $mhs)
    <tr>
        <td>{{ $key + 1 }}</td>
        <td>{{ $mhs->nama }}</td>
        <td>{{ $mhs->npm }}</td>
        <td>
            @if ($mhs->foto)
            <img src="{{ asset('storage/fotos/' . $mhs->foto) }}" alt="Foto" width="100">
             @else 
                <p>Foto Tidak Tersedia</p>
            @endif
        </td>   

        <td>{{ $mhs->prodi->nama_prodi ?? '-' }}</td>

        <td>
            <a href="{{ route('mahasiswa.edit', $mhs->id) }}" class="btn btn-warning btn-sm">
                Edit
            </a>

            <form method="POST" action="{{ route('mahasiswa.destroy', $mhs->id) }}" class="d-inline">
                @csrf
                @method('DELETE')

                <button type="submit"
                        class="btn btn-danger btn-sm show_confirm"
                        data-toggle="tooltip"
                        title="Delete"
                        data-nama="{{ $mhs->nama }}">
                    Hapus
                </button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
@endsection