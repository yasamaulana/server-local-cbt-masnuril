<template>
    <Head>
        <title>Keterserapan Lulusan - Aplikasi Ujian Online</title>
    </Head>
    <div class="container-fluid mb-5 mt-5">
        <div class="row">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-5 col-12 mb-2">
                        <div class="row">
                            <div class="col-md-6 col-12 mb-2">
                                <Link href="/admin/keterserapan/create" class="btn btn-md btn-primary border-0 shadow w-100" type="button">
                                    <i class="fa fa-plus-circle"></i> Tambah
                                </Link>
                            </div>
                            <div class="col-md-6 col-12 mb-2">
                                <Link href="/admin/keterserapan/import" class="btn btn-md btn-success border-0 shadow w-100 text-white" type="button">
                                    <i class="fa fa-file-excel"></i> Import
                                </Link>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7 col-12 mb-2">
                        <form @submit.prevent="handleSearch">
                            <div class="input-group">
                                <input type="text" class="form-control border-0 shadow" v-model="search" placeholder="masukkan kata kunci dan enter...">
                                <span class="input-group-text border-0 shadow">
                                    <i class="fa fa-search"></i>
                                </span>
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
                        <div class="table-responsive">
                            <table class="table table-bordered table-centered table-nowrap mb-0 rounded">
                                <thead class="thead-dark">
                                    <tr class="border-0">
                                        <th class="border-0 rounded-start" style="width:5%">No.</th>
                                        <th class="border-0">Program Keahlian</th>
                                        <th class="border-0">Jumlah Laki-Laki</th>
                                        <th class="border-0">Jumlah Perempuan</th>
                                        <th class="border-0">Bekerja</th>
                                        <th class="border-0">Kuliah</th>
                                        <th class="border-0">Usaha</th>
                                        <th class="border-0">Jumlah</th>
                                        <th class="border-0 rounded-end" style="width:15%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in keterserapan.data" :key="item.id">
                                        <td class="fw-bold text-center">
                                            {{ (keterserapan.current_page - 1) * keterserapan.per_page + index + 1 }}
                                        </td>
                                        <td>{{ item.program_keahlian }}</td>
                                        <td>{{ item.jumlah_laki_laki }}</td>
                                        <td>{{ item.jumlah_perempuan }}</td>
                                        <td>{{ item.bekerja }}</td>
                                        <td>{{ item.kuliah }}</td>
                                        <td>{{ item.usaha }}</td>
                                        <td>{{ item.jumlah }}</td>
                                        <td class="text-center">
                                            <Link :href="`/admin/keterserapan/${item.id}/edit`" class="btn btn-sm btn-info border-0 shadow me-2" type="button">
                                                <i class="fa fa-pencil-alt"></i>
                                            </Link>
                                            <button @click.prevent="destroy(item.id)" class="btn btn-sm btn-danger border-0">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <Pagination :links="keterserapan.links" align="end" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import LayoutAdmin from '../../../Layouts/Admin.vue';
import Pagination from '../../../Components/Pagination.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import Swal from 'sweetalert2';

export default {
    layout: LayoutAdmin,
    components: {
        Head,
        Link,
        Pagination
    },
    props: {
        keterserapan: Object,
    },
    setup() {
        const search = ref('' || (new URL(document.location)).searchParams.get('q'));

        const handleSearch = () => {
            Inertia.get('/admin/keterserapan', {
                q: search.value,
            });
        }

        const destroy = (id) => {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda tidak akan dapat mengembalikan ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            })
            .then((result) => {
                if (result.isConfirmed) {
                    Inertia.delete(`/admin/keterserapan/${id}`);
                    Swal.fire({
                        title: 'Deleted!',
                        text: 'Data Keterserapan Lulusan Berhasil Dihapus!.',
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false,
                    });
                }
            })
        }

        return {
            search,
            handleSearch,
            destroy,
        }
    }
}
</script>
