@extends('layouts.app', [
    'title' => 'Pendaftaran Peserta Didik Baru',
])
@section('main')
    <div class="container pb-5 pt-5">
        <h2 class="mb-4">Formulir Pendaftaran Siswa/Siswi Baru MA Nurul Ilmi</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="alert alert-info">
            <strong>Note:</strong> Harap isi formulir dengan data yang sesuai dengan <strong>KK, Akta Kelahiran, dan
                Ijazah</strong> secara benar dan lengkap.
        </div>

        <form action="{{ route('pendaftaran.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    @foreach ([
            'nama' => 'Nama Lengkap (Sesuai Ijazah)',
            'nik' => 'NIK (Nomor Induk Kependudukan)',
            'nisn' => 'NISN (Nomor Induk Siswa Nasional)',
            'tempat_lahir' => 'Tempat Lahir',
            'tanggal_lahir' => 'Tanggal Lahir',
        ] as $name => $label)
                        <div class="mb-3">
                            <label for="{{ $name }}" class="form-label">{{ $label }} <span
                                    class="text-danger">*</span></label>
                            <input type="{{ $name === 'tanggal_lahir' ? 'date' : 'text' }}" class="form-control"
                                id="{{ $name }}" name="{{ $name }}" value="{{ old($name) }}" required>
                            @error($name)
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    @endforeach
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin <span
                                class="text-danger">*</span></label>
                        <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                            <option value="">-- Pilih --</option>
                            <option value="Laki-laki" {{ old('jenis_kelamin') === 'Laki-laki' ? 'selected' : '' }}>
                                Laki-laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin') === 'Perempuan' ? 'selected' : '' }}>
                                Perempuan</option>
                        </select>
                        @error('jenis_kelamin')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    @foreach ([
            'agama' => 'Agama',
            'asal_sekolah' => 'Asal Sekolah',
            'alamat' => 'Alamat Tempat Tinggal',
            'no_hp' => 'No HP/WA Yang Aktif',
        ] as $name => $label)
                        <div class="mb-3">
                            <label for="{{ $name }}" class="form-label">{{ $label }} <span
                                    class="text-danger">*</span></label>
                            @if ($name == 'alamat')
                                <textarea class="form-control" id="{{ $name }}" name="{{ $name }}" rows="2" required>{{ old($name) }}</textarea>
                            @else
                                <input type="text" class="form-control" id="{{ $name }}"
                                    name="{{ $name }}" value="{{ old($name) }}" required>
                            @endif
                            @error($name)
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <h5 class="mt-4">Data Ayah</h5>
                    @foreach ([
            'nama_ayah' => 'Nama Ayah',
            'alamat_ayah' => 'Alamat Ayah',
            'nik_ayah' => 'NIK Ayah',
            'pekerjaan_ayah' => 'Pekerjaan Ayah',
        ] as $name => $label)
                        <div class="mb-3">
                            <label for="{{ $name }}" class="form-label">{{ $label }} <span
                                    class="text-danger">*</span></label>
                            @if (str_contains($name, 'alamat'))
                                <textarea class="form-control" id="{{ $name }}" name="{{ $name }}" rows="2" required>{{ old($name) }}</textarea>
                            @else
                                <input type="text" class="form-control" id="{{ $name }}"
                                    name="{{ $name }}" value="{{ old($name) }}" required>
                            @endif
                            @error($name)
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    @endforeach
                </div>

                <div class="col-md-6">
                    <h5 class="mt-4">Data Ibu</h5>
                    @foreach ([
            'nama_ibu' => 'Nama Ibu',
            'alamat_ibu' => 'Alamat Ibu',
            'nik_ibu' => 'NIK Ibu',
            'pekerjaan_ibu' => 'Pekerjaan Ibu',
        ] as $name => $label)
                        <div class="mb-3">
                            <label for="{{ $name }}" class="form-label">{{ $label }} <span
                                    class="text-danger">*</span></label>
                            @if (str_contains($name, 'alamat'))
                                <textarea class="form-control" id="{{ $name }}" name="{{ $name }}" rows="2" required>{{ old($name) }}</textarea>
                            @else
                                <input type="text" class="form-control" id="{{ $name }}"
                                    name="{{ $name }}" value="{{ old($name) }}" required>
                            @endif
                            @error($name)
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    @endforeach
                </div>
            </div>

            <h5 class="mt-4">Upload Dokumen</h5>
            <div class="row">
                <div class="col-md-6">
                    @foreach ([
            'kk' => 'Kartu Keluarga',
            'ktp_ayah' => 'KTP Ayah',
            'ktp_ibu' => 'KTP Ibu',
        ] as $name => $label)
                        <div class="mb-3">
                            <label class="form-label">{{ $label }} <span class="text-danger">*</span></label>
                            <input class="form-control" type="file" name="{{ $name }}" required>
                            @error($name)
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    @endforeach
                </div>

                <div class="col-md-6">
                    @foreach ([
            'kip' => 'KIP (Jika ada)',
            'kks' => 'Kartu Keluarga Sejahtera (Jika ada)',
            'ijazah' => 'Ijazah/Surat Keterangan Lulus SMP/MTs',
        ] as $name => $label)
                        <div class="mb-3">
                            <label class="form-label">{{ $label }}{{ $name == 'ijazah' ? ' *' : '' }}</label>
                            <input class="form-control" type="file" name="{{ $name }}"
                                {{ $name == 'ijazah' ? 'required' : '' }}>
                            @error($name)
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="mb-3">
                <label for="rekomendasi" class="form-label">Siapakah yang merekomendasikan anda untuk sekolah di MA Nurul
                    Ilmi?</label>
                <input type="text" class="form-control" id="rekomendasi" name="rekomendasi"
                    value="{{ old('rekomendasi') }}">
                @error('rekomendasi')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary rounded">Kirim Pendaftaran</button>
        </form>
    </div>
@endsection
