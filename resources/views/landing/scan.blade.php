@extends('templatez.templating')

@section('content')
    {{-- Leaflet CSS & JS --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>

    {{-- Custom CSS --}}
    <link rel="stylesheet" href="{{ asset('assets/css/scan.css') }}">

    <section class="about-feature-counter section-pt mt-4">
        <div class="container">
            {{-- Jika internal atau nasional libur --}}
            @if ($isHoliday)
                <div class="text-center" style="margin-top:90px;">
                    <img src="{{ asset('assetsz/image/libur.png') }}" alt="Hari Libur"
                        style="max-width:350px; border:2px solid #ebebeb;">
                </div>
            @elseif (!$isScanAllowed)
                <div class="text-center" style="margin-top:90px;">
                    <img src="{{ asset('assetsz/image/Belum.png') }}" alt="Belum Waktu Absen"
                        style="max-width:350px; border:2px solid #ebebeb;">
                    @if ($infoMessage)
                        <p class="mt-3 fw-bold">{{ $infoMessage }}</p>
                    @endif
                </div>
            @else
                {{-- Notifikasi jika lokasi tidak sesuai --}}
                <div id="not-location" class="text-center" style="display: none; margin-top:100px;">
                    <img src="{{ asset('assetsz/image/not_location.png') }}" alt="Lokasi Tidak Cocok"
                        style="max-width:350px; border: 2px solid rgb(235, 235, 235); display: block;">
                    {{-- <p class="mt-3 text-danger fw-bold">Anda tidak berada di area dinas.</p> --}}
                </div>

                {{-- Kontainer absensi --}}
                <div class="absensi-container mb-5" style="display: none;">
                    <div id="camera-area">
                        <div class="webcam" id="webcam"></div>
                    </div>

                    {{-- Status Proses --}}
                    <div id="statusIndicator" class="mt-2 d-flex align-items-center gap-2 fw-bold">
                        <div id="spinner" class="spinner-border" style="display: none; width: 18px; height: 18px;"></div>
                        <p id="status-indicator">⏳ Menyiapkan kamera...</p>
                    </div>

                    <input type="hidden" id="lokasi" name="lokasi">
                    <div id="map" class="z-0 mt-3" style="height: 300px;"></div>
                </div>
            @endif
        </div>
    </section>
@endsection

@push('gpsscript')
    <script>
        // Koordinat dan radius dinas dari backend
        const dinasLat = {{ $dinas->latitude }};
        const dinasLng = {{ $dinas->longitude }};
        const dinasRadius = {{ $dinas->radius_absen }};

        const lokasiInput = document.getElementById('lokasi');

        // Fungsi hitung jarak Haversine (meter)
        function getDistance(lat1, lon1, lat2, lon2) {
            const R = 6371e3; // Radius bumi dalam meter
            const toRad = deg => deg * Math.PI / 180;
            const dLat = toRad(lat2 - lat1);
            const dLon = toRad(lon2 - lon1);

            const a = Math.sin(dLat / 2) ** 2 +
                Math.cos(toRad(lat1)) * Math.cos(toRad(lat2)) *
                Math.sin(dLon / 2) ** 2;
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));

            return R * c;
        }

        // Dummy fungsi kamera & scan (ganti dengan implementasi asli)
        function startWebcam() {
            console.log("Webcam dimulai");
        }

        function startAutoScan() {
            console.log("Scan otomatis dimulai");
        }

        function resetWebcam() {
            console.log("Webcam di-reset");
        }

        // Callback berhasil dapat lokasi
        function successCallback(position) {
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;
            const accuracy = position.coords.accuracy;

            lokasiInput.value = `${lat},${lng}`;

            const distance = getDistance(lat, lng, dinasLat, dinasLng);
            console.log(`Jarak ke dinas: ${distance.toFixed(2)} meter | Akurasi: ${accuracy} meter`);

            // Cek lokasi valid
            if (distance > dinasRadius || accuracy > 50) {
                // Lokasi di luar zona
                document.querySelector('.absensi-container').style.display = 'none';
                document.getElementById('not-location').style.display = 'block';
                resetWebcam();
                return;
            }

            // Lokasi valid
            document.querySelector('.absensi-container').style.display = 'block';
            document.getElementById('not-location').style.display = 'none';

            if (typeof startWebcam === 'function') startWebcam();
            if (typeof startAutoScan === 'function') startAutoScan();
        }

        // Callback error saat ambil lokasi
        function errorCallback(error) {
            let message = "❗ Gagal mendapatkan lokasi.";
            switch (error.code) {
                case error.PERMISSION_DENIED:
                    message = "❌ Izin lokasi ditolak. Aktifkan GPS & beri izin lokasi.";
                    break;
                case error.POSITION_UNAVAILABLE:
                    message = "⚠️ Informasi lokasi tidak tersedia.";
                    break;
                case error.TIMEOUT:
                    message = "⏱️ Permintaan lokasi terlalu lama. Coba lagi.";
                    break;
            }
            alert(message);

            lokasiInput.value = "";
            document.querySelector('.absensi-container').style.display = 'none';
            document.getElementById('not-location').style.display = 'block';
            resetWebcam();
        }

        // Minta lokasi dengan akurasi tinggi
        function requestLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(successCallback, errorCallback, {
                    enableHighAccuracy: true,
                    timeout: 30000,
                    maximumAge: 0
                });
            } else {
                alert("Browser tidak mendukung Geolocation");
                lokasiInput.value = "";
                document.querySelector('.absensi-container').style.display = 'none';
                document.getElementById('not-location').style.display = 'block';
                resetWebcam();
            }
        }

        window.onload = requestLocation;
    </script>
@endpush

@push('camscript')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js"></script>

    <script>
        let matched = false;

        function setStatus(text, loading = false) {
            const statusIndicator = document.getElementById('status-indicator');
            const spinner = document.getElementById('spinner');

            if (statusIndicator) statusIndicator.textContent = text;
            if (spinner) spinner.style.display = loading ? 'inline-block' : 'none';
        }

        function startWebcam() {
            Webcam.set({
                width: 320,
                height: 240,
                image_format: 'jpeg',
                jpeg_quality: 70,
                flip_horiz: true
            });
            Webcam.attach('#webcam');
        }

        function startAutoScan() {
            let attempts = 0;
            const maxAttempts = 10;
            const timeoutDuration = 20000;
            const startTime = Date.now();
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            function scan() {
                if (matched || attempts >= maxAttempts || (Date.now() - startTime) > timeoutDuration) {
                    setStatus("❌ Wajah tidak cocok.");
                    Swal.fire({
                        icon: 'error',
                        title: 'Wajah Tidak Cocok',
                        text: 'Silakan coba ulang proses scan.',
                        confirmButtonText: 'Kembali'
                    }).then(() => {
                        window.location.href = "/home";
                    });
                    return;
                }

                attempts++;
                setStatus(`📷 Mencoba scan wajah (Percobaan ke-${attempts})...`, true);

                Webcam.snap(data_uri => {
                    setStatus("⏳ Mengirim ke server...", true);

                    fetch("/scan-wajah/check", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": csrfToken,
                                "X-Requested-With": "XMLHttpRequest"
                            },
                            body: JSON.stringify({
                                image: data_uri
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.absen) {
                                matched = true;
                                setStatus("✅ Absensi berhasil!");

                                Swal.fire({
                                    icon: 'success',
                                    title: 'Absensi Berhasil!',
                                    text: 'Data wajah cocok dan absensi tercatat.',
                                    confirmButtonText: 'Lihat Riwayat'
                                }).then(() => {
                                    window.location.href = "/history";
                                });
                            } else if (data.error) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: data.error,
                                    confirmButtonText: 'Kembali'
                                }).then(() => {
                                    window.location.href = "/home";
                                });
                            } else {
                                setStatus("😕 Wajah belum cocok, mencoba lagi...");
                                setTimeout(scan, 3000);
                            }
                        })
                        .catch(err => {
                            console.error(err);
                            setStatus(`❌ Gagal koneksi ke server: ${err.message}`);
                            Swal.fire({
                                icon: 'error',
                                title: 'Koneksi Gagal',
                                text: `Tidak dapat terhubung ke server: ${err.message}`,
                                confirmButtonText: 'Ulangi'
                            });
                            setTimeout(scan, 3000);
                        });
                });
            }

            // Mulai 1 detik setelah kamera aktif
            setTimeout(scan, 1000);
        }

        window.addEventListener('beforeunload', () => Webcam.reset());
        document.addEventListener('visibilitychange', () => {
            if (document.hidden) Webcam.reset();
        });
    </script>
@endpush
