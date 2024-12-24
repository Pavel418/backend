<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driving Experience</title>
    <link rel="stylesheet" type="text/css" href="/css/entry.css">
</head>

<body>
    <header class="header">
        <h1>Edit</h1>
    </header>

    <main class="main">
        <form class="form-container" action="/experience/edit" method="POST" id="driving-form">
            <label class="form-label" for="date">Date:</label>
            <input type="date" id="date" name="date" class="form-input" value="<?= isset($date) ? $date : '' ?>" required>
            <div class="error-message" id="date-error">Please select a valid date.</div><br>

            <label class="form-label" for="start-time">Start Time:</label>
            <input type="time" id="start-time" name="start-time" class="form-input" value="<?= isset($depart_time) ? $depart_time : '' ?>" required placeholder="HH:MM">
            <div class="error-message" id="start-time-error">Please enter a valid start time.</div><br>

            <label class="form-label" for="end-time">End Time:</label>
            <input type="time" id="end-time" name="end-time" class="form-input" value="<?= isset($arrival_time) ? $arrival_time : '' ?>" required placeholder="HH:MM">
            <div class="error-message" id="end-time-error">Please enter a valid end time.</div><br>

            <label class="form-label" for="km">Km:</label>
            <input type="number" id="km" name="km" class="form-input" value="<?= isset($distance) ? $distance : '' ?>" required min="1" placeholder="Enter kilometers">
            <div class="error-message" id="km-error">Please enter a valid number for kilometers.</div><br>

            <label class="form-label" for="weather-condition">Weather Condition:</label>
            <select name="weather-condition" id="weather-condition" class="form-select" required>
                <?php foreach ($weatherOptions as $weather) { ?>
                    <option value="<?= $weather['weather_id'] ?>" <?= (isset($weather_id) && $weather_id == $weather['weather_id']) ? 'selected' : '' ?>>
                        <?= $weather['weather'] ?>
                    </option>
                <?php } ?>
            </select>
            <div class="error-message" id="weather-condition-error">Please select a weather condition.</div><br>

            <label class="form-label" for="road-type">Road Type:</label>
            <select name="road-type" id="road-type" class="form-select" required>
                <?php foreach ($roadOptions as $roadType) { ?>
                    <option value="<?= $roadType['road_id'] ?>" <?= isset($road_id) && $road_id == $roadType['road_id'] ? 'selected' : '' ?>>
                        <?= $roadType['road'] ?>
                    </option>
                <?php } ?>
            </select>
            <div class="error-message" id="road-type-error">Please select a road type.</div><br>

            <label class="form-label" for="traffic-type">Traffic Type:</label>
            <select name="traffic-type" id="traffic-type" class="form-select" required>
                <?php foreach ($trafficOptions as $trafficOption) { ?>
                    <option value="<?= $trafficOption['traffic_id'] ?>" <?= isset($traffic_id) && $traffic_id == $trafficOption['traffic_id'] ? 'selected' : '' ?>>
                        <?= $trafficOption['traffic'] ?>
                    </option>
                <?php } ?>
            </select>
            <div class="error-message" id="traffic-type-error">Please select a traffic type.</div><br>

            <label class="form-label" for="navigation-type">Navigation Type:</label>
            <select name="navigation-type" id="navigation-type" class="form-select" required>
                <?php foreach ($navigationOptions as $navigationOption) { ?>
                    <option value="<?= $navigationOption['navigation_id'] ?>" <?= isset($navigation_id) && $navigation_id == $navigationOption['navigation_id'] ? 'selected' : '' ?>>
                        <?= $navigationOption['navigation'] ?>
                    </option>
                <?php } ?>
            </select>
            <div class="error-message" id="navigation-type-error">Please select a navigation type.</div><br>

            <label class="form-label" for="maneuver-group">Maneuvers:</label>
            <div id="maneuver-group">
                <?php foreach ($maneuverOptions as $index => $maneuver) { ?>
                    <?php $inputId = "maneuver_" . $index; ?>
                    <input type="checkbox" name="maneuvers[]" value="<?= $maneuver['maneuver_id'] ?>" id="<?= $inputId ?>" class="form-checkbox"
                    <?= isset($associatedManeuvers) && in_array($maneuver['maneuver_id'], $associatedManeuvers) ? 'checked' : '' ?>>
                    <label for="<?= $inputId ?>"><?= $maneuver['maneuver'] ?></label>
                <?php } ?>
            </div>
            <div class="error-message" id="maneuvers-error">Please select at least one maneuver.</div><br>
            <input type="hidden" name="id" value="<?= $id ?>">

            <input type="submit" class="form-submit" value="Update">
            <a href="/">Home</a>
        </form>
    </main>

    <footer class="footer">
        <p>&copy; 2024 Skibidi Ayan</p>
    </footer>

    <script src="/js/entry.js"></script>
    <script src="/js/edit.js"></script>
</body>
</html>
