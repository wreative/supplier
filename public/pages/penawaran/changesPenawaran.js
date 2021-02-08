"use strict";

$(".currency")
    .toArray()
    .forEach(function(field) {
        new Cleave(field, {
            numeral: true,
            numeralThousandsGroupStyle: "thousand"
        });
    });

// function save() {
//     var form = $(".form-save");
//     let formdata = new FormData(form[0]);
//     $.ajaxSetup({
//         headers: {
//             "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
//         }
//     });
//     $.ajax({
//         url: "/bidding",
//         data: formdata ? formdata : form.serialize(),
//         type: "POST",
//         processData: false,
//         contentType: false,
//         success: function(data) {
//             console.log(data);
//             // if (data.status == "nulled") {
//             //     swal({
//             //         title: "Data barang kosong",
//             //         text: "Setidaknya tambahkan minimal 1 barang",
//             //         icon: "warning",
//             //         button: "Ok"
//             //     });
//             //     return false;
//             // } else {
//             //     swal({
//             //         title: "Error",
//             //         text: "Hubungi Administrator",
//             //         icon: "error",
//             //         button: "Ok"
//             //     });
//             //     return false;
//             // }
//         }
//     });
// }

function remove_item(argument) {
    $(".remove_" + argument).remove();
}
