<template>

    <Head>
        <title>Postingan - Aplikasi CMS</title>
    </Head>

    <div class="container-fluid mt-5 mb-5">
        <div class="row">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-3 col-12 mb-2">
                        <Link href="/admin/postingan/create" class="btn btn-md btn-primary w-100 shadow border-0">
                        <i class="fa fa-plus-circle"></i> Tambah
                        </Link>
                    </div>
                    <div class="col-md-9 col-12 mb-2">
                        <form @submit.prevent="handleSearch">
                            <div class="input-group">
                                <input type="text" class="form-control shadow border-0" v-model="search"
                                    placeholder="Cari postingan...">
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
                                <thead class="table-dark">
                                    <tr>
                                        <th style="width:5%">No</th>
                                        <th>Judul</th>
                                        <th>Banner</th>
                                        <th>Dibuat</th>
                                        <th>Status</th>
                                        <th style="width:15%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(post, index) in posts.data" :key="post.id">
                                        <td class="text-center">{{ ++index + (posts.current_page - 1) * posts.per_page
                                            }}</td>
                                        <td>{{ truncateWords(post.title) }}</td>
                                        <td><img :src="post.banner ? `/storage/${post.banner}` : ''" alt="Banner"
                                                class="img-fluid" style="width: 100px;"></td>
                                        <td>{{ formatDate(post.created_at) }}</td>
                                        <td>{{ post.status }}</td>
                                        <td class="text-center">
                                            <div class="d-flex align-items-center justify-content-center gap-2">
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-secondary dropdown-toggle"
                                                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        Status
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a class="dropdown-item" href="#"
                                                                @click.prevent="changeStatus(post.id, 'published')">Published</a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="#"
                                                                @click.prevent="changeStatus(post.id, 'draft')">Draft</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <Link :href="`/admin/postingan/${post.id}/edit`"
                                                    class="btn btn-sm btn-info">
                                                <i class="fa fa-edit"></i>
                                                </Link>
                                                <button @click.prevent="destroy(post.id)" class="btn btn-sm btn-danger">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <Pagination :links="posts.links" align="end" />
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
        Head, Link, Pagination
    },
    props: {
        posts: Object,
    },
    setup() {
        const truncateWords = (text, wordLimit = 5) => {
            const words = text.split(' ');
            return words.length > wordLimit
                ? words.slice(0, wordLimit).join(' ') + '...'
                : text;
        };

        const search = ref('' || (new URL(document.location)).searchParams.get('q'));

        const handleSearch = () => {
            Inertia.get('/admin/postingan', {
                q: search.value,
            });
        }

        const destroy = (id) => {
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Data tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    Inertia.delete(`/admin/postingan/${id}`);
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Postingan telah dihapus.',
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false,
                    });
                }
            });
        }

        const changeStatus = (id, status) => {
            Swal.fire({
                title: 'Yakin?',
                text: `Ubah status postingan menjadi ${status}?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, ubah!'
            }).then((result) => {
                if (result.isConfirmed) {
                    Inertia.put(`/admin/postingan/${id}/status`, { status }, {
                        onSuccess: () => {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: `Status berhasil diubah menjadi ${status}.`,
                                timer: 2000,
                                showConfirmButton: false
                            });
                        }
                    });
                }
            });
        };

        const formatDate = (dateStr) => {
            const options = { year: 'numeric', month: 'long', day: 'numeric' };
            return new Date(dateStr).toLocaleDateString('id-ID', options);
        }

        return {
            search,
            handleSearch,
            destroy,
            formatDate,
            truncateWords,
            changeStatus
        }
    }
}
</script>
