"use strict";

$(".currency")
    .toArray()
    .forEach(function(field) {
        new Cleave(field, {
            numeral: true,
            numeralDecimalMark: ".",
            delimiter: ","
        });
    });

$(".tlp")
    .toArray()
    .forEach(function(field) {
        new Cleave(field, {
            prefix: "+62",
            delimiter: " ",
            phone: true,
            phoneRegionCode: "id"
        });
    });

function getPrice() {
    let total = $("#total").val();
    let items = $("#items").val();
    let ship = $("#ship_price").val();
    let etc = $("#etc_price").val();
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
            ppn: ppn,
            ship_price: ship,
            etc_price: etc
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
            } else if (data.status == "null") {
                swal({
                    title: "Error",
                    text: "Total barang harus di isi dan minimal 1 barang",
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
                    "</td></tr><tr><th scope='row'>PPN 10%</th><td>Rp." +
                    numberWithCommas(tax) +
                    "</td></tr><tr><th scope='row'>Pembayaran DP</th><td>Rp." +
                    numberWithCommas(dp) +
                    "</td></tr><tr><th scope='row'>Biaya Kirim</th><td>Rp." +
                    numberWithCommas(data.hasil[9]) +
                    "</td></tr><tr><th scope='row'>Biaya Lain</th><td>Rp." +
                    numberWithCommas(data.hasil[10]) +
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
        },
        error: function(data) {
            if (data.status == 401) {
                swal({
                    title: "Error",
                    text:
                        "Maaf anda telah logout secara otomatis silahkan melakukan login kembali",
                    icon: "error",
                    button: "Ok"
                }).then(() => {
                    location.reload();
                });
            }
        }
    });
}

function getItems() {
    let items = $("#items").val();
    $.ajax({
        url: "/check-items",
        data: {
            items: items
        },
        type: "GET",
        success: function(data) {
            console.log(data);
            const wrapper = document.createElement("div");
            wrapper.innerHTML =
                "<table class='table table-hover'><thead><tr><th scope='col'>Nama</th><th scope='col'>Detail</th></tr></thead><tbody><tr><th scope='row'>Kode</th><td>" +
                data.items.code +
                "</td></tr><tr><th scope='row'>Nama</th><td>" +
                data.items.name +
                "</td></tr><tr><th scope='row'>Stok</th><td>" +
                data.items.stock +
                " " +
                data.items.relation_units.name +
                "</td></tr><tr><th scope='row'>Harga Pokok</th><td>Rp." +
                numberWithCommas(data.items.relation_detail.price) +
                "</td></tr><tr><th scope='row'>PPN 10%</th><td>Rp." +
                numberWithCommas(data.ppn) +
                "</td></tr><tr><th scope='row'>Keuntungan</th><td>" +
                data.items.relation_detail.profit +
                "%" +
                "</td></tr><tr><th scope='row'>Harga Jual</th><td>Rp." +
                numberWithCommas(data.items.relation_detail.sell_price) +
                "</td></tr></tbody></table>";
            swal({
                title: "Cek Data Barang " + data.items.name,
                content: wrapper,
                icon: "info",
                button: "Tutup"
            });
        },
        error: function(data) {
            if (data.status == 401) {
                swal({
                    title: "Error",
                    text:
                        "Maaf anda telah logout secara otomatis silahkan melakukan login kembali",
                    icon: "error",
                    button: "Ok"
                }).then(() => {
                    location.reload();
                });
            }
        }
    });
}

$("#marketer").fireModal({
    body: $("#modal-marketer"),
    center: true,
    title: "Tambah Data Sales",
    size: "modal-lg",
    buttons: [
        {
            text: "Tambah",
            submit: true,
            class: "btn btn-primary btn-shadow",
            handler: function() {}
        }
    ]
});

$("#customer").fireModal({
    body: $("#modal-customer"),
    center: true,
    title: "Tambah Data Customer",
    size: "modal-lg",
    buttons: [
        {
            text: "Tambah",
            submit: true,
            class: "btn btn-primary btn-shadow",
            handler: function() {}
        }
    ]
});

$("#items").on("select2:select", function(e) {
    let data = e.params.data.id;
    $.ajax({
        url: "/get-price",
        data: {
            id: data
        },
        type: "GET",
        success: function(data) {
            console.log(data.price);
            $("#price_items").val(data.price);
        },
        error: function(data) {
            if (data.status == 401) {
                swal({
                    title: "Error",
                    text:
                        "Maaf anda telah logout secara otomatis silahkan melakukan login kembali",
                    icon: "error",
                    button: "Ok"
                }).then(() => {
                    location.reload();
                });
            }
        }
    });
});

function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function numberWithoutCommas(x) {
    return x.replace(",", "");
}
