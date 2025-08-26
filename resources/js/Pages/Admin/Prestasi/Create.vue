<template>
    <Head>
        <title>Tambah Prestasi - Aplikasi Ujian Online</title>
    </Head>
    <div class="container-fluid mb-5 mt-5">
        <div class="row">
            <div class="col-md-12">
                <Link href="/admin/prestasi" class="btn btn-md btn-primary border-0 shadow mb-3" type="button">
                <i class="fa fa-long-arrow-alt-left me-2"></i> Kembali
                </Link>
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <h5><i class="fa fa-user"></i> Tambah Prestasi</h5>
                        <hr>
                        <form @submit.prevent="submit">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label>Judul</label>
                                        <input type="text" class="form-control" placeholder="Masukkan Judul" v-model="form.judul">
                                        <div v-if="errors.judul" class="alert alert-danger mt-2">
                                            {{ errors.judul }}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label>Deskripsi</label>
                                        <input type="text" class="form-control" placeholder="Masukkan Deskripsi" v-model="form.deskripsi">
                                        <div v-if="errors.deskripsi" class="alert alert-danger mt-2">
                                            {{ errors.deskripsi }}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label>Foto</label>
                                        <input type="file" class="form-control" @change="handleFileUpload">
                                        <div v-if="errors.foto" class="alert alert-danger mt-2">
                                            {{ errors.foto }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-md btn-primary border-0 shadow me-2">Simpan</button>
                            <button type="reset" class="btn btn-md btn-warning border-0 shadow">Reset</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import LayoutAdmin from '../../../Layouts/Admin.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import { reactive } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import Swal from 'sweetalert2';

export default {
    layout: LayoutAdmin,
    components: {
        Head,
        Link
    },
    props: {
        errors: Object
    },
    setup() {
        const form = reactive({
            judul: '',
            deskripsi: '',
            foto: null
        });

        const handleFileUpload = (event) => {
            form.foto = event.target.files[0];
        };

        const submit = () => {
            const formData = new FormData();
            formData.append('judul', form.judul);
            formData.append('deskripsi', form.deskripsi);
            if (form.foto) {
                formData.append('foto', form.foto);
            }

            Inertia.post('/admin/prestasi', formData, {
                onSuccess: () => {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Prestasi Berhasil Disimpan.',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 2000
                    });
                },
            });
        };

        return {
            form,
            handleFileUpload,
            submit
        };
    }
};
</script>

<style>
/* Your styles here */
</style>
