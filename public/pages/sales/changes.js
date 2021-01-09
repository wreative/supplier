"use strict";

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
