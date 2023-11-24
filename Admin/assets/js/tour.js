function addFavorite(UserID, DestinationID) {
    $.ajax({
        url: `/add/favorite/${UserID}/${DestinationID}`,
        type: "POST",
        data: { UserID, DestinationID },
        success: (response) => console.log(response),
        error: (jqXHR, textStatus, errorThrown) => console.log(errorThrown)
    });
}

function deleteFavorite(UserID, DestinationID) {
    $.ajax({
        url: `/delete/favorite/${UserID}/${DestinationID}`,
        type: "POST",
        data: { UserID, DestinationID },
        success: (response) => console.log(response),
        error: (jqXHR, textStatus, errorThrown) => console.log(errorThrown)
    });
}

$(document).ready(function () {
    $(".reload").click(function (e) {
        location.reload();
    });

    $('#searchButton').on('click', function () {
        var searchQuery = $('#searchInput').val();
        if (searchQuery) {
            $.ajax({
                url: '/tour/searchName/' + searchQuery,
                type: 'GET',
                data: { search: searchQuery },
                dataType: 'json',
                success: function (data) {
                    console.log(data);
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

    function displaySearchResults(data) {
        var searchResultSection = $('#search-result');
        var carouselContainer = $('#SearchCarousel .carousel-inner');
        var indicatorsContainer = $('#SearchCarousel .carousel-indicators');
        carouselContainer.empty();
        indicatorsContainer.empty();

        if (data.length > 0) {
            searchResultSection.find('.title').text('Kết quả tìm kiếm');
            var currentRow = '<div class="carousel-item active"><div class="row p-0">';
            data.forEach(function (destination, index) {
                // Add indicators dynamically
                indicatorsContainer.empty();

                // Calculate the number of slides
                var numberOfSlides = Math.ceil(data.length / 3);

                for (var i = 0; i < numberOfSlides; i++) {
                    indicatorsContainer.append(
                        '<button type="button" data-bs-target="#SearchCarousel" data-bs-slide-to="' + i + '" ' +
                        (i === 0 ? 'class="active" aria-current="true"' : '') +
                        ' aria-label="Slide ' + (i + 1) + '"></button>'
                    );
                }

                var destinationHTML =
                    '<div class="col-4 pe-3">' +
                    '<div class="image" style="background-image: url(/assets/img/Dest_' + destination.DestinationID + '.jpg); background-size: cover;">' +
                    '<div class="image__overlay">' +
                    '<h2 class="image__overlay__title">' + destination.Name + '</h2>' +
                    '<p class="image__overlay__text">' + destination.Description + '</p>' +
                    '<a type="button" href="/tourDetails/' + destination.DestinationID + '" class="btn btn-dark">Xem thêm</a>' +
                    '</div>' +
                    '</div>' +
                    '</div>';

                currentRow += destinationHTML;
                if ((index + 1) % 3 === 0) {
                    carouselContainer.append(currentRow + '</div></div>');
                    currentRow = '<div class="carousel-item"><div class="row p-0">';
                }
            });

            if (currentRow !== '<div class="carousel-item"><div class="row p-0">') {
                carouselContainer.append(currentRow + '</div></div>');
            }
            searchResultSection.show();
        } else {
            searchResultSection.find('.title').text('Không tìm thấy kết quả');
            searchResultSection.show();
        }
    }

});
