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
    $.ajax({
        url: "/check-purchase",
        data: {
            total: total,
            items: items,
            dsc_nom: dsc_nom,
            dsc_per: dsc_per,
            dp: dp
        },
        type: "GET",
        success: function(data) {
            if (data.status == "error") {
                swal({
                    title: "Error",
                    text: "Keuntungan yang dimasukkan melebihi 100%",
                    icon: "error",
                    button: "Ok"
                });
                $("#price").val(0);
            } else {
                // $("#price").val(numberWithCommas(data.price));
                console.log(data.hasil);
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
