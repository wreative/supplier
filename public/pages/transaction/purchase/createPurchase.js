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
            etc_price: etc,
            price_items: $("#price_items").val()
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
                data.profit +
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

function getPayment($id) {
    $.ajax({
        url: "/payment/" + $id,
        type: "GET",
        success: function(data) {
            console.log(data.payment);

            // $("#toggle").fireModal({
            //     title: "Modal with Buttons",
            //     center: true,
            //     body: "Modal body text goes here.",
            //     size: "modal-lg",
            //     buttons: [
            //         {
            //             text: "Click, me!",
            //             class: "btn btn-primary btn-shadow",
            //             handler: function(modal) {
            //                 alert("Hello, you clicked me!");
            //             }
            //         }
            //     ]
            // });
            // $("#modal-4").fireModal({
            //     footerClass: "bg-whitesmoke",
            //     body:
            //         "Watashi askdaskdjaskasjkdaskdjkasdjkasjk;dasjkl;djkl;asdjkl Add the <code>bg-whitesmoke</code> class to the <code>footerClass</code> option.",
            //     buttons: [
            //         {
            //             text: "No Action!",
            //             class: "btn btn-primary btn-shadow",
            //             handler: function(modal) {}
            //         }
            //     ]
            // });
            // $("#modal-4").modal("show");
            // $("#modal-4").trigger("click");
            swal({
                title: data.payment.relation_purchase.code,
                text:
                    "Pembayaran menggunakan " +
                    data.payment.relation_payment.name,
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

function changeStatus($id) {
    swal("Ubah status pembelian?", {
        buttons: {
            cancel: "Tidak jadi",
            received: {
                text: "Diterima"
            },
            ordered: {
                text: "Dipesan"
            }
        }
    }).then(value => {
        switch (value) {
            case "ordered":
                swal({
                    title: "Sukses",
                    text: "Status telah diganti menjadi dipesan",
                    icon: "success",
                    button: "Ok",
                    closeOnClickOutside: false
                }).then(() => {
                    location.href = "/status/" + $id + "/" + 0;
                });
                break;

            case "received":
                swal({
                    title: "Sukses",
                    text: "Status telah diganti menjadi diterima",
                    icon: "success",
                    button: "Ok",
                    closeOnClickOutside: false
                }).then(() => {
                    location.href = "/status/" + $id + "/" + 1;
                });
                break;

            default:
                swal("Info", "Status tidak akan dirubah", "info");
        }
    });
}

$("#supplier").fireModal({
    body: $("#modal-supplier"),
    center: true,
    title: "Tambah Data Supplier",
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
    $.ajax({
        url: "/get-price",
        data: {
            id: e.params.data.id
        },
        type: "GET",
        success: function(data) {
            $("#price_items").val(numberWithCommas(data.price));
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
