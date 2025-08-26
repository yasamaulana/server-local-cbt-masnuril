<template>

    <Head>
        <title>Tambah Guru - Aplikasi Ujian Online</title>
    </Head>
    <div class="container-fluid mb-5 mt-5">
        <div class="row">
            <div class="col-md-12">
                <Link href="/admin/teachers" class="btn btn-md btn-primary border-0 shadow mb-3" type="button">
                <i class="fa fa-long-arrow-alt-left me-2"></i> Kembali
                </Link>
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <h5><i class="fa fa-user"></i> Tambah Guru</h5>
                        <hr>
                        <form @submit.prevent="submit">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label>Nama Lengkap</label>
                                        <input type="text" class="form-control" placeholder="Masukkan Nama Lengkap"
                                            v-model="form.name">
                                        <div v-if="errors.name" class="alert alert-danger mt-2">
                                            {{ errors.name }}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label>Email</label>
                                        <input type="email" class="form-control" placeholder="Masukkan Email"
                                            v-model="form.email">
                                        <div v-if="errors.email" class="alert alert-danger mt-2">
                                            {{ errors.email }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label>Jenis Kelamin</label>
                                        <select class="form-select" v-model="form.gender">
                                            <option value="L">Laki - Laki</option>
                                            <option value="P">Perempuan</option>
                                        </select>
                                        <div v-if="errors.gender" class="alert alert-danger mt-2">
                                            {{ errors.gender }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label>Alamat</label>
                                        <input type="text" class="form-control" placeholder="Masukkan Alamat"
                                            v-model="form.address">
                                        <div v-if="errors.address" class="alert alert-danger mt-2">
                                            {{ errors.address }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label>Posisi</label>
                                        <select class="form-select" v-model="form.position">
                                            <option value="Guru">Guru</option>
                                            <option value="Staf">Staf</option>
                                            <option value="Kepala Sekolah">Kepala Sekolah</option>
                                        </select>
                                        <div v-if="errors.position" class="alert alert-danger mt-2">
                                            {{ errors.position }}
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
//import layout
import LayoutAdmin from '../../../Layouts/Admin.vue';

//import Head and Link from Inertia
import { Head, Link } from '@inertiajs/inertia-vue3';

//import reactive from vue
import { reactive } from 'vue';

//import inertia adapter
import { Inertia } from '@inertiajs/inertia';

//import sweet alert2
import Swal from 'sweetalert2';

export default {

    //layout
    layout: LayoutAdmin,

    //register components
    components: {
        Head,
        Link
    },

    //props
    props: {
        errors: Object
    },

    //inisialisasi composition API
    setup() {

        //define form with reactive
        const form = reactive({
            name: '',
            email: '',
            gender: '',
            address: '',
            position: '',
            foto: null
        });

        //method "handleFileUpload"
        const handleFileUpload = (event) => {
            form.foto = event.target.files[0];
        };

        //method "submit"
        const submit = () => {
            //create FormData object
            const formData = new FormData();
            formData.append('name', form.name);
            formData.append('email', form.email);
            formData.append('gender', form.gender);
            formData.append('address', form.address);
            formData.append('position', form.position);
            if (form.foto) {
                formData.append('foto', form.foto);
            }

            //send data to server
            Inertia.post('/admin/teachers', formData, {
                onSuccess: () => {
                    //show success alert
                    Swal.fire({
                        title: 'Success!',
                        text: 'Guru Berhasil Disimpan.',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 2000
                    });
                },
            });
        };

        //return
        return {
            form,
            handleFileUpload,
            submit
        };
    }
};
</script>
