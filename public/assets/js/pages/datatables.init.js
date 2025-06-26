// $(document).ready(function () {
//     $("#datatable").DataTable(),
//         $("#datatable-buttons")
//             .DataTable({
//                 lengthChange: !1,
//                 buttons: ["", "excel", "pdf", "colvis"],
//             })
//             .buttons()
//             .container()
//             .appendTo("#datatable-buttons_wrapper .col-md-6:eq(0)"),
//         $(".dataTables_length select").addClass("form-select form-select-sm");
// });

$(document).ready(function () {
    // Inisialisasi untuk #datatable (jika ada)
    if ($("#datatable").length && !$.fn.dataTable.isDataTable("#datatable")) {
        $("#datatable").DataTable();
    }

    // Inisialisasi untuk #datatable-buttons
    if (
        $("#datatable-buttons").length &&
        !$.fn.dataTable.isDataTable("#datatable-buttons")
    ) {
        const dt = $("#datatable-buttons").DataTable({
            lengthChange: false,
            buttons: [
                { extend: "excel", footer: true },
                { extend: "pdf", footer: true },
                { extend: "colvis", footer: false },
            ],
            order: [], // ⛔ Nonaktifkan sorting default (agar urutan Senin–Minggu tidak berubah)
        });

        dt.buttons()
            .container()
            .appendTo("#datatable-buttons_wrapper .col-md-6:eq(0)");
    }

    $(".dataTables_length select").addClass("form-select form-select-sm");
});
