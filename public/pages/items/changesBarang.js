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

function checkInclude() {
    let exclude = numberWithoutCommas($("#price_exc").val());
    $.ajax({
        url: "/check-include",
        data: { exclude: exclude },
        type: "GET",
        success: function(data) {
            $("#price_inc").val(numberWithCommas(data.include));
        }
    });
}

function checkExclude() {
    let include = numberWithoutCommas($("#price_inc").val());
    $.ajax({
        url: "/check-exclude",
        data: { include: include },
        type: "GET",
        success: function(data) {
            $("#price_exc").val(numberWithCommas(data.exclude));
        }
    });
}

// $(function() {
//     $("#price, #result_ppn,#ppn").on("keyup", function() {
//         let price = parseInt(numberWithoutCommas($("#price").val())) || 0;
//         console.log(price);
//         let ppn = $('input[name="ppn"]:checked').val();
//         if (ppn != 1) {
//             $("#result_ppn").val(price);
//         } else {
//             $("#result_ppn").val(price + (price * 10) / 100);
//         }
//     });
// });

// $(function() {
//     $("input[type=radio]").on("change", function() {
//         console.log($(this).val());
//     });
// });

function checkPPN() {
    let price = $("#price").val() == "" ? 0 : $("#price").val();
    let ppn = $('input[name="ppn"]:checked').val();
    $.ajax({
        url: "/check-ppn",
        data: { ppn: ppn, price: price },
        type: "GET",
        success: function(data) {
            $("#result_ppn").val(data.price);
        }
    });
}

function checkPrice() {
    let price = $("#price").val() == "" ? 0 : $("#price").val();
    let ppn = $('input[name="ppn"]:checked').val();
    let profit = numberWithoutCommas($("#profit").val());
    $.ajax({
        url: "/check-price",
        data: { ppn: ppn, profit: profit, price: price },
        type: "GET",
        success: function(data) {
            if (data.status == "error") {
                swal({
                    title: "Error",
                    text: "Keuntungan yang dimasukkan melebihi 100%",
                    icon: "error",
                    button: "Ok"
                });
                $("#sell_price").val(0);
            } else {
                $("#sell_price").val(data.price);
            }
        }
    });
}

function numberWithoutCommas(x) {
    return x.replace(/,/g, "");
}

function numberWithCommas(x) {
    // return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    // const formatter = new Intl.NumberFormat("id", {
    //     // style: "currency",
    //     // currency: "USD",
    //     minimumFractionDigits: 2
    // });
    // return formatter.format(x);
    return accounting.formatMoney(x, "", 2, ".", ",");
}
