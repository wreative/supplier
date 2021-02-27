"use strict";

$("#items").dataTable({
    responsive: true,
    autoWidth: true,
    dom: "lBfrtip",
    lengthMenu: [
        [10, 25, 50, -1],
        [10, 25, 50, "Semua"]
    ],
    buttons: [
        {
            extend: "print",
            text: "Print Semua",
            exportOptions: {
                modifier: {
                    selected: null
                },
                columns: ":visible"
            },
            messageTop: "Dokumen dikeluarkan tanggal " + moment().format("L"),
            // footer: true,
            header: true,
            customize: function(win) {
                $(win.document.body)
                    .css("font-size", "15pt")
                    .prepend(
                        '<img src="http://stock.test/img/logo/watermark.png" style="position:absolute; top:500px; left:0; margin:auto; opacity: 0.2;" />'
                    );

                $(win.document.body)
                    .find("table")
                    .addClass("compact")
                    .css("font-size", "inherit");
            }
        },
        {
            extend: "print",
            text: "Print Yang Dipilih",
            exportOptions: {
                columns: ":visible"
            }
        },
        {
            extend: "excelHtml5",
            exportOptions: {
                columns: ":visible"
            }
        },
        {
            extend: "pdfHtml5",
            exportOptions: {
                columns: [0, 1, 2, 5]
            }
        },
        {
            extend: "colvis",
            text: "Sembunyikan Kolom"
        }
    ],
    select: true
});

// $("#table-items").dataTable({
//     processing: true,
//     responsive: true,
//     serverSide: true,
//     ajax: "/items",
//     columns: [
//         { data: "id" },
//         { data: "name" },
//         { data: "email" },
//         {
//             data: "action",
//             name: "action",
//             orderable: false,
//             searchable: false
//         }
//     ]
// });
