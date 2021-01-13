"use strict";

$(".currency")
    .toArray()
    .forEach(function(field) {
        new Cleave(field, {
            numeral: true,
            numeralThousandsGroupStyle: "thousand"
        });
    });

// function checkPrice() {
//     let exclude = parseInt(numberWithoutCommas($("#price_exc").val())) || 0;
//     let include = parseInt(numberWithoutCommas($("#price_inc").val())) || 0;
//     let profit = parseInt(numberWithoutCommas($("#profit").val())) || 0;
//     if (include != "" && profit >= 100) {
//         $("#price").val(numberWithCommas(include + profit));
//     } else {
//         $("#profit").val("Tidak Boleh Lebih Dari 100");
//     }
// }

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
            console.log(data);
            $("#price_exc").val(numberWithCommas(data.exclude));
        }
    });
}

function checkPrice() {
    let include = numberWithoutCommas($("#price_inc").val());
    let profit = numberWithoutCommas($("#profit").val());
    $.ajax({
        url: "/check-price",
        data: { include: include, profit: profit },
        type: "GET",
        success: function(data) {
            $("#price").val(numberWithCommas(data.price));
        }
    });
}

function numberWithoutCommas(x) {
    return x.replace(",", "");
}

function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}
