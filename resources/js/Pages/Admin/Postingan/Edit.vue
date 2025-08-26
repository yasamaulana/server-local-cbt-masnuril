<template>

    <Head>
        <title>Edit Postingan - Aplikasi Ujian Online</title>
    </Head>
    <div class="container-fluid mb-5 mt-5">
        <div class="row">
            <div class="col-md-12">
                <Link href="/admin/postingan" class="btn btn-md btn-primary border-0 shadow mb-3" type="button">
                <i class="fa fa-long-arrow-alt-left me-2"></i> Kembali
                </Link>
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <h5><i class="far fa-newspaper"></i> Edit Postingan</h5>
                        <hr>
                        <form @submit.prevent="submit">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label>Judul</label>
                                        <input type="text" class="form-control" placeholder="Judul" v-model="title" />
                                        <div v-if="errors.title" class="text-danger">{{ errors.title }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label>Banner</label>
                                        <input type="file" class="form-control" accept="image/*"
                                            @change="handleBannerChange" />
                                        <div v-if="errors.banner" class="text-danger">{{ errors.banner }}</div>
                                        <div v-if="banner_url">
                                            <img :src="banner_url" alt="Foto Guru" class="img-thumbnail mt-2"
                                                style="width: 200px; height: 200px; object-fit: cover;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label>Isi Postingan</label>
                                <TextEditor v-model="content" />
                                <div v-if="errors.content" class="alert alert-danger mt-2">
                                    {{ errors.content }}
                                </div>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-md btn-primary me-2">
                                    <i class="fa fa-save"></i> Update
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
import TextEditor from '../../../Components/TextEditor.vue';

export default {
    layout: LayoutAdmin,
    components: {
        Head,
        Link,
        TextEditor
    },
    props: {
        postingan: Object,
    },
    setup(props) {
        const title = ref(props.postingan.title);
        const content = ref(props.postingan.content);
        const banner = ref(null);
        const errors = ref({});
        const banner_url = ref(props.postingan.banner ? `/storage/${props.postingan.banner}` : null);

        const handleBannerChange = (e) => {
            banner.value = e.target.files[0];
        };

        const submit = () => {
            const formData = new FormData();
            formData.append('_method', 'PUT');
            formData.append('title', title.value);
            formData.append('content', content.value);
            if (banner.value) {
                formData.append('banner', banner.value);
            }

            Inertia.post(`/admin/postingan/${props.postingan.id}`, formData, {
                onError: (error) => {
                    errors.value = error;
                }
            });
        };

        return {
            title,
            content,
            banner,
            banner_url,
            errors,
            handleBannerChange,
            submit
        };
    }
};
</script>

<style>
/* Your styles here */
</style>
