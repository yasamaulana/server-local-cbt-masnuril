<template>

    <Head>
        <title>Edit Sekolah - Aplikasi Ujian Online</title>
    </Head>
    <div class="container-fluid mb-5 mt-5">
        <div class="row">
            <div class="col-md-12">
                <Link href="/admin/scedule" class="btn btn-md btn-primary border-0 shadow mb-3" type="button"><i
                    class="fa fa-long-arrow-alt-left me-2"></i> Kembali</Link>
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <h5><i class="fa fa-bookmark"></i> Edit Nama Sekolah</h5>
                        <hr />
                        <form @submit.prevent="submit">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label>Nama Guru</label>
                                        <select class="form-select select2" v-model="form.teacher_id" ref="select">
                                            <option v-for="(teacher, index) in teachers" :key="index"
                                                :value="teacher.id">{{ teacher.name }}</option>
                                        </select>
                                        <div v-if="errors.teacher_id" class="alert alert-danger mt-2">
                                            {{ errors.teacher_id }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label>Mata Pelajaran</label>
                                        <select class="form-select select2" v-model="form.lesson_id" ref="select">
                                            <option v-for="(lesson, index) in lessons" :key="index" :value="lesson.id">
                                                {{ lesson.title }}</option>
                                        </select>
                                        <div v-if="errors.lesson_id" class="alert alert-danger mt-2">
                                            {{ errors.lesson_id }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label>Kelas</label>
                                        <select class="form-select select2" v-model="form.class_id" ref="select">
                                            <option v-for="(classroom, index) in classrooms" :key="index"
                                                :value="classroom.id">{{ classroom.title }}</option>
                                        </select>
                                        <div v-if="errors.class_id" class="alert alert-danger mt-2">
                                            {{ errors.class_id }}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label>Hari</label>
                                        <select class="form-select" v-model="form.day">
                                            <option value="Senin">Senin</option>
                                            <option value="Selasa">Selasa</option>
                                            <option value="Rabu">Rabu</option>
                                            <option value="Kamis">Kamis</option>
                                            <option value="Jumat">Jumat</option>
                                            <option value="Sabtu">Sabtu</option>
                                            <option value="Minggu">Minggu</option>
                                        </select>
                                        <div v-if="errors.day" class="alert alert-danger mt-2">
                                            {{ errors.day }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label>Waktu Mulai</label>
                                        <Datepicker time-picker v-model="form.start_time" />
                                        <div v-if="errors.start_time" class="alert alert-danger mt-2">
                                            {{ errors.start_time }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label>Waktu Selesai</label>
                                        <Datepicker time-picker v-model="form.end_time" />
                                        <div v-if="errors.end_time" class="alert alert-danger mt-2">
                                            {{ errors.end_time }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-md btn-primary border-0 shadow me-2">
                                Update
                            </button>
                            <button type="reset" class="btn btn-md btn-warning border-0 shadow">
                                Reset
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
//import layout
import LayoutAdmin from "../../../Layouts/Admin.vue";

//import Head and Link from Inertia
import { Head, Link } from "@inertiajs/inertia-vue3";

//import reactive from vue
import { reactive } from "vue";

//import inertia adapter
import { Inertia } from "@inertiajs/inertia";

//import sweet alert2
import Swal from "sweetalert2";

//import datepicker
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';

export default {
    //layout
    layout: LayoutAdmin,

    //register components
    components: {
        Head,
        Link,
        Datepicker
    },

    //props
    props: {
        errors: Object,
        scedule: Object,
        teachers: Array,
        lessons: Array,
        classrooms: Array,
    },

    //inisialisasi composition API
    setup(props) {
        const parseTimeString = (timeString) => {
            const [hours, minutes, seconds] = timeString.split(':').map(Number);
            return { hours, minutes, seconds };
        };

        // Initialize form with reactive and parsed times
        const form = reactive({
            teacher_id: props.scedule.teacher_id,
            lesson_id: props.scedule.lesson_id,
            class_id: props.scedule.class_id,
            day: props.scedule.day,
            start_time: parseTimeString(props.scedule.start_time),
            end_time: parseTimeString(props.scedule.end_time),
        });
        ;

        const formatTime = (time) => {
            const hours = String(time.hours).padStart(2, '0');
            const minutes = String(time.minutes).padStart(2, '0');
            const seconds = String(time.seconds).padStart(2, '0');
            return `${hours}:${minutes}:${seconds}`;
        };

        const updateStartTime = (value) => {
            form.start_time = value;
        };

        const updateEndTime = (value) => {
            form.end_time = value;
        };

        //method "submit"
        const submit = () => {
            const start_time_formatted = formatTime(form.start_time);
            const end_time_formatted = formatTime(form.end_time);

            Inertia.put(
                `/admin/scedule/${props.scedule.id}`,
                {
                    teacher_id: form.teacher_id,
                    lesson_id: form.lesson_id,
                    class_id: form.class_id,
                    day: form.day,
                    start_time: start_time_formatted,
                    end_time: end_time_formatted,
                },
                {
                    onSuccess: () => {
                        //show success alert
                        Swal.fire({
                            title: "Success!",
                            text: "Jadwal berhasil diperbarui!",
                            icon: "success",
                            showConfirmButton: false,
                            timer: 2000,
                        });
                    },
                }
            );
        };

        //return
        return {
            form,
            submit,
            updateStartTime,
            updateEndTime,
        };
    },
};
</script>

<style></style>
