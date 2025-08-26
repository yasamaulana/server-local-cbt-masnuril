@extends('layouts.app', [
    'title' => 'Pendaftaran Berhasil',
])

@section('main')
    <div class="container pb-5 pt-5">
        <h2 class="mb-4">Pendaftaran Peserta Didik Baru Berhasil</h2>

        <div class="alert alert-success">
            <strong>Terima kasih!</strong> Pendaftaran Anda telah berhasil. Silakan simpan informasi berikut untuk referensi
            di masa mendatang.
        </div>

        <p>Anda akan menerima informasi lebih lanjut melalui email atau telepon yang telah Anda daftarkan.</p>
        <div class="text-center">
            <a href="/"> <button class="btn btn-primary">Kembali Ke Beranda</button></a>
        </div>
    </div>
@endsection
