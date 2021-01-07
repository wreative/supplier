"use strict";

$(".currency")
    .toArray()
    .forEach(function(field) {
        new Cleave(field, {
            numeral: true,
            numeralThousandsGroupStyle: "thousand"
        });
    });

function checkInclude() {
    let exclude = parseInt(numberWithoutCommas($("#price_exc").val())) || 0;
    $("#price_inc").val(
        numberWithCommas(Math.round(exclude + (exclude * 10) / 100))
    );
}

function checkExclude() {
    let include = parseInt(numberWithoutCommas($("#price_inc").val())) || 0;
    $("#price_exc").val(numberWithCommas(Math.ceil(include / 1.1)));
}

// function checkProfit() {
//     var exclude = parseInt($("#price_exc").val()) || 0;
// }

function checkPrice() {
    let exclude = parseInt(numberWithoutCommas($("#price_exc").val())) || 0;
    let include = parseInt(numberWithoutCommas($("#price_inc").val())) || 0;
    let profit = parseInt(numberWithoutCommas($("#profit").val())) || 0;
    if (include != null || include != "" || include != " ") {
        var final = include;
    } else {
        var final = exclude;
    }
    $("#price").val(numberWithCommas(final + profit));
}

function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function numberWithoutCommas(x) {
    return x.replace(",", "");
}
