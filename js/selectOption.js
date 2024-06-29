$(document).ready(function () {
    $("#countrySelect").load("../selectOptions/_country.php");

});

loadState = (e) => {

    document.getElementById("stateSelect").disabled = false;
    $.ajax({
        url: "../selectOptions/_state.php",
        type: "GET",
        data: {
            country: e.value,
        },
        success: (response) => {
            // console.log(response)
            $("#stateSelect").html(response);
        },
    });
};
loadDistrict = (e) => {

    $.ajax({
        url: "../selectOptions/_district.php",
        type: "GET",
        data: {
            country: $("#countrySelect").val(),
            state: e.value,
        },
        success: (response) => {
            $("#districtSelect").html(response);
            // console.log(response);
        },
    });
};
loadTehsil = (e) => {

    $.ajax({
        url: "../selectOptions/_tehsilOption.php",
        type: "GET",
        data: {
            country: $("#countrySelect").val(),
            state: $("#stateSelect").val(),
            district: e.value,
        },
        success: (response) => {
            // console.log(response)
            $("#tehsil").html(response);
        },
    });
};

setTimeout(() => {
    var selectedCountry = document.getElementById("countrySelect");

    loadState(selectedCountry);
}, 700);