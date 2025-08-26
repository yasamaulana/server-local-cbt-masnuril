@extends('layouts.app', ['title' => 'Cek Hasil Pendaftaran'])

@section('main')
    <div class="container pb-5 pt-5">
        <h2 class="mb-4">Cek Hasil Pendaftaran Siswa/Siswi Anda</h2>

        <div class="alert alert-info">
            <strong>Note:</strong> Masukkan <strong>NISN Siswa/Siswi</strong> untuk melihat hasil pendaftaran.
        </div>

        {{-- Form --}}
        <div class="input-group mb-3">
            <input type="text" id="nisn" class="form-control" placeholder="Masukkan NISN...">
            <button id="btnCari" class="btn btn-primary">Cari</button>
        </div>

        {{-- Tempat hasil ditampilkan --}}
        <div id="hasilPendaftaran"></div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#btnCari').on('click', function() {
                const nisn = $('#nisn').val();
                const $hasilDiv = $('#hasilPendaftaran');

                if (!nisn) {
                    $hasilDiv.html('<div class="alert alert-warning">NISN tidak boleh kosong.</div>');
                    return;
                }

                $hasilDiv.html('<div class="alert alert-info">Memuat data...</div>');

                $.ajax({
                    url: "{{ route('cek.hasil.ajax') }}",
                    method: 'GET',
                    data: {
                        nisn: nisn
                    },
                    success: function(data) {
                        if (data.success) {
                            const p = data.data;
                            $hasilDiv.html(`
                            <div class="card mt-3">
                                <div class="card-header"><strong>Data Pendaftaran</strong></div>
                                <div class="card-body">
                                    <p><strong>Nama:</strong> ${p.nama}</p>
                                    <p><strong>NISN:</strong> ${p.nisn}</p>
                                    <p><strong>Asal Sekolah:</strong> ${p.asal_sekolah}</p>
                                    <p><strong>Status:</strong> ${formatStatus(p.status)}</p>
                                </div>
                            </div>
                        `);
                        } else {
                            $hasilDiv.html(
                                `<div class="alert alert-warning">${data.message}</div>`);
                        }
                    },
                    error: function(xhr) {
                        $hasilDiv.html(
                            `<div class="alert alert-danger">Terjadi kesalahan: ${xhr.statusText}</div>`
                        );
                    }
                });

                function formatStatus(status) {
                    if (status === 'Diterima') return '<span class="badge bg-success">Diterima</span>';
                    if (status === 'Menunggu Verifikasi')
                        return '<span class="badge bg-warning">Menunggu Verifikasi</span>';
                    return '<span class="badge bg-danger">Tidak Diterima</span>';
                }
            });
        });
    </script>
@endsection
