<template>
    <Head>
        <title>Edit Kemitraan - Aplikasi Ujian Online</title>
    </Head>
    <div class="container-fluid mb-5 mt-5">
        <div class="row">
            <div class="col-md-12">
                <Link href="/admin/kemitraan" class="btn btn-md btn-primary border-0 shadow mb-3" type="button">
                    <i class="fa fa-long-arrow-alt-left me-2"></i> Kembali
                </Link>
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <h5><i class="fa fa-user"></i> Edit Kemitraan</h5>
                        <hr>
                        <form @submit.prevent="submit">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label>Judul</label>
                                        <input type="text" class="form-control" placeholder="Judul" v-model="judul" />
                                        <div v-if="errors.judul" class="text-danger">{{ errors.judul }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label>Deskripsi</label>
                                        <input type="text" class="form-control" placeholder="Deskripsi" v-model="deskripsi" />
                                        <div v-if="errors.deskripsi" class="text-danger">{{ errors.deskripsi }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label>Foto</label>
                                        <input type="file" class="form-control" @change="handleFotoChange" />
                                        <div v-if="errors.foto" class="text-danger">{{ errors.foto }}</div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-md btn-primary me-2">
                                    <i class="fa fa-save"></i> Save
                                </button>
                                <button type="reset" class="btn btn-md btn-warning">
                                    <i class="fa fa-redo"></i> Reset
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3';
import LayoutAdmin from '../../../Layouts/Admin.vue';
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';

export default {
    layout: LayoutAdmin,
    components: {
        Head,
        Link
    },
    props: {
        kemitraan: Object,
    },
    setup(props) {
        const judul = ref(props.kemitraan.judul);
        const deskripsi = ref(props.kemitraan.deskripsi);
        const foto = ref(null);
        const errors = ref({});

        const handleFotoChange = (e) => {
            foto.value = e.target.files[0];
        };

        const submit = () => {
            const formData = new FormData();
            formData.append('_method', 'PUT');
            formData.append('judul', judul.value);
            formData.append('deskripsi', deskripsi.value);
            if (foto.value) {
                formData.append('foto', foto.value);
            }

            Inertia.post(`/admin/kemitraan/${props.kemitraan.id}`, formData, {
                onError: (error) => {
                    errors.value = error;
                }
            });
        };

        return {
            judul,
            deskripsi,
            foto,
            errors,
            handleFotoChange,
            submit
        };
    }
};
</script>

<style>
/* Your styles here */
</style>
