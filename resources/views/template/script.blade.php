{{-- <!-- Latest jQuery -->
<script src="assets/js/jquery-3.6.3.min.js"></script> --}}

<!-- Bootstrap JS -->
<script src="assets/vendor/bootstrap/bootstrap.bundle.min.js"></script>

<!-- Simplebar JS (Custom Scrollbar) -->
<script src="assets/vendor/simplebar/simplebar.js"></script>

<!-- Prism JS (Code Highlighting) -->
<script src="assets/vendor/prism/prism.min.js"></script>

<!-- Customizer -->
<script src="assets/js/customizer.js"></script>

<!-- ApexCharts JS -->
<script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
<script src="assets/js/mixed.js"></script>

<!-- DataTables -->
<script src="assets/vendor/datatable/jquery.dataTables.min.js"></script>
<script src="assets/js/data_table.js"></script>

<!-- DataTables Bootstrap Integration -->
<script src="assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>

<!-- DataTables Buttons -->
<script src="assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
<script src="assets/libs/jszip/jszip.min.js"></script>
<script src="assets/libs/pdfmake/build/pdfmake.min.js"></script>
<script src="assets/libs/pdfmake/build/vfs_fonts.js"></script>
<script src="assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="assets/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>


<!-- DataTables Responsive -->
<script src="assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

<!-- DataTable Init -->
<script src="assets/js/pages/datatables.init.js"></script>

{{-- Baru tambahkan script update total keterlambatan --}}
<script>
    $(document).ready(function() {
        var table = $('#datatable-buttons').DataTable();

        function updateTotalTerlambat() {
            let total = 0;
            table.rows({
                search: 'applied'
            }).every(function() {
                const cell = $(this.node()).find('.terlambat-cell').text();
                const menit = parseInt(cell) || 0;
                total += menit;
            });

            $('#total-terlambat').text(total + ' menit');
            $('#tfoot-terlambat').text(total);
        }

        table.on('search.dt draw.dt', updateTotalTerlambat);
        updateTotalTerlambat();
    });
</script>

<!-- Toastify -->
<script src="assets/vendor/notifications/toastify-js.js"></script>

<!-- Main App JS -->
<script src="assets/js/script.js"></script>
{{-- <script src="assets/js/app.js"></script> --}}
