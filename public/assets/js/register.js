function password_show_hide(id, showEyeId, hideEyeId) {
    var x = document.getElementById(id);
    var show_eye = document.getElementById(showEyeId);
    var hide_eye = document.getElementById(hideEyeId);
    hide_eye.classList.remove("d-none");
    if (x.type === "password") {
        x.type = "text";
        show_eye.style.display = "none";
        hide_eye.style.display = "block";
    } else {
        x.type = "password";
        show_eye.style.display = "block";
        hide_eye.style.display = "none";
    }
}
$(function () {
    $("input, select").on("focus", function () {
        $(this)
            .parent()
            .find(".input-group-text")
            .css("border-color", "#80bdff");
    });
    $("input, select").on("blur", function () {
        $(this)
            .parent()
            .find(".input-group-text")
            .css("border-color", "#ced4da");
    });
});

document.getElementById("district").addEventListener("change", function () {
    var selectedDistrictId = this.value;
    var villageSelect = document.getElementById("village");
    villageSelect.removeAttribute("style");
    villageSelect.removeAttribute("disabled");
    for (var i = 0; i < villageSelect.options.length; i++) {
        var option = villageSelect.options[i];
        if (
            option.value !== "" &&
            option.getAttribute("data-district") !== selectedDistrictId
        ) {
            option.style.display = "none";
        } else {
            option.style.display = "";
        }
    }
    var defaultVillageId = villageSelect.querySelector(
        'option[data-district="' + selectedDistrictId + '"]'
    ).value;
    villageSelect.value = defaultVillageId;
});
document.getElementById("village").addEventListener("change", function () {
    var selectedVillageId = this.value;
    var lenderSelect = document.getElementById("lender");
    lenderSelect.removeAttribute("style");
    lenderSelect.removeAttribute("disabled");
    for (var i = 0; i < lenderSelect.options.length; i++) {
        var option = lenderSelect.options[i];
        if (
            option.value !== "" &&
            option.getAttribute("data-village") !== selectedVillageId
        ) {
            option.style.display = "none";
        } else {
            option.style.display = "";
        }
    }
    var defaultLenderId = lenderSelect.querySelector(
        'option[data-village="' + selectedVillageId + '"]'
    ).value;
    lenderSelect.value = defaultLenderId;
});
