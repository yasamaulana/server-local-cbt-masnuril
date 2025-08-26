<template>

    <Head>
        <title>Tambah Keterserapan Lulusan - Aplikasi Ujian Online</title>
    </Head>
    <div class="container-fluid mb-5 mt-5">
        <div class="row">
            <div class="col-md-12">
                <Link href="/admin/keterserapan" class="btn btn-md btn-primary border-0 shadow mb-3" type="button">
                <i class="fa fa-long-arrow-alt-left me-2"></i> Kembali
                </Link>
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <h5><i class="fa fa-user"></i> Tambah Keterserapan Lulusan</h5>
                        <hr>
                        <form @submit.prevent="submit">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label>Program Keahlian</label>
                                        <input type="text" class="form-control" placeholder="Masukkan Program Keahlian"
                                            v-model="form.program_keahlian">
                                        <div v-if="errors.program_keahlian" class="alert alert-danger mt-2">
                                            {{ errors.program_keahlian }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label>Jumlah Laki-Laki</label>
                                        <input type="number" class="form-control"
                                            placeholder="Masukkan jumlah_laki_laki" v-model="form.jumlah_laki_laki">
                                        <div v-if="errors.jumlah_laki_laki" class="alert alert-danger mt-2">
                                            {{ errors.jumlah_laki_laki }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label>Jumlah Perempuan</label>
                                        <input type="number" class="form-control"
                                            placeholder="Masukkan Jumlah Perempuan" v-model="form.jumlah_perempuan">
                                        <div v-if="errors.jumlah_perempuan" class="alert alert-danger mt-2">
                                            {{ errors.jumlah_perempuan }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label>Jumlah Bekerja</label>
                                        <input type="number" class="form-control" placeholder="Masukkan Bekerja"
                                            v-model="form.bekerja">
                                        <div v-if="errors.bekerja" class="alert alert-danger mt-2">
                                            {{ errors.bekerja }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label>Jumlah Kuliah</label>
                                        <input type="number" class="form-control" placeholder="Masukkan Jumlah Kuliah"
                                            v-model="form.kuliah">
                                        <div v-if="errors.kuliah" class="alert alert-danger mt-2">
                                            {{ errors.kuliah }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label>Jumlah Berwirausaha</label>
                                        <input type="number" class="form-control" placeholder="Masukkan Jumlah Usaha"
                                            v-model="form.usaha">
                                        <div v-if="errors.usaha" class="alert alert-danger mt-2">
                                            {{ errors.usaha }}
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" v-model="form.jumlah">
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
import { useForm } from '@inertiajs/inertia-vue3';
import { watch } from 'vue';
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
        const form = useForm({
            program_keahlian: '',
            jumlah_laki_laki: 0,
            jumlah_perempuan: 0,
            bekerja: 0,
            kuliah: 0,
            usaha: 0,
            jumlah: 0,
        });

        const submit = () => {
            form.post('/admin/keterserapan', {
                onSuccess: () => {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Data Keterserapan Lulusan Berhasil Disimpan.',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 2000
                    });
                    form.reset();
                },
            });
        };

        watch([form.jumlah_laki_laki, form.jumlah_perempuan], () => {
            form.jumlah = form.jumlah_laki_laki + form.jumlah_perempuan;
        });

        return {
            form,
            submit,
        };
    },
};
</script>
