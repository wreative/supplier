"use strict";

$("#report").dataTable({
    responsive: true,
    dom: "Bfrtip",
    buttons: [
        {
            extend: "print",
            customize: function(win) {
                $(win.document.body)
                    .css("font-size", "20pt")
                    .prepend(
                        '<img src="http://datatables.net/media/images/logo-fade.png" style="position:absolute; top:0; left:0;" />'
                    );

                $(win.document.body)
                    .find("table")
                    .addClass("compact")
                    .css("font-size", "inherit");
            }
        }
    ],
    lengthMenu: [
        [10, 25, 50, -1],
        [10, 25, 50, "Semua"]
    ]
});
