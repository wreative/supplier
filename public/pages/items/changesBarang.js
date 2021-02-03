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
    let profit_nom = $("#profit_nom").val() == "" ? 0 : $("#profit_nom").val();
    $.ajax({
        url: "/check-price",
        data: {
            ppn: ppn,
            profit: profit,
            price: price,
            profit_nom: profit_nom
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
                $("#sell_price").val(0);
            } else {
                $("#sell_price").val(data.price);
            }
        }
    });
}

// $("#profit, #result_ppn, #profit_nom").on("keyup", function() {
//     let result_ppn = $("#result_ppn")
//         .val()
//         .replace(",", "");
//     let profit = $("#profit").val();
//     let profit_nom = $("#profit_nom")
//         .val()
//         .replace(",", "");
//     $("#profit").val((profit_nom * 100) / result_ppn);
//     $("#profit_nom").val((profit_nom * profit) / 100);
//     // $("#profit").val((numberWithoutCommas(profit_nom) / result_ppn) * 100);
//     // let ppn = $('input[name="ppn"]:checked').val();
//     // if (ppn != 1) {
//     //     $("#result_ppn").val(price);
//     // } else {
//     //     $("#result_ppn").val(price + (price * 10) / 100);
//     // }
// });

$("#profit, #result_ppn").on("keyup", function() {
    let result_ppn = $("#result_ppn")
        .val()
        .replace(",", "");
    let profit = $("#profit").val();
    $("#profit_nom").val(numberWithCommas((result_ppn * profit) / 100));
});

$("#result_ppn, #profit_nom").on("keyup", function() {
    let result_ppn = $("#result_ppn")
        .val()
        .replace(",", "");
    let profit_nom = $("#profit_nom")
        .val()
        .replace(",", "");
    $("#profit").val(Math.round((profit_nom * 100) / result_ppn));
});

function numberWithoutCommas(x) {
    return x.replace(/,/g, "");
}

function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}
