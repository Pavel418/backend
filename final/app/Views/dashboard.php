<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Summary</title>
    <link rel="stylesheet" type="text/css" href="/css/styles.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/chartjs-chart-matrix"></script>
</head>
<body>
    <header class="header">
        <h1>Driving Experience</h1>
    </header>
    <p>Total distance covered: <span id="total-distance"><?= htmlspecialchars($totalDistance) ?> km</span></p>
    <div id="summary">
        <table id="experience-table" class="display">
            <thead>
                <tr>
                    <th>Weather</th>
                    <th>Road Type</th>
                    <th>Road Condition</th>
                    <th>Navigation Type</th>
                    <th>Maneuvers</th>
                </tr>
            </thead>
            <tbody id="data-container">
                <?php foreach ($experiences as $experience): ?>
                    <tr>
                        <td><?= htmlspecialchars(getOptionName($weatherOptions, $experience, 'weather_id')) ?></td>
                        <td><?= htmlspecialchars(getOptionName($roadTypeOptions, $experience, 'road_id')) ?></td>
                        <td><?= htmlspecialchars(getOptionName($trafficOptions, $experience, 'traffic_id')) ?></td>
                        <td><?= htmlspecialchars(getOptionName($navigationTypeOptions, $experience, 'navigation_id')) ?></td>
                        <td><?= htmlspecialchars(getOptionName($maneuvers, $experience, 'maneuver_id')) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <canvas id="navigationChart" width="400" height="200"></canvas>
        <canvas id="trafficChart" width="400" height="200"></canvas>
        <canvas id="weatherChart" width="400" height="200"></canvas>
        <canvas id="roadChart" width="400" height="200"></canvas>
        <canvas id="distanceChart" width="400" height="200"></canvas>
        <canvas id="heatmapChart" width="400" height="200"></canvas>

        <button id="empty" onclick="window.location='/dashboard/reset';">Empty the storage</button>
    </div>
    <a class="back-button" href="/">Back</a>
</body>
</html>

<script src="/js/graphs.js"></script>

<?php
function getOptionName($options, $experience, $key) {
    $names = [];
    $experienceValues = is_array($experience[$key]) ? $experience[$key] : [$experience[$key]];

    foreach ($experienceValues as $experienceValue) {
        foreach ($options as $option) {
            if ($option[$key] == $experienceValue) {
                $name = explode('_', $key)[0];
                if (is_array($option[$name])) {
                    $names[] = implode(', ', $option[$name]);
                } else {
                    $names[] = $option[$name];
                }
                break;
            }
        }
    }

    return !empty($names) ? implode(', ', $names) : 'Unknown';
}
?>