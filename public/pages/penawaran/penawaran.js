"use strict";

$("#penawaran").dataTable({
    responsive: true
});

function getItem(id) {
    $.ajax({
        url: "/bidding-items",
        data: {
            id: id
        },
        type: "GET",
        success: function(data) {
            if (data.status == "error") {
                swal({
                    title: "Error",
                    text: "Diskon persen yang dimasukkan melebihi 100%",
                    icon: "error",
                    button: "Ok"
                });
                $("#price").val(0);
            } else {
                console.log(data.items);
                const wrapper = document.createElement("div");
                wrapper.innerHTML =
                    "<table class='table table-hover'>" +
                    "<thead><tr><th scope='col'>Nama Barang</th>" +
                    "<th scope='col'>Total</th></tr></thead>" +
                    "<tbody id='sds'>" +
                    "</td></tr>" +
                    "</tbody></table>";
                swal({
                    title: "Cek Penawaran " + data.code,
                    content: wrapper,
                    icon: "info",
                    button: "Tutup"
                });
                for (var i = 0; i < data.total.length; i++) {
                    $("#sds").append(
                        "<tr><th scope='row'>" +
                            data.items[i]["name"] +
                            "</th><td>" +
                            numberWithCommas(data.total[i]) +
                            "</td></tr>"
                    );
                }
            }
        }
    });
}

function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}
