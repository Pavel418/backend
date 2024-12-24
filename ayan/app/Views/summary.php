<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Summary</title>
    <link rel="stylesheet" type="text/css" href="/css/summary.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-chart-matrix"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns"></script>
</head>
<body>
    <header class="header">
        <h1>Driving Experience</h1>
    </header>
    <main>
        <p>Total distance covered: <span id="total-distance"><?= htmlspecialchars($totalDistance) ?> km</span></p>
        <div id="summary">
            <div id="experience-table-wrapper">
                <table id="experience-table" class="display">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Weather</th>
                            <th>Road Type</th>
                            <th>Road Condition</th>
                            <th>Navigation Type</th>
                            <th>Maneuvers</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody id="data-container">
                        <?php foreach ($experiences as $experience): ?>
                            <tr data-id="<?= htmlspecialchars($experience['temp']) ?>">
                                <td><?= htmlspecialchars($experience['date'] . ' ' . $experience['depart_time'] . ' - ' . $experience['arrival_time']) ?></td>
                                <td><?= htmlspecialchars(getOptionName($weatherOptions, $experience, 'weather_id')) ?></td>
                                <td><?= htmlspecialchars(getOptionName($roadTypeOptions, $experience, 'road_id')) ?></td>
                                <td><?= htmlspecialchars(getOptionName($trafficOptions, $experience, 'traffic_id')) ?></td>
                                <td><?= htmlspecialchars(getOptionName($navigationTypeOptions, $experience, 'navigation_id')) ?></td>
                                <td><?= htmlspecialchars(getOptionName($maneuvers, $experience, 'maneuver_id')) ?></td>
                                <td>
                                    <button class="edit-btn" data-id="<?= htmlspecialchars($experience['temp']) ?>">Edit</button>
                                </td>
                                <td>
                                    <button class="delete-btn" data-id="<?= htmlspecialchars($experience['temp']) ?>">Delete</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="charts-container">
                <canvas class="chart" id="distanceChart"></canvas>
                <div class="three-charts">
                    <canvas class="chart" id="navigationChart"></canvas>
                    <canvas class="chart" id="trafficChart"></canvas>
                    <canvas class="chart" id="roadChart"></canvas>
                </div>
            </div>
            
            <button id="empty" onclick="window.location='/experience/random';">Add Random Data</button>

            <button id="empty" onclick="window.location='/summary/reset';">Empty The Storage</button>
        </div>
        <a class="back-button" href="/">Back</a>
    </main>
    <footer class="footer">
        <p>&copy; 2024 Skibidi Ayan</p>
    </footer>
</body>
</html>

<script src="/js/charts.js"></script>
<script src="/js/summary.js"></script>

<script>
    $(document).ready(function () {
        $('#experience-table').DataTable();
    });
</script>

<?php
function getOptionName($options, $experience, $key) {
    $names = [];
    $experienceValues = is_array($experience[$key]) ? $experience[$key] : [$experience[$key]];

    foreach ($experienceValues as $experienceValue) {
        $originalValue = isset($_SESSION["{$key}s"][$experienceValue]) ? $_SESSION["{$key}s"][$experienceValue] : $experienceValue;

        foreach ($options as $option) {
            if ($option[$key] == $originalValue) {
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