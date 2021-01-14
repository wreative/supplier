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
            if (data.status == "error") {
                swal({
                    title: "Error",
                    text: "Keuntungan yang dimasukkan melebihi 100%",
                    icon: "error",
                    button: "Ok"
                });
                $("#price").val(0);
            } else {
                $("#price").val(numberWithCommas(data.price));
            }
        }
    });
}

function numberWithoutCommas(x) {
    return x.replace(",", "");
}

function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}
