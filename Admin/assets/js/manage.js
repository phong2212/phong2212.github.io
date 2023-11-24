$(document).ready(function () {
    $('#T_user').DataTable();
    $("#S_user").click(function () {
        $('#T_user').DataTable();
        $("#user").show();
        $("#dest").hide();
        $("#blog").hide();
    });

    $("#S_dest").click(function () {
        $('#T_dest').DataTable();
        $("#user").hide();
        $("#dest").show();
        $("#blog").hide();
    });

    $("#S_blog").click(function () {
        $('#T_blog').DataTable();
        $("#user").hide();
        $("#dest").hide();
        $("#blog").show();
    });

    $('.zoom-image').click(function () {
        $('#myModal').css('display', 'block');
        $('#img01').attr('src', $(this).data('large'));
    });

    $('.close').click(function () {
        $('#myModal').css('display', 'none');
    });

    $(window).click(function (event) {
        if (event.target.id === 'myModal') {
            $('#myModal').css('display', 'none');
        }
    });

    $('#AddDest').submit(function (event) {
        event.preventDefault();
        var formData = new FormData(this);
        var Name = $("#D_Name").val().trim();
        var Description = $("#Description").val().trim();
        var Location = $("#Location").val().trim();
        var image = $("#img").val().trim();
        var Continent = $("#ContinentID").val().trim();


        var NameRegex = /^[a-zA-Z\sàáạảãâầấậẩẫăằắặẳẵèéẹẻẽêềếệểễìíịỉĩòóọỏõôồốộổỗơờớợởỡùúụủũưừứựửữỳýỵỷỹđĐ,]+$/;
        var LocationRegex = /^[a-zA-Z\sàáạảãâầấậẩẫăằắặẳẵèéẹẻẽêềếệểễìíịỉĩòóọỏõôồốộổỗơờớợởỡùúụủũưừứựửữỳýỵỷỹđĐ,]+$/;

        var flag = true;

        if (Name === "") {
            var html = "Bạn chưa nhập tên địa điểm kìa!";
            $('#n_validation').html(html);
            $('#D_Name').addClass('is-invalid');
            flag = false;
        } else {
            if (!NameRegex.test(Name)) {
                var html = "Không được nhập số hay kí tự đặc biệt!";
                $('#n_validation').html(html);
                $('#D_Name').addClass('is-invalid');
                $('#D_Name').removeClass('is-valid');
                flag = false;
            } else {
                $('#D_Name').addClass('is-valid');
                $('#D_Name').removeClass('is-invalid');
            }
        }

        if (Description === "") {
            var html = "Bạn chưa nhập mô tả kìa!";
            $('#d_validation').html(html);
            $('#Description').addClass('is-invalid');
            flag = false;
        } else {
            $('#Description').addClass('is-valid');
            $('#Description').removeClass('is-invalid');
        }

        if (Location === "") {
            var html = "Bạn chưa nhập vị trí kìa!";
            $('#l_validation').html(html);
            $('#Location').addClass('is-invalid');
            flag = false;
        } else {
            if (!LocationRegex.test(Location)) {
                var html = "Không được nhập số hay kí tự đặc biệt!";
                $('#l_validation').html(html);
                $('#Location').addClass('is-invalid');
                flag = false;
            } else {
                $('#Location').addClass('is-valid');
                $('#Location').removeClass('is-invalid');
            }
        }


        if (image === "") {
            var html = "Bạn chưa thêm ảnh kìa!";
            $('#i_validation').html(html);
            $('#img').addClass('is-invalid');
            flag = false;
        } else {
            $('#img').addClass('is-valid');
            $('#img').removeClass('is-invalid');
        }

        if (Continent === "") {
            var html = "Bạn chưa chọn châu lục kìa!";
            $('#c_validation').html(html);
            $('#ContinentID').addClass('is-invalid');
            flag = false;
        } else {
            $('#ContinentID').addClass('is-valid');
            $('#ContinentID').removeClass('is-invalid');
        }

        if (flag) {
            $.ajax({
                url: "add/destination",
                type: "POST",
                processData: false,
                contentType: false,
                data: formData,
                success: function (response) {
                    if (response === "success") {
                        $("#replace").html('');
                        $("#bResult").html('<h6 class="text-success">Thêm địa điểm mới thành công</h6>');
                    } else {
                        console.log(response);
                        $("#bResult").html('<h6 class="text-danger">Ảnh vượt quá 10MB</h6>');
                        $("#replace").html('<button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#AddModel">Quay lại</button>');
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                    $("#replace").html('<button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#AddModel">Quay lại</button>');
                    $("#bResult").html('<h6 class="text-danger">Thêm địa điểm mới không thành công</h6>');
                }
            });
        }
    });

    $(".reload").click(function (e) {
        location.reload();
    });
});

function deleteUser(id) {
    if (id !== 1) {
        $.ajax({
            url: `/delete/user/${id}`,
            type: "DELETE",
            success: function (response) {
                console.log(response);
                location.reload();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    } else alert("Không xóa được Admin!");
}

function deleteDestination(DestinationID) {

    $.ajax({
        url: `dest/delete/${DestinationID}`,
        type: "DELETE",
        success: function (response) {
            console.log(response);
            location.reload();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(errorThrown);
        }
    });
}

function deleteBlog(BlogID) {
        $.ajax({
            url: `blog/delete/${BlogID}`,
            type: "DELETE",
            success: function (response) {
                console.log(response);
                location.reload();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
}