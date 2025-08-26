<template>

    <Head>
        <title>Detail Pendaftaran - {{ pendaftaran.nama }}</title>
    </Head>

    <div class="container mt-5 mb-5">
        <Link href="/admin/ppdb" class="btn btn-md btn-primary border-0 shadow mb-3" type="button"><i
            class="fa fa-long-arrow-alt-left me-2"></i> Kembali</Link>
        <div class="card border-0 shadow">
            <div class="card-body">
                <h4 class="mb-4">Detail Pendaftaran Siswa</h4>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Nama Lengkap:</strong>
                        <div>{{ pendaftaran.nama }}</div>
                    </div>
                    <div class="col-md-6">
                        <strong>NISN:</strong>
                        <div>{{ pendaftaran.nisn }}</div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>NIK:</strong>
                        <div>{{ pendaftaran.nik }}</div>
                    </div>
                    <div class="col-md-6">
                        <strong>Tempat, Tanggal Lahir:</strong>
                        <div>{{ pendaftaran.tempat_lahir }}, {{ pendaftaran.tanggal_lahir }}</div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Jenis Kelamin:</strong>
                        <div>{{ pendaftaran.jenis_kelamin }}</div>
                    </div>
                    <div class="col-md-6">
                        <strong>Agama:</strong>
                        <div>{{ pendaftaran.agama }}</div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Asal Sekolah:</strong>
                        <div>{{ pendaftaran.asal_sekolah }}</div>
                    </div>
                    <div class="col-md-6">
                        <strong>No HP/WA:</strong>
                        <div>{{ pendaftaran.no_hp }}</div>
                    </div>
                </div>

                <div class="mb-3">
                    <strong>Alamat:</strong>
                    <div>{{ pendaftaran.alamat }}</div>
                </div>

                <hr />

                <h5 class="mt-4">Data Ayah</h5>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Nama Ayah:</strong>
                        <div>{{ pendaftaran.nama_ayah }}</div>
                    </div>
                    <div class="col-md-6">
                        <strong>NIK Ayah:</strong>
                        <div>{{ pendaftaran.nik_ayah }}</div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Pekerjaan Ayah:</strong>
                        <div>{{ pendaftaran.pekerjaan_ayah }}</div>
                    </div>
                    <div class="col-md-6">
                        <strong>Alamat Ayah:</strong>
                        <div>{{ pendaftaran.alamat_ayah }}</div>
                    </div>
                </div>

                <h5 class="mt-4">Data Ibu</h5>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Nama Ibu:</strong>
                        <div>{{ pendaftaran.nama_ibu }}</div>
                    </div>
                    <div class="col-md-6">
                        <strong>NIK Ibu:</strong>
                        <div>{{ pendaftaran.nik_ibu }}</div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Pekerjaan Ibu:</strong>
                        <div>{{ pendaftaran.pekerjaan_ibu }}</div>
                    </div>
                    <div class="col-md-6">
                        <strong>Alamat Ibu:</strong>
                        <div>{{ pendaftaran.alamat_ibu }}</div>
                    </div>
                </div>

                <hr />

                <h5 class="mt-4">Dokumen Terlampir</h5>
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Kartu Keluarga
                        <a :href="pendaftaran.kk" target="_blank" class="btn btn-sm btn-primary">Lihat</a>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        KTP Ayah
                        <a :href="pendaftaran.ktp_ayah" target="_blank" class="btn btn-sm btn-primary">Lihat</a>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        KTP Ibu
                        <a :href="pendaftaran.ktp_ibu" target="_blank" class="btn btn-sm btn-primary">Lihat</a>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Ijazah/Surat Keterangan Lulus
                        <a :href="pendaftaran.ijazah" target="_blank" class="btn btn-sm btn-primary">Lihat</a>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center"
                        v-if="pendaftaran.kip">
                        KIP
                        <a :href="pendaftaran.kip" target="_blank" class="btn btn-sm btn-primary">Lihat</a>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center"
                        v-if="pendaftaran.kks">
                        KKS
                        <a :href="pendaftaran.kks" target="_blank" class="btn btn-sm btn-primary">Lihat</a>
                    </li>
                </ul>

                <div class="mt-4">
                    <strong>Rekomendasi:</strong>
                    <div>{{ pendaftaran.rekomendasi || '-' }}</div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import LayoutAdmin from '../../../Layouts/Admin.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';

export default {
    layout: LayoutAdmin,
    components: {
        Head,
        Link,
    },
    props: {
        pendaftaran: Object,
    },
};
</script>
