<template>
    <Head>
        <title>Edit struktur-organisasi - Aplikasi Ujian Online</title>
    </Head>
    <div class="container-fluid mb-5 mt-5">
        <div class="row">
            <div class="col-md-12">
                <Link href="/admin/struktur-organisasi" class="btn btn-md btn-primary border-0 shadow mb-3" type="button">
                <i class="fa fa-long-arrow-alt-left me-2"></i> Kembali
                </Link>
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <h5><i class="fa fa-trophy"></i> Edit struktur-organisasi</h5>
                        <hr>
                        <form @submit.prevent="submit">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label>Judul</label>
                                        <input type="text" class="form-control" placeholder="Masukkan Judul struktur-organisasi"
                                            v-model="form.judul">
                                        <div v-if="errors.judul" class="alert alert-danger mt-2">
                                            {{ errors.judul }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label>Foto</label>
                                        <input type="file" class="form-control" @change="handleFileChange">
                                        <div v-if="errors.foto" class="alert alert-danger mt-2">
                                            {{ errors.foto }}
                                        </div>
                                        <div v-if="form.foto_url">
                                            <img :src="form.foto_url" alt="Foto struktur-organisasi" class="img-thumbnail mt-2"
                                                style="width: 100px; height: 100px; object-fit: cover;">
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
        errors: Object,
        struktur: Object,
    },
    setup(props) {
        const form = reactive({
            judul: props.struktur.judul,
            foto: null,
            foto_url: props.struktur.foto ? `/storage/${props.struktur.foto}` : null,
        });

        const handleFileChange = (e) => {
            const file = e.target.files[0];
            if (file) {
                form.foto = file;
                form.foto_url = URL.createObjectURL(file);
            }
        };

        const submit = () => {
            const formData = new FormData();
            formData.append('_method', 'PUT');
            formData.append('judul', form.judul);
            if (form.foto) {
                formData.append('foto', form.foto);
            }

            Inertia.post(`/admin/struktur-organisasi/${props.struktur.id}`, formData, {
                onSuccess: () => {
                    Swal.fire({
                        title: 'Success!',
                        text: 'strukturs Berhasil Diperbarui.',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 2000
                    });
                },
            });
        };

        return {
            form,
            submit,
            handleFileChange
        };
    }
};
</script>
