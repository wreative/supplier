"use strict";

$(".currency")
    .toArray()
    .forEach(function(field) {
        new Cleave(field, {
            numeral: true,
            numeralThousandsGroupStyle: "thousand"
        });
    });

function getPrice() {
    let total = $("#total").val();
    let items = $("#items").val();
    let dsc_nom = numberWithoutCommas($("#dsc_nom").val());
    let dsc_per = $("#dsc_per").val();
    let dp = numberWithoutCommas($("#dp").val());
    let ppn = $('input[name="ppn"]:checked').val();
    $.ajax({
        url: "/check-purchase",
        data: {
            total: total,
            items: items,
            dsc_nom: dsc_nom,
            dsc_per: dsc_per,
            dp: dp,
            ppn: ppn
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
                var name = data.hasil[0];
                var price = data.hasil[1];
                var discount = data.hasil[2];
                var total = data.hasil[3];
                var tax = data.hasil[4];
                var dp = data.hasil[5];
                var totalPrice = data.hasil[6];
                const wrapper = document.createElement("div");
                wrapper.innerHTML =
                    "<table class='table table-hover'><thead><tr><th scope='col'>Nama</th><th scope='col'>Detail</th></tr></thead><tbody><tr><th scope='row'>Nama Item</th><td>" +
                    name +
                    "</td></tr><tr><th scope='row'>Harga PerItem</th><td>Rp." +
                    numberWithCommas(price) +
                    "</td></tr><tr><th scope='row'>Diskon</th><td>Rp." +
                    numberWithCommas(discount) +
                    "</td></tr><tr><th scope='row'>Jumlah</th><td>" +
                    numberWithCommas(total) +
                    " Item" +
                    "</td></tr><tr><th scope='row'>Pajak 10%</th><td>Rp." +
                    numberWithCommas(tax) +
                    "</td></tr><tr><th scope='row'>Pembayaran DP</th><td>Rp." +
                    numberWithCommas(dp) +
                    "</td></tr><tr><th scope='row'>Total Harga</th><td>Rp." +
                    numberWithCommas(totalPrice) +
                    "</td></tr></tbody></table>";
                swal({
                    title: "Cek Pembelian Item " + name,
                    content: wrapper,
                    icon: "info",
                    button: "Tutup"
                });
            }
        }
    });
}

function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function numberWithoutCommas(x) {
    return x.replace(",", "");
}
