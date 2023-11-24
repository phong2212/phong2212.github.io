$(document).ready(function () {

    $('#EditDest').submit(function (event) {
        event.preventDefault();
        var eformData = new FormData(this);
        var e_Name = $("#D_eName").val().trim();
        var e_Description = $("#eDescription").val().trim();
        var e_Location = $("#eLocation").val().trim();
        var e_image = $("#eimg").val().trim();
        var e_Continent = $("#eContinentID").val().trim();


        var eNameRegex = /^[a-zA-Z\sàáạảãâầấậẩẫăằắặẳẵèéẹẻẽêềếệểễìíịỉĩòóọỏõôồốộổỗơờớợởỡùúụủũưừứựửữỳýỵỷỹđĐ,]+$/;
        var eLocationRegex = /^[a-zA-Z\sàáạảãâầấậẩẫăằắặẳẵèéẹẻẽêềếệểễìíịỉĩòóọỏõôồốộổỗơờớợởỡùúụủũưừứựửữỳýỵỷỹđĐ,]+$/;

        var flag = true;

        if (e_Name === "") {
            var html = "Bạn chưa nhập tên địa điểm kìa!";
            $('#en_validation').html(html);
            $('#D_eName').addClass('is-invalid');
            flag = false;
        } else {
            if (!eNameRegex.test(e_Name)) {
                var html = "Không được nhập số hay kí tự đặc biệt!";
                $('#en_validation').html(html);
                $('#D_eName').addClass('is-invalid');
                $('#D_eName').removeClass('is-valid');
                flag = false;
            } else {
                $('#D_eName').addClass('is-valid');
                $('#D_eName').removeClass('is-invalid');
            }
        }

        if (e_Description === "") {
            var html = "Bạn chưa nhập mô tả kìa!";
            $('#ed_validation').html(html);
            $('#eDescription').addClass('is-invalid');
            flag = false;
        } else {
            $('#eDescription').addClass('is-valid');
            $('#eDescription').removeClass('is-invalid');
        }

        if (e_Location === "") {
            var html = "Bạn chưa nhập vị trí kìa!";
            $('#el_validation').html(html);
            $('#eLocation').addClass('is-invalid');
            flag = false;
        } else {
            if (!eLocationRegex.test(e_Location)) {
                var html = "Không được nhập số hay kí tự đặc biệt!";
                $('#el_validation').html(html);
                $('#eLocation').addClass('is-invalid');
                flag = false;
            } else {
                $('#eLocation').addClass('is-valid');
                $('#eLocation').removeClass('is-invalid');
            }
        }


        if (e_image === "") {
            var html = "Bạn chưa thêm ảnh kìa!";
            $('#ei_validation').html(html);
            $('#eimg').addClass('is-invalid');
            flag = false;
        } else {
            $('#eimg').addClass('is-valid');
            $('#eimg').removeClass('is-invalid');
        }

        if (e_Continent === "") {
            var html = "Bạn chưa chọn châu lục kìa!";
            $('#ec_validation').html(html);
            $('#eContinentID').addClass('is-invalid');
            flag = false;
        } else {
            $('#eContinentID').addClass('is-valid');
            $('#eContinentID').removeClass('is-invalid');
        }

        if (flag) {
            $.ajax({
                url: "/edit/destination",
                type: "POST",
                processData: false,
                contentType: false,
                data: eformData,
                success: function (response) {
                    if (response === "success") {
                        $("#replace").html('');
                        $("#cResult").html('<h6 class="text-success">Thêm địa điểm mới thành công</h6>');
                    } else {
                        console.log(response);
                        $("#cResult").html('<h6 class="text-danger">Ảnh vượt quá 10MB</h6>');
                        $("#replace").html('<button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#AddModel">Quay lại</button>');

                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                    $("#replace").html('<button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#AddModel">Quay lại</button>');
                    $("#cResult").html('<h6 class="text-danger">Thêm địa điểm mới không thành công</h6>');
                }
            });
        }
    });

    $("#reload").click(function (e) {
        location.reload();
    });
});
