"use strict";

function save() {
    var name = $('input[name ="name"]').val();
    var desc = $('textarea[name ="desc"]').val();
    if (name == "" || desc == "") {
        Swal.fire({
            title: "Error",
            text: "Pastikan data tidak ada yang kosong.",
            icon: "error",
            confirmButtonText: "Ok"
        });
        return false;
    }
    var form = $("form");
    formdata = new FormData(form[0]);
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });
    $.ajax({
        url: "",
        data: formdata ? formdata : form.serialize(),
        type: "post",
        processData: false,
        contentType: false,
        success: function(data) {
            if (data.status == "sukses") {
                Swal.fire({
                    title: "Data sudah disimpan.",
                    icon: "success",
                    confirmButtonText: "Ok"
                }).then(function(result) {
                    location.href = "";
                });
            } else {
                Swal.fire({
                    title: "Gambar melebihi 2MB.",
                    icon: "warning",
                    confirmButtonText: "Ok"
                });
                return false;
            }
        }
    });
}

function remove_item(argument) {
    $(".remove_" + argument).remove();
}
