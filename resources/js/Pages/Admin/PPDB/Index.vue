<template>

    <Head>
        <title>PPDB - Aplikasi Ujian Online</title>
    </Head>
    <div class="container-fluid mb-5 mt-5">
        <div class="row">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-9 col-12 mb-2">
                        <form @submit.prevent="handleSearch">
                            <div class="d-flex gap-2">
                                <div class="input-group">
                                    <input type="text" class="form-control border-0 shadow" v-model="search"
                                        placeholder="masukkan kata kunci dan enter...">
                                    <span class="input-group-text border-0 shadow">
                                        <i class="fa fa-search"></i>
                                    </span>
                                </div>
                                <!-- Filter Status -->
                                <select class="form-select border-0 shadow" v-model="status" @change="handleSearch">
                                    <option value="">Semua Status</option>
                                    <option value="Menunggu Verifikasi">Menunggu Konfirmasi</option>
                                    <option value="Diterima">Diterima</option>
                                    <option value="Ditolak">Ditolak</option>
                                </select>

                                <!-- Filter Tahun -->
                                <select class="form-select border-0 shadow" v-model="tahun" @change="handleSearch">
                                    <option value="">Semua Tahun</option>
                                    <option v-for="year in tahunList" :key="year" :value="year">{{ year }}</option>
                                </select>

                                <a :href="`/admin/ppdb/export?q=${search}&status=${status}&tahun=${tahun}`"
                                    class="btn btn-success shadow">
                                    Export
                                </a>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-1">
            <div class="col-md-12">
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <div v-if="form.student_id.length > 0" class="d-flex justify-content-between mb-3">
                            <div>
                                <select v-model="form.status" class="form-select form-select-sm w-auto d-inline-block">
                                    <option value="">- Pilih Salah Satu - </option>
                                    <option value="Diterima">Diterima</option>
                                    <option value="Ditolak">Ditolak</option>
                                </select>
                                <button @click="submitEditStatus" class="btn btn-sm btn-success ms-2">
                                    Ubah Status Terpilih
                                </button>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-centered table-nowrap mb-0 rounded">
                                <thead class="thead-dark">
                                    <tr class="border-0">
                                        <th class="border-0 rounded-start" style="width:5%">
                                            <input type="checkbox" v-model="form.allSelected" @change="selectAll" />
                                        </th>
                                        <th class="border-0">NISN</th>
                                        <th class="border-0">NIK</th>
                                        <th class="border-0">Nama</th>
                                        <th class="border-0">Asal Sekolah</th>
                                        <th class="border-0">Status</th>
                                        <th class="border-0 rounded-end" style="width:15%">Aksi</th>
                                    </tr>
                                </thead>
                                <div class="mt-2"></div>
                                <tbody>
                                    <tr v-for="(pendaftaran, index) in pendaftarans.data" :key="index">
                                        <td>
                                            <input type="checkbox" v-model="form.student_id" :id="pendaftaran.id"
                                                :value="pendaftaran.id" number :checked="form.allSelected" />
                                        </td>
                                        <td>{{ pendaftaran.nisn }}</td>
                                        <td>{{ pendaftaran.nik }}</td>
                                        <td>{{ pendaftaran.nama }}</td>
                                        <td>{{ pendaftaran.asal_sekolah }}</td>
                                        <td>
                                            {{ pendaftaran.status }}
                                        </td>
                                        <td class="text-center">
                                            <Link :href="`/admin/ppdb/${pendaftaran.id}/show`"
                                                class="btn btn-sm btn-info border-0 shadow me-2" type="button"><i
                                                class="far fa-eye"></i></Link>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <Pagination :links="pendaftarans.links" align="end" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
//import layout
import LayoutAdmin from '../../../Layouts/Admin.vue';

//import component pagination
import Pagination from '../../../Components/Pagination.vue';

//import Heade and Link from Inertia
import {
    Head,
    Link
} from '@inertiajs/inertia-vue3';

//import ref from vue
import {
    ref
} from 'vue';

//import inertia adapter
import { Inertia } from '@inertiajs/inertia';

//import sweet alert2
import Swal from 'sweetalert2';

export default {
    //layout
    layout: LayoutAdmin,

    //register component
    components: {
        Head,
        Link,
        Pagination
    },

    //props
    props: {
        pendaftarans: Object,
    },

    //inisialisasi composition API
    setup(props) {
        const form = ref({
            allSelected: false,
            student_id: [],
            status: '', // default status
        });

        const selectAll = () => {
            if (form.value.allSelected) {
                form.value.student_id = props.pendaftarans.data.map(p => p.id);
            } else {
                form.value.student_id = [];
            }
        };

        const submitEditStatus = () => {
            if (form.value.student_id.length === 0) {
                Swal.fire('Peringatan', 'Pilih minimal satu pendaftar.', 'warning');
                return;
            }

            Swal.fire({
                title: 'Yakin?',
                text: "Status akan diubah untuk semua pendaftar terpilih.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, ubah!',
            }).then((result) => {
                if (result.isConfirmed) {
                    Inertia.post('/admin/ppdb/bulk-update-status', form.value, {
                        onSuccess: () => {
                            Swal.fire('Berhasil!', 'Status berhasil diperbarui.', 'success');
                            form.value.allSelected = false;
                            form.value.student_id = [];
                        }
                    });
                }
            });
        };

        const currentYear = new Date().getFullYear();
        const search = ref((new URL(document.location)).searchParams.get('q') || '');
        const status = ref((new URL(document.location)).searchParams.get('status') || '');
        const tahun = ref((new URL(document.location)).searchParams.get('tahun') || currentYear.toString());

        const tahunList = Array.from({ length: 20 }, (_, i) => (2022 + i).toString());

        const handleSearch = () => {
            Inertia.get('/admin/ppdb', {
                q: search.value,
                status: status.value,
                tahun: tahun.value
            });
        };


        return {
            search,
            form,
            handleSearch,
            selectAll,
            submitEditStatus,
            status,
            tahun,
            tahunList,
        };
    }

}

</script>

<style></style>
