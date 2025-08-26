<template>
    <div>

        <Head>
            <title>Absensi Guru - Aplikasi Ujian Online</title>
        </Head>
        <Link href="/student/dashboard" class="btn btn-md btn-primary border-0 shadow mb-3" type="button"><i
            class="fa fa-long-arrow-alt-left me-2"></i> Kembali</Link>
        <div class="card">
            <div class="card-title text-center fw-bold text-center">
                <h3 class="mt-2">Absensi Guru</h3>
            </div>
            <div class="card-body" v-if="teacher">
                <div class="text-center">
                    <button class="btn btn-primary btn-sm mb-2" @click="getPositionFirst">Lokasi Saya</button>
                </div>
                <div id="map" style="height: 500px; margin-bottom: 20px;"></div>
                <p class="text-center">Klik tombol di bawah ini untuk melakukan absensi guru, oleh ketua dengan nama
                    <span class="fw-bold">
                        {{ auth.student.name }}</span>
                </p>

                <div class="d-flex justify-content-center">
                    <table>
                        <tr>
                            <td>Pengajar </td>
                            <td class="fw-bold">: {{ teacher.teacher.name }}</td>
                        </tr>
                        <tr>
                            <td>Mata Pelajaran</td>
                            <td class="fw-bold">: {{ teacher.lesson.title }}</td>
                        </tr>
                        <tr>
                            <td>Kelas Mengajar</td>
                            <td class="fw-bold">: {{ teacher.class.title }}</td>
                        </tr>
                        <tr>
                            <td>Hari</td>
                            <td class="fw-bold">: {{ teacher.day }}</td>
                        </tr>
                        <tr>
                            <td>Jam Mata Pelajaran</td>
                            <td class="fw-bold">: {{ teacher.start_time }} Sampai {{ teacher.end_time }}</td>
                        </tr>
                    </table>
                </div>
                <div class="text-center mt-4">
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select id="status" v-model="status" class="form-select">
                            <option value="hadir">Hadir</option>
                            <option value="izin">Izin</option>
                            <option value="sakit">Sakit</option>
                            <option value="alpha">Alpha</option>
                        </select>
                    </div>
                    <button :disabled="hasAbsensiToday" @click="getLocation" class="btn btn-primary">{{ hasAbsensiToday
                        ?
                        'Sudah Absen' : 'Absen Masuk' }}</button>
                </div>
            </div>
            <div class="card" v-else>
                <div class="card-body">
                    <h4 class="text-center">Belum ada jadwal tersedia</h4>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { defineComponent } from 'vue';
import LayoutStudent from '../../../Layouts/Student.vue';
import L from 'leaflet';
import 'leaflet/dist/leaflet.css';
import axios from 'axios';
import { Link } from '@inertiajs/inertia-vue3';
import Swal from 'sweetalert2';

export default defineComponent({
    name: 'AbsensiSiswa',
    components: {
        Link,
    },
    // layout
    layout: LayoutStudent,
    props: {
        teacher: Object,
        auth: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            latitude: -6.901971, // Default center latitude
            longitude: 109.504981, // Default center longitude
            map: null,
            status: 'hadir',
            allowedRadius: 150, // Radius in meters
            centerLat: -6.901971, // Center latitude
            centerLng: 109.504981, // Center longitude
            hasAbsensiToday: false // Initialize with false
        };
    },

    mounted() {
        this.checkAbsensiToday();
        this.initMap(); // Initialize the map with default coordinates
        this.getPositionFirst(); // Initialize the map with default coordinates
    },

    methods: {
        async getPositionFirst() {
            try {
                const position = await this.getCurrentPosition();
                this.getPosition(position);
            } catch (error) {
                this.showError(error);
            }
        },
        getPosition(position) {
            this.latitude = position.coords.latitude;
            this.longitude = position.coords.longitude;
            this.updateMap();
        },

        async checkAbsensiToday() {
            try {
                const response = await axios.get('/student/check-absensi-today-teacher');
                this.hasAbsensiToday = response.data.hasAbsensiToday;
            } catch (error) {
                console.error(error);
            }
        },
        async getLocation() {
            try {
                const position = await this.getCurrentPosition();
                this.showPosition(position);
            } catch (error) {
                this.showError(error);
            }
        },
        showPosition(position) {
            this.latitude = position.coords.latitude;
            this.longitude = position.coords.longitude;

            const distance = this.calculateDistance(this.latitude, this.longitude, this.centerLat, this.centerLng);
            if (this.status === 'hadir' && distance > this.allowedRadius) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    text: "Anda berada di luar radius yang diizinkan untuk status 'hadir'."
                });
            } else {
                this.updateMap(); // Update the map with the user's location
                this.absenMasuk();
            }
        },
        getCurrentPosition() {
            return new Promise((resolve, reject) => {
                navigator.geolocation.getCurrentPosition(resolve, reject);
            });
        },
        showError(error) {
            let errorMessage = "An unknown error occurred.";
            switch (error.code) {
                case error.PERMISSION_DENIED:
                    errorMessage = "User denied the request for Geolocation.";
                    break;
                case error.POSITION_UNAVAILABLE:
                    errorMessage = "Location information is unavailable.";
                    break;
                case error.TIMEOUT:
                    errorMessage = "The request to get user location timed out.";
                    break;
            }
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: errorMessage
            });
        },
        initMap() {
            if (this.map) {
                this.map.remove();
            }

            this.map = L.map('map').setView([this.latitude, this.longitude], 20);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© Innovart Development'
            }).addTo(this.map);

            // Create SVG pin icon
            const pinIcon = L.divIcon({
                html: `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                        <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6"/>
                        </svg>`,
                className: 'text-warning',
                iconSize: [24, 24],
                iconAnchor: [12, 24],
                popupAnchor: [0, -24]
            });

            // Add marker with SVG pin icon
            L.marker([this.latitude, this.longitude], { icon: pinIcon }).addTo(this.map)
                .bindPopup('Your current location')
                .openPopup();

            // Add allowed radius circle
            L.circle([this.centerLat, this.centerLng], {
                color: 'red',
                fillColor: '#f03',
                fillOpacity: 0.5,
                radius: this.allowedRadius
            }).addTo(this.map)
                .bindPopup('Allowed radius');

            // Optionally add a circle at the current location
            L.circle([this.latitude, this.longitude], {
                color: 'blue',
                fillColor: '#30f',
                fillOpacity: 0.5,
                radius: 10 // Small radius to mark the current location
            }).addTo(this.map)
                .bindPopup('Your current location');
        },
        updateMap() {
            if (!this.map) {
                this.initMap();
                return;
            }

            // Update the map view to the new coordinates
            this.map.setView([this.latitude, this.longitude], 20);

            // Clear existing layers
            this.map.eachLayer((layer) => {
                if (layer instanceof L.Marker || layer instanceof L.Circle) {
                    this.map.removeLayer(layer);
                }
            });

            // Create SVG pin icon
            const pinIcon = L.divIcon({
                html: `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map-pin"><path d="M21 10c0 6-9 13-9 13S3 16 3 10a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>`,
                className: '', // Remove default CSS class for custom styling
                iconSize: [24, 24],
                iconAnchor: [12, 24],
                popupAnchor: [0, -24]
            });

            // Add marker with SVG pin icon
            L.marker([this.latitude, this.longitude], { icon: pinIcon }).addTo(this.map)
                .bindPopup('Your current location')
                .openPopup();

            // Add allowed radius circle
            L.circle([this.centerLat, this.centerLng], {
                color: 'red',
                fillColor: '#f03',
                fillOpacity: 0.5,
                radius: this.allowedRadius
            }).addTo(this.map)
                .bindPopup('Allowed radius');

            // Optionally add a circle at the current location
            L.circle([this.latitude, this.longitude], {
                color: 'blue',
                fillColor: '#30f',
                fillOpacity: 0.5,
                radius: 100 // Small radius to mark the current location
            }).addTo(this.map)
                .bindPopup('Your current location');
        },

        calculateDistance(lat1, lng1, lat2, lng2) {
            const R = 6371e3; // meters
            const φ1 = lat1 * Math.PI / 180; // φ, λ in radians
            const φ2 = lat2 * Math.PI / 180;
            const Δφ = (lat2 - lat1) * Math.PI / 180;
            const Δλ = (lng2 - lng1) * Math.PI / 180;

            const a = Math.sin(Δφ / 2) * Math.sin(Δφ / 2) +
                Math.cos(φ1) * Math.cos(φ2) *
                Math.sin(Δλ / 2) * Math.sin(Δλ / 2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));

            const d = R * c; // in meters
            return d;
        },

        absenMasuk() {
            axios.post('/student/presence-submit-teacher', {
                teacher_id: this.teacher.teacher_id,
                lesson_id: this.teacher.lesson_id,
                class_id: this.teacher.class_id,
                latitude: this.latitude,
                longitude: this.longitude,
                status: this.status
            })
                .then(response => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Absen Berhasil',
                        text: response.data.message
                    }).then(() => {
                        this.resetData();
                    });
                })
                .catch(error => {
                    console.error(error);
                    alert("Failed to submit attendance.");
                });
        },

        resetData() {
            this.status = 'hadir';
            this.hasAbsensiToday = true;
            this.checkAbsensiToday();
        }
    }
});
</script>

<style>
#map {
    height: 500px;
}
</style>