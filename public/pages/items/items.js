"use strict";

$("#items").dataTable({
    responsive: true,
    lengthMenu: [
        [10, 25, 50, -1],
        [10, 25, 50, "Semua"]
    ],
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

