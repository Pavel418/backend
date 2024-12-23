document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("driving-form");
    const errorMessages = document.querySelectorAll(".error-message");

    errorMessages.forEach(error => {
        error.style.display = "none";
    });

    form.addEventListener("submit", function (event) {
        let isValid = true;

        const dateInput = document.getElementById("date");
        const dateError = document.getElementById("date-error");
        if (!dateInput.value) {
            dateError.style.display = "block";
            isValid = false;
        } else {
            dateError.style.display = "none";
        }
        const startTimeInput = document.getElementById("start-time");
        const startTimeError = document.getElementById("start-time-error");
        if (!startTimeInput.value) {
            startTimeError.style.display = "block";
            isValid = false;
        } else {
            startTimeError.style.display = "none";
        }

        const endTimeInput = document.getElementById("end-time");
        const endTimeError = document.getElementById("end-time-error");
        if (!endTimeInput.value) {
            endTimeError.style.display = "block";
            isValid = false;
        } else {
            endTimeError.style.display = "none";
        }

        const kmInput = document.getElementById("km");
        const kmError = document.getElementById("km-error");
        if (!kmInput.value || kmInput.value <= 0) {
            kmError.style.display = "block";
            isValid = false;
        } else {
            kmError.style.display = "none";
        }

        const weatherConditionInput = document.getElementById("weather-condition");
        const weatherConditionError = document.getElementById("weather-condition-error");
        if (!weatherConditionInput.value) {
            weatherConditionError.style.display = "block";
            isValid = false;
        } else {
            weatherConditionError.style.display = "none";
        }

        const roadTypeInput = document.getElementById("road-type");
        const roadTypeError = document.getElementById("road-type-error");
        if (!roadTypeInput.value) {
            roadTypeError.style.display = "block";
            isValid = false;
        } else {
            roadTypeError.style.display = "none";
        }

        const trafficTypeInput = document.getElementById("traffic-type");
        const trafficTypeError = document.getElementById("traffic-type-error");
        if (!trafficTypeInput.value) {
            trafficTypeError.style.display = "block";
            isValid = false;
        } else {
            trafficTypeError.style.display = "none";
        }

        const navigationTypeInput = document.getElementById("navigation-type");
        const navigationTypeError = document.getElementById("navigation-type-error");
        if (!navigationTypeInput.value) {
            navigationTypeError.style.display = "block";
            isValid = false;
        } else {
            navigationTypeError.style.display = "none";
        }

        const maneuversInput = document.querySelectorAll("input[name='maneuvers[]']:checked");
        const maneuversError = document.getElementById("maneuvers-error");
        if (maneuversInput.length === 0) {
            maneuversError.style.display = "block";
            isValid = false;
        } else {
            maneuversError.style.display = "none";
        }

        if (!isValid) {
            event.preventDefault();
        }
    });
});
