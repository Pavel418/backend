async function renderNavigationTypesChart() {
    try {
        const response = await fetch('/api/navigation/monthly');
        const data = await response.json();
        
        if (Array.isArray(data)) {
            const months = data.map(item => `Month ${item.month}`);
            const counts = data.map(item => item.count);
            
            new Chart(document.getElementById('navigationChart'), {
                type: 'line',
                data: {
                    labels: months,
                    datasets: [{
                        label: 'Navigation Count',
                        data: counts,
                        borderColor: getRandomColor(),
                        fill: false
                    }]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { position: 'top' } },
                    scales: { x: { title: { display: true, text: 'Months' } } }
                }
            });
        } else {
            console.error('Data is not an array:', data);
        }
    } catch (error) {
        console.error('Error fetching data:', error);
    }
}


async function renderTrafficConditionsChart() {
    const response = await fetch('/api/traffic/monthly');
    const data = await response.json();
    
    new Chart(document.getElementById('trafficChart'), {
        type: 'bar',
        data: {
            labels: data.map(item => `Month ${item.month}`),
            datasets: [{
                label: 'Traffic Conditions',
                data: data.map(item => item.count),
                backgroundColor: getRandomColor()
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'top' } },
            scales: { x: { stacked: true }, y: { stacked: true } }
        }
    });
}

async function renderWeatherDistributionChart() {
    const response = await fetch('/api/weather/distribution');
    const data = await response.json();
    
    new Chart(document.getElementById('weatherChart'), {
        type: 'pie',
        data: {
            labels: data.map(item => item.weather),
            datasets: [{
                data: data.map(item => item.count),
                backgroundColor: data.map(() => getRandomColor())
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'top' } }
        }
    });
}

async function renderRoadUsageChart() {
    const response = await fetch('/api/road/monthly');
    const data = await response.json();
    
    new Chart(document.getElementById('roadChart'), {
        type: 'bar',
        data: {
            labels: data.map(item => `Month ${item.month}`),
            datasets: [{
                label: 'Road Usage',
                data: data.map(item => item.count),
                backgroundColor: getRandomColor()
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'top' } },
            scales: { x: { title: { display: true, text: 'Months' } } }
        }
    });
}

async function renderTripDistanceChart() {
    const response = await fetch('/api/trips/distances');
    const data = await response.json();
    
    new Chart(document.getElementById('distanceChart'), {
        type: 'scatter',
        data: {
            datasets: [{
                label: 'Trip Distances',
                data: data.map(item => ({ x: item.date, y: item.distance })),
                backgroundColor: getRandomColor()
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'top' } },
            scales: {
                x: { title: { display: true, text: 'Dates' } },
                y: { title: { display: true, text: 'Distance' } }
            }
        }
    });
}

async function renderHeatmapChart() {
    const response = await fetch('/api/categories/heatmap');
    const data = await response.json();

    const matrix = data.matrix;
    const trafficConditions = data.trafficConditions;
    const weatherConditions = data.weatherConditions;

    if (!matrix || !trafficConditions || !weatherConditions) {
        console.error('Missing data for matrix, trafficConditions, or weatherConditions');
        return;
    }

    const heatmapData = [];
    
    for (const trafficKey in matrix) {
        for (const weatherKey in matrix[trafficKey]) {
            const trafficIndex = parseInt(trafficKey) - 1;
            const weatherIndex = parseInt(weatherKey) - 1;
            
            if (trafficConditions[trafficIndex] && weatherConditions[weatherIndex]) {
                heatmapData.push({
                    x: trafficIndex,  
                    y: weatherIndex,   
                    value: matrix[trafficKey][weatherKey]
                });
            }
        }
    }

    new Chart(document.getElementById('heatmapChart'), {
        type: 'matrix',
        data: {
            datasets: [{
                label: 'Category Relationships',
                data: heatmapData,
                backgroundColor: (ctx) => getRandomColor(ctx.raw.value),
                width: ({ chart }) => (chart.chartArea || {}).width / trafficConditions.length,
                height: ({ chart }) => (chart.chartArea || {}).height / weatherConditions.length
            }]
        },
        options: {
            plugins: { legend: { position: 'top' } },
            scales: {
                x: {
                    title: { display: true, text: 'Traffic Conditions' },
                    ticks: { callback: (value) => trafficConditions[value] ? trafficConditions[value].traffic : '' }
                },
                y: {
                    title: { display: true, text: 'Weather Conditions' },
                    ticks: { callback: (value) => weatherConditions[value] ? weatherConditions[value].weather : '' }
                }
            }
        }
    });
}

function getRandomColor(alpha = 1) {
    return `rgba(${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, ${alpha})`;
}

document.addEventListener('DOMContentLoaded', () => {
    renderNavigationTypesChart();
    renderTrafficConditionsChart();
    renderWeatherDistributionChart();
    renderRoadUsageChart();
    renderTripDistanceChart();
    renderHeatmapChart();
});
