$(document).ready(function () {
    //Preview image upon selecting of image to be uploaded
    var _URL = window.URL || window.webkitURL;
    $("#uploaded_photo").change(function () {
        var file, img;

        if ((file = this.files[0])) {
            img = new Image();
            img.onload = function () {
                if (this.width === 600 && this.height === 600) {
                    var oFReader = new FileReader();

                    oFReader.readAsDataURL(document.getElementById("uploaded_photo").files[0]);
                    oFReader.onload = function (oFREvent) {
                        document.getElementById("upload_preview").src = oFREvent.target.result;
                    };
                } else {
                    $("#uploaded_photo").val('');
                    alert('Make sure that image has 600 x 600 dimensions!');
                }
            };
            img.src = _URL.createObjectURL(file);
        }
    });
});

//Function that checks image dimension
function check_image_dimension() {
    var _URL = window.URL || window.webkitURL;
    $("#uploaded_photo").change(function (e) {
        var file, img;
        if ((file = this.files[0])) {
            img = new Image();
            img.onload = function () {
                alert(this.width + " " + this.height);
            };
            img.src = _URL.createObjectURL(file);
        }
    });
}

//Function that adds a record
function submit_add_form() {
    $('#add_form').submit();
}

//Function that updates a record
function submit_edit_form() {
    $('#edit_form').submit();
}

//A function which includes a confirm dialogue if a records really needs to be deleted
function confirm_delete_page(id) {
    var r = confirm("Delete this record?");
    if (r == true) {
        return delete_page(id);
    }
}

//Function that deletes a record
function delete_page(id) {
    $.ajax({
        url: 'http://localhost/basic_crud/dashboard/page/delete',
        type: 'post',
        dataType: 'json',
        data: {
            id: function () {
                return id;
            },
        },
        success: function (result) {
            var result_data = jQuery.parseJSON(JSON.stringify(result));
            var status = result_data.status;
            var message = result_data.message;

            if (status != 'undefined' || typeof status != "undefined") {
                if (status != 0 || status != '0') {
                    alert(message);
                    window.location.reload();
                } else {
                    alert(message);
                }
            } else {
                message = "Unexpected error occured! Please try again.";
                alert(message);
            }

        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(errorThrown);
        }
    });
}