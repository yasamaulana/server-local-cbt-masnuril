<template>

    <Head>
        <title>Dashboard Siswa - Aplikasi Ujian Online</title>
    </Head>
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-success border-0 shadow">
                Selamat Datang <strong>{{ auth.student.name }}</strong>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body text-center">
                    <h3><strong class="fw-bold mb-3">Selamat datang di dashboard</strong>
                    </h3>
                    <p>klik dibawah ini untuk melihat list ujian anda</p>
                    <Link href="/student/list-exam"
                        class="btn btn-md text-white btn-success border-0 shadow w-100 mt-2">
                    List Ujian
                    </Link>
                </div>
            </div>
        </div>
        <!-- <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <Link href="/student/presence" class="btn btn-md btn-warning border-0 shadow w-100 mt-2">
                    Absensi Siswa
                    </Link>
                </div>
            </div>
        </div>
        <div v-if="auth.student.ketua_kelas == 2" class="col mt-3">
            <div class="card">
                <div class="card-body">
                    <Link href="/student/presence-teacher" class="btn btn-md btn-primary border-0 shadow w-100 mt-2">
                    Absensi Guru
                    </Link>
                </div>
            </div>
        </div> -->
    </div>
</template>

<script>
//import layout student
import LayoutStudent from '../../../Layouts/Student.vue';

//import Link from Inertia
import {
    Link
} from '@inertiajs/inertia-vue3';

export default {

    //layout
    layout: LayoutStudent,

    //register components
    components: {
        Link,
    },

    //register props
    props: {
        exam_groups: Array,
        auth: Object
    }

}

</script>

<style></style>
