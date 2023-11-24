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
});