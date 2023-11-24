$(document).ready(function(){
    $('#changePass').submit(function(event){
        event.preventDefault();
        var opwd = $("#opwd").val().trim();
        var npwd = $("#npwd").val().trim();
        var rnpwd = $("#rnpwd").val().trim();

        var flag = true;

        if (opwd === "") {
            var html = "Bạn chưa nhập mật khẩu cũ kìa!";
            $('#old_validation').html(html);
            $('#opwd').addClass('is-invalid');
            flag = false;
        }else {
            $('#opwd').addClass('is-valid');
            $('#opwd').removeClass('is-invalid');
        }

        if (npwd === "") {
            var html = "Bạn chưa nhập mật khẩu mới kìa!";
            $('#new_validation').html(html);
            $('#npwd').addClass('is-invalid');
            flag = false;
        }else {
            $('#npwd').addClass('is-valid');
            $('#npwd').removeClass('is-invalid');
        }

        if (rnpwd === "") {
            var html = "Bạn chưa nhập lại mật khẩu mới kìa!";
            $('#rnew_validation').html(html);
            $('#rnpwd').addClass('is-invalid');
            flag = false;
        }else {
            if (npwd !== rnpwd) {
                var html = "Nhập mật khẩu không khớp kìa!";
                $('#rnew_validation').html(html);
                $('#rnpwd').addClass('is-invalid');
                flag = false;
            }else{
                $('#rnpwd').removeClass('is-invalid');
                $('#rnpwd').addClass('is-valid');
            }
        }

        

        if (flag) {
        $.ajax({
            url: "/user/changePwd",
            type: "POST",
            data: {
                oldPassword: $("#opwd").val(),
                newPassword: $("#npwd").val(),
            },
            success: function(response) {
                $("#cpResult").html(response);
                
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
         }else {
            $('#cpResult').html("<h6 class='text-danger'>Thay đổi không thành công</h6>");
         }
    });

   $('#changeInformation').submit(function(event){
        event.preventDefault();
        var email = $("#iEmail").val().trim();
        var fullname = $("#iFullName").val().trim();
        var address = $("#iAddress").val().trim();
        var phone = $("#iPhone").val().trim();

        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        var fullnameRegex = /^[a-zA-Z\sàáạảãâầấậẩẫăằắặẳẵèéẹẻẽêềếệểễìíịỉĩòóọỏõôồốộổỗơờớợởỡùúụủũưừứựửữỳýỵỷỹđĐ]+$/;

        var flag = true;

        if (email === "") {
            var html = "Bạn chưa nhập email kìa!";
            $('#e_validation').html(html);
            $('#iEmail').addClass('is-invalid');
            flag = false;
        }else{
            if (!emailRegex.test(email)) {
                var html = "Email phải có @!";
                $('#e_validation').html(html);
                $('#iEmail').addClass('is-invalid');
                flag = false;
            }else {
                $('#iEmail').addClass('is-valid');
                $('#iEmail').removeClass('is-invalid');
            }
        }
        
        if (fullname === "") {
            var html = "Bạn chưa nhập họ và tên kìa!";
            $('#n_validation').html(html);
            $('#iFullName').addClass('is-invalid');
            flag = false;
        } else{
        if (!fullnameRegex.test(fullname) || fullname.length > 26) {
            var html = "Không nhập số, kí tự đặc biệt!";
            $('#n_validation').html(html);
            $('#iFullName').addClass('is-invalid');
            flag = false;
        }else {
            $('#iFullName').addClass('is-valid');
            $('#iFullName').removeClass('is-invalid');
        }
        }
        
        if (address === "") {
            var html = "Bạn chưa nhập địa chỉ kìa!";
            $('#a_validation').html(html);
            $('#iAddress').addClass('is-invalid');
            flag = false;
        } else {
                $('#iAddress').addClass('is-valid');
                $('#iAddress').removeClass('is-invalid');
        }
        
        if (phone === "") {
            var html = "Bạn chưa nhập số điện thoại kìa!";
            $('#p_validation').html(html);
            $('#iPhone').addClass('is-invalid');
            flag = false;
        }else {
            if (phone.length != 10 ) {
                var html = "Điện thoại chỉ có 10 số!";
                $('#p_validation').html(html);
                $('#iPhone').addClass('is-invalid');
                flag = false;
            }else {
                $('#iPhone').addClass('is-valid');
                $('#iPhone').removeClass('is-invalid');
            }
        }
                   
        if (flag) {
            $.ajax({
                url: "/user/changeinfor",
                type: "POST",
                data: {
                    Email: $("#iEmail").val(),
                    Fullname: $("#iFullName").val(),
                    Address: $("#iAddress").val(),
                    Phone: $("#iPhone").val()
                },
                success: function(response) {
                    $("#ciResult").html(response);
                     
                },
                error: function(errorThrown) {
                    console.log(errorThrown);
                }
            });
        } else {
            $('#ciResult').html("<h6 class='text-danger'>Thay đổi không thành công</h6>");
        }

    });
});