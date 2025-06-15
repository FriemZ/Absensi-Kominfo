        <!-- plugin js -->
        <script src="assetsz/js/plugin.js"></script>
        <!-- theme js -->
        <script src="assetsz/js/theme.js"></script>






        <!-- data table js -->
        <script src="assets/vendor/datatable/jquery.dataTables.min.js"></script>
        <!-- js-->
        <script src="assets/js/data_table.js"></script>

        <!-- App js-->
        <script src="assets/js/script.js"></script>


        <!-- Required datatable js -->
        <script src="assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>

        <!-- Buttons examples -->
        <script src="assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
        <script src="assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
        <script src="assets/libs/jszip/jszip.min.js"></script>
        <script src="assets/libs/pdfmake/build/pdfmake.min.js"></script>
        <script src="assets/libs/pdfmake/build/vfs_fonts.js"></script>
        <script src="assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
        <script src="assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
        <script src="assets/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>

        <!-- Responsive examples -->
        <script src="assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
        <script src="assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

        <!-- Datatable init js -->
        <script src="assetsz/js/pages/datatables.init.js"></script>

        <script src="assets/js/app.js"></script>

        <script>
            function updateClockAndDate() {
                const dateEl = document.getElementById("realtime-date");
                const timeEl = document.getElementById("realtime-time");
                if (!dateEl || !timeEl) return;

                const now = new Date();
                const days = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
                const months = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September",
                    "Oktober", "November", "Desember"
                ];

                const dayName = days[now.getDay()];
                const day = now.getDate();
                const month = months[now.getMonth()];
                const year = now.getFullYear();

                const hours = String(now.getHours()).padStart(2, '0');
                const minutes = String(now.getMinutes()).padStart(2, '0');
                const seconds = String(now.getSeconds()).padStart(2, '0');

                dateEl.textContent = `${dayName}, ${day} ${month} ${year}`;
                timeEl.textContent = `${hours}:${minutes}:${seconds}`;
            }

            document.addEventListener("DOMContentLoaded", function() {
                updateClockAndDate();
                setInterval(updateClockAndDate, 1000);
            });
        </script>


        @stack('gpsscript')
        @stack('camscript')
