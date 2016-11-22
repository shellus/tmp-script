$.ajax({
    type: "POST",
    url: "",
    dataType: "json",
    data: JSON.stringify($('#form-login').serializeArray()),
    contentType: "application/json; charset=utf-8",
    success: function (data) {
        console.log(data);
    }
})
