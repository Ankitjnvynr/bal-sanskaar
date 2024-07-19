$(document).ready(function () {
    $("#countrySelect").load("../selectOptions/_country.php");

    // Attach event listeners to the selects
    $("#countrySelect").change(function () {
        loadState(this);
    });

    $("#stateSelect").change(function () {
        loadDistrict(this);
    });

    $("#districtSelect").change(function () {
        loadTehsil(this);
    });
});

const loadState = async (e) => {
    try {
        const response = await $.ajax({
            url: "../selectOptions/_state.php",
            type: "GET",
            data: { country: e.value },
        });
        $("#stateSelect").html(response);
    } catch (error) {
        console.error("Error loading states:", error);
    }
};

const loadDistrict = async (e) => {
    try {
        const response = await $.ajax({
            url: "../selectOptions/_district.php",
            type: "GET",
            data: {
                country: $("#countrySelect").val(),
                state: e.value,
            },
        });
        $("#districtSelect").html(response);
    } catch (error) {
        console.error("Error loading districts:", error);
    }
};

const loadTehsil = async (e) => {
    try {
        const response = await $.ajax({
            url: "../selectOptions/_tehsilOption.php",
            type: "GET",
            data: {
                country: $("#countrySelect").val(),
                state: $("#stateSelect").val(),
                district: e.value,
            },
        });
        $("#tehsil").html(response);
    } catch (error) {
        console.error("Error loading tehsils:", error);
    }
};

const selectOptionByValue = async (selectId, value) => {
    return new Promise((resolve, reject) => {
        const selectElement = document.getElementById(selectId);
        if (selectElement) {
            for (let i = 0; i < selectElement.options.length; i++) {
                if (selectElement.options[i].value === value) {
                    selectElement.selectedIndex = i;
                    resolve();
                    return;
                }
            }
            reject(`Value ${value} not found in ${selectId}`);
        } else {
            reject(`Element with id ${selectId} not found`);
        }
    });
};

const initializeForm = async () => {
    const selectedCountry = document.getElementById("countrySelect");
    await loadState(selectedCountry);

    if (updating) {
        try {
            await selectOptionByValue('stateSelect', currentState);
            await loadDistrict(document.getElementById("stateSelect"));
            await selectOptionByValue('districtSelect', currentDistrict);
            await loadTehsil(document.getElementById("districtSelect"));
            await selectOptionByValue('tehsil', currentTehsil);
        } catch (error) {
            console.error("Error initializing form:", error);
        }
    }
};

setTimeout(initializeForm, 100);
