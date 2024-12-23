window.onload = function () {
    document.getElementById("empty").addEventListener("click", function () {
        localStorage.clear();
        window.location.reload();
    });

    const optionsJSON = '{"weatherOptions":[{"id":"1","name":"Rainy"},{"id":"2","name":"Sunny"},{"id":"3","name":"Foggy"},{"id":"4","name":"Snow"},{"id":"5","name":"Wind"}],"roadTypeOptions":[{"id":"1","name":"City"},{"id":"2","name":"Mountain"},{"id":"3","name":"Countryside"}],"roadConditionOptions":[{"id":"1","name":"Smooth"},{"id":"2","name":"Gravel"},{"id":"3","name":"Icy"},{"id":"4","name":"Muddy"}],"navigationTypeOptions":[{"id":"1","name":"GPS"},{"id":"2","name":"Map"},{"id":"3","name":"No Navigation"}]}';
    const options = JSON.parse(optionsJSON);

    const {
        weatherOptions,
        roadTypeOptions,
        roadConditionOptions,
        navigationTypeOptions
    } = options;

    const experiences = JSON.parse(localStorage.getItem("experiencesList")) || [];
    console.log(experiences);

    const dataContainer = document.getElementById("data-container");

    for (const experience of experiences) {
        const row = document.createElement("tr");

        const weatherText = weatherOptions.find(option => option.id === experience.idWeather).name;

        const weatherDataCell = document.getElementById("weather-data").cloneNode(true);
        weatherDataCell.innerHTML = weatherText;
        row.appendChild(weatherDataCell);

        const roadTypeText = roadTypeOptions.find(option => option.id === experience.idRoadType).name;
        const roadConditionText = roadConditionOptions.find(option => option.id === experience.idRoadCondition).name;
        const navigationTypeText = navigationTypeOptions.find(option => option.id === experience.idNavigationType).name;

        const roadTypeDataCell = document.getElementById("road-type-data").cloneNode(true);
        roadTypeDataCell.innerHTML = roadTypeText;
        row.appendChild(roadTypeDataCell);

        const roadConditionDataCell = document.getElementById("road-condition-data").cloneNode(true);
        roadConditionDataCell.innerHTML = roadConditionText;
        row.appendChild(roadConditionDataCell);

        const navigationTypeDataCell = document.getElementById("navigation-type-data").cloneNode(true);
        navigationTypeDataCell.innerHTML = navigationTypeText;
        row.appendChild(navigationTypeDataCell);

        dataContainer.appendChild(row);
    }

    totalDistance = document.getElementById("total-distance");
    const calculateTotalKms = list => {
        return list.reduce((total, item) => total + parseFloat(item.distance), 0);
    };
    totalDistance.innerHTML = calculateTotalKms(experiences) + " km";
};
