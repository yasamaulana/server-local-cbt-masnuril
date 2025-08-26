<template>

    <Head>
        <title>Laporan Absensi - Aplikasi Absensi Online</title>
    </Head>
    <div class="container-fluid mb-5 mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow mb-4">
                    <div class="card-body">
                        <h5><i class="fa fa-filter"></i> Filter Absensi</h5>
                        <hr>
                        <form @submit.prevent="filter">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="control-label" for="month">Bulan</label>
                                    <input type="month" class="form-control" v-model="form.month">
                                    <div v-if="errors.month" class="alert alert-danger mt-2">
                                        {{ errors.month }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="control-label" for="classroom_id">Kelas</label>
                                    <select class="form-select" v-model="form.classroom_id">
                                        <option value="">Semua Kelas</option>
                                        <option v-for="(classroom, index) in classrooms" :key="index"
                                            :value="classroom.id">{{ classroom.title }}</option>
                                    </select>
                                    <div v-if="errors.classroom_id" class="alert alert-danger mt-2">
                                        {{ errors.classroom_id }}
                                    </div>
                                </div>
                                <div class="col-md-12 mt-3">
                                    <button type="submit" class="btn btn-md btn-primary border-0 shadow w-100">
                                        <i class="fa fa-filter"></i> Filter
                                    </button>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <div class="d-flex justify-content-end mb-3">
                            <a :href="exportUrl" class="btn btn-md btn-success border-0 shadow mt-3">
                                <i class="fa fa-download"></i> Export
                            </a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th v-for="day in daysInMonth" :key="day">{{ day }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="student in attendance" :key="student.name">
                                        <td>{{ student.name }}</td>
                                        <td v-for="(status, day) in student.attendance" :key="day">{{ status }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
// import layout Admin
import LayoutAdmin from '../../../../Layouts/Admin.vue';

// import Head from Inertia
import { Head } from '@inertiajs/inertia-vue3';

// import reactive from vue
import { reactive, computed } from 'vue';

// import inertia adapter
import { Inertia } from '@inertiajs/inertia';

export default {
    // layout
    layout: LayoutAdmin,

    // register components
    components: {
        Head,
    },

    // props
    props: {
        errors: Object,
        attendance: Array,
        month: String,
        classrooms: Array,
    },

    // inisialisasi composition API
    setup(props) {
        // define state
        const form = reactive({
            month: props.month || (new URL(document.location)).searchParams.get('month'),
            classroom_id: '' || (new URL(document.location)).searchParams.get('classroom_id'),
        });

        const filter = () => {
            Inertia.get('/admin/presence-student', {
                month: form.month,
                classroom_id: form.classroom_id,
            });
        };

        const daysInMonth = computed(() => {
            if (!form.month) return [];
            const [year, month] = form.month.split('-').map(Number);
            return Array.from({ length: new Date(year, month, 0).getDate() }, (_, i) => i + 1);
        });

        const exportUrl = computed(() => {
            const params = new URLSearchParams();
            if (form.month) params.append('month', form.month);
            if (form.classroom_id) params.append('classroom_id', form.classroom_id);
            return `/admin/presence-student/export?${params.toString()}`;
        });

        return {
            form,
            filter,
            daysInMonth,
            exportUrl,
        };
    },
};
</script>

<style></style>
