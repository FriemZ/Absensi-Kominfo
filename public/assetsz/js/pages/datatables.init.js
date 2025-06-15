$(document).ready(function () {
    $("#datatable-buttons").DataTable({
        lengthChange: true, // Tampilkan dropdown pilihan banyak data
        pageLength: 7, // Default tampil 10 data
        dom: "Bfrtip",
        buttons: [
            {
                extend: "excel",
                className: "btn btn-success",
            },
            {
                extend: "pdf",
                className: "btn btn-danger",
            },
            {
                extend: "colvis",
                className: "btn btn-secondary",
            },
        ],
    });

    // Optional: Tambahkan class Bootstrap ke select dropdown DataTable
    $(".dataTables_length select").addClass("form-select form-select-sm");
});
