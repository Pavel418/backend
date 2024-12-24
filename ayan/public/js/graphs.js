async function renderNavigationTypesChart() {
    try {
        const response = await fetch('/api/navigation');
        const data = await response.json();
        
        if (Array.isArray(data)) {
            const labels = data.map(item => `Navigation ${item.navigation_id}`);
            const counts = data.map(item => item.count);
            
            new Chart(document.getElementById('navigationChart'), {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Navigation Types Distribution',
                        data: counts,
                        backgroundColor: data.map(() => getRandomColor())
                    }]
                },
                options: {
                    responsive: false,  
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'top' },
                        tooltip: {
                            callbacks: {
                                label: (context) => {
                                    const value = context.raw;
                                    return `Count: ${value}`;
                                }
                            }
                        }
                    }
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
    const response = await fetch('/api/traffic');
    const data = await response.json();

    new Chart(document.getElementById('trafficChart'), {
        type: 'pie',
        data: {
            labels: data.map(item => `Traffic ${item.traffic_id}`),
            datasets: [{
                label: 'Traffic Conditions Distribution',
                data: data.map(item => item.count),
                backgroundColor: data.map(() => getRandomColor())
            }]
        },
        options: {
            responsive: false,  
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'top' },
                tooltip: {
                    callbacks: {
                        label: (context) => {
                            const value = context.raw;
                            return `Count: ${value}`;
                        }
                    }
                }
            }
        }
    });
}

async function renderRoadUsageChart() {
    const response = await fetch('/api/road');
    const data = await response.json();

    new Chart(document.getElementById('roadChart'), {
        type: 'pie',
        data: {
            labels: data.map(item => `Road ${item.road_id}`),
            datasets: [{
                label: 'Road Usage Distribution',
                data: data.map(item => item.count),
                backgroundColor: data.map(() => getRandomColor())
            }]
        },
        options: {
            responsive: false,  
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'top' },
                tooltip: {
                    callbacks: {
                        label: (context) => {
                            const value = context.raw;
                            return `Count: ${value}`;
                        }
                    }
                }
            }
        }
    });
}

async function renderDistanceChart() {
    const response = await fetch('/api/distance');
    const data = await response.json();

    const formattedData = data.map(item => ({
        x: `${item.year}-${String(item.month).padStart(2, '0')}`,
        y: Number(item.total_distance)
    }));

    new Chart(document.getElementById('distanceChart'), {
        type: 'line',
        data: {
            datasets: [{
                label: 'Cumulative Distance Over Time',
                data: formattedData,
                borderColor: getRandomColor(),
                backgroundColor: getRandomColor(),
                fill: false,
                tension: 0.1
            }]
        },
        options: {
            responsive: false,        
            maintainAspectRatio: false,
            plugins: { 
                legend: { position: 'top' }
            },
            scales: {
                x: {
                    type: 'time',
                    time: {
                        unit: 'month',
                        tooltipFormat: 'YYYY-MM'
                    },
                    title: {
                        display: true,
                        text: 'Date (Year-Month)'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Cumulative Distance'
                    },
                    beginAtZero: true
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
    renderRoadUsageChart();
    renderDistanceChart();
});
