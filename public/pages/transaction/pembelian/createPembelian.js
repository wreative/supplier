"use strict";

$(".currency")
    .toArray()
    .forEach(function(field) {
        new Cleave(field, {
            numeral: true,
            numeralThousandsGroupStyle: "thousand"
        });
    });

// $(function() {
//     $("#price_inc, #price_exc, #profit, #price").on("keyup", function() {
//         let include = parseInt($("#price_inc").val()) || 0;
//         let exclude = parseInt($("#price_exc").val()) || 0;
//         let profit = parseInt($("#profit").val()) || 0;
//         let price = parseInt($("#price").val()) || 0;
//         // $("#price_inc").val(
//         //     numberWithCommas(Math.round((panjang * lebar * tinggi) / 4000))
//         // );
//         $("#price_exc").val(include * 1.1);
//         // $("#profit").val(
//         //     numberWithCommas(Math.round((panjang * lebar * tinggi) / 6000))
//         // );
//         $("#price").val(include | (exclude + profit));
//     });
// });

// function numberWithCommas(x) {
//     return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
// }
