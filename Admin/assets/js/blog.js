$(document).ready(function () {
    $('#EditBlog').submit(function (event) {
        event.preventDefault();
        var formData = new FormData(this);
        var image = $("#img").val().trim();

        var flag = true;

        if (image === "") {
            var html = "Bạn chưa thêm ảnh kìa!";
            $('#i_validation').html(html);
            $('#img').addClass('is-invalid');
            flag = false;
        } else {
            $('#img').addClass('is-valid');
            $('#img').removeClass('is-invalid');
        }

        if (flag) {
            $.ajax({
                url: "/edit/blog",
                type: "POST",
                processData: false,
                contentType: false,
                data: formData,
                success: function (response) {
                    if (response === "success") {
                        $("#replace").html('');
                        $("#EditResult").html('<h6 class="text-success">Thêm Blog mới thành công</h6>');
                    } else {
                        console.log(response);
                        $("#EditResult").html('<h6 class="text-danger">Ảnh vượt quá 10MB</h6>');
                        $("#replace").html('<button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#EditModel">Quay lại</button>');
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                    $("#replace").html('<button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#EditModel">Quay lại</button>');
                    $("#EditResult").html('<h6 class="text-danger">Thêm địa điểm mới không thành công</h6>');
                }
            });
        }
    });

    $(".reload").click(function (e) {
        location.reload();
    });

    $('#searchButton').on('click', function () {
        var searchQuery = $('#searchInput').val();
        if (searchQuery) {
            $.ajax({
                url: '/blog/searchTitle/' + searchQuery,
                type: 'GET',
                data: { search: searchQuery },
                dataType: 'json',
                success: function (data) {
                    displaySearchResults(data);
                },
                error: function (error) {
                    console.log('Error:', error);
                }
            });
        } else {
            alert("Hãy nhập từ khóa vào");
        }
    });

    function timeAgo(createdAt) {
        var now = new Date();
        var createdTime = new Date(createdAt);
        var diff = now - createdTime;

        var seconds = Math.floor(diff / 1000);
        var minutes = Math.floor(seconds / 60);
        var hours = Math.floor(minutes / 60);
        var days = Math.floor(hours / 24);
        var months = Math.floor(days / 30);
        var years = Math.floor(months / 12);

        var timeAgoString = '';

        if (years > 0) {
            timeAgoString += years + ' năm trước';
        } else if (months > 0) {
            timeAgoString += months + ' tháng trước';
        } else if (days > 0) {
            timeAgoString += days + ' ngày trước';
        } else if (hours > 0) {
            timeAgoString += hours + ' giờ trước';
        } else if (minutes > 0) {
            timeAgoString += minutes + ' phút trước';
        } else {
            timeAgoString += 'Vừa xong';
        }

        return timeAgoString;
    }

    function displaySearchResults(data) {
        var searchResultSection = $('#search-result');
        var blogContainer = $('#search-results-container');
        blogContainer.empty();

        if (data.length > 0) {
            searchResultSection.find('.title').text('Kết quả tìm kiếm');

            data.forEach(function (blog) {
                var blogHTML = '<a href="/blogDetails/' + blog.BlogID + '" class="col-3">' +
                    '<div class="blog__box">' +
                    '<div class="blog__imgbox">' +
                    '<img src="/assets/img/Blog_' + blog.BlogID + '.jpg" alt="" class="blog__img" />' +
                    '</div>' +
                    '<div class="blog__textbox">' +
                    '<h5 class="blog__title">' + blog.Title + '</h5>' +
                    '<p class="blog__desc limited-text ">' + blog.Content + '</p>' +
                    '<h6 class="blog__author">Tác giả</h6>' +
                    '<h6 class="blog__time">' + timeAgo(blog.CreatedAt) + '</h6>' +
                    '</div>' +
                    '</div>' +
                    '</a>';
                blogContainer.append(blogHTML);
            });
            searchResultSection.show();
        } else {
            searchResultSection.find('.title').text('Không tìm thấy kết quả');
            searchResultSection.show();
        }
    }
});


function deleteBlog(BlogID) {
    $.ajax({
        url: `/blog/delete/${BlogID}`,
        type: "DELETE",
        success: function (response) {
            console.log(response);
            window.location.href = '/blogs';
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(errorThrown);
        }
    });
}