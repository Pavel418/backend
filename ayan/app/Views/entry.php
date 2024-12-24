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
        <h1>Driving Experience</h1>
    </header>

    <main class="main">
        <?php
        if (isset($_SESSION['message'])) {
            echo "<p class='message'>" . $_SESSION['message'] . "</p>";
            unset($_SESSION['message']);
        }
        ?>

        <form class="form-container" action="/entry" method="POST" id="driving-form">
            <label class="form-label" for="date">Date:</label>
            <input type="date" id="date" name="date" class="form-input" required>
            <div class="error-message" id="date-error">Please select a valid date.</div><br>

            <label class="form-label" for="start-time">Start Time:</label>
            <input type="time" id="start-time" name="start-time" class="form-input" required placeholder="HH:MM">
            <div class="error-message" id="start-time-error">Please enter a valid start time.</div><br>

            <label class="form-label" for="end-time">End Time:</label>
            <input type="time" id="end-time" name="end-time" class="form-input" required placeholder="HH:MM">
            <div class="error-message" id="end-time-error">Please enter a valid end time.</div><br>

            <label class="form-label" for="km">Km:</label>
            <input type="number" id="km" name="km" class="form-input" required min="1" placeholder="Enter kilometers">
            <div class="error-message" id="km-error">Please enter a valid number for kilometers.</div><br>

            <label class="form-label" for="weather-condition">Weather Condition:</label>
            <select name="weather-condition" id="weather-condition" class="form-select" required>
                <?php foreach ($weatherOptions as $weather) { ?>
                    <option value="<?= $weather['weather_id'] ?>"><?= $weather['weather'] ?></option>
                <?php } ?>
            </select>
            <div class="error-message" id="weather-condition-error">Please select a weather condition.</div><br>

            <label class="form-label" for="road-type">Road Type:</label>
            <select name="road-type" id="road-type" class="form-select" required>
                <?php foreach ($roadOptions as $roadType) { ?>
                    <option value="<?= $roadType['road_id'] ?>"><?= $roadType['road'] ?></option>
                <?php } ?>
            </select>
            <div class="error-message" id="road-type-error">Please select a road type.</div><br>

            <label class="form-label" for="traffic-type">Traffic Type:</label>
            <select name="traffic-type" id="traffic-type" class="form-select" required>
                <?php foreach ($trafficOptions as $trafficOption) { ?>
                    <option value="<?= $trafficOption['traffic_id'] ?>"><?= $trafficOption['traffic'] ?></option>
                <?php } ?>
            </select>
            <div class="error-message" id="traffic-type-error">Please select a traffic type.</div><br>

            <label class="form-label" for="navigation-type">Navigation Type:</label>
            <select name="navigation-type" id="navigation-type" class="form-select" required>
                <?php foreach ($navigationOptions as $navigationOption) { ?>
                    <option value="<?= $navigationOption['navigation_id'] ?>"><?= $navigationOption['navigation'] ?></option>
                <?php } ?>
            </select>
            <div class="error-message" id="navigation-type-error">Please select a navigation type.</div><br>

            <legend class="form-label">Maneuvers:</legend>
            <div id="maneuver-group">
                <?php foreach ($maneuverOptions as $index => $maneuver) { ?>
                    <?php $inputId = "maneuver_" . $index; ?>
                    <input type="checkbox" name="maneuvers[]" value="<?= $maneuver['maneuver_id'] ?>" id="<?= $inputId ?>" class="form-checkbox">
                    <label for="<?= $inputId ?>"><?= $maneuver['maneuver'] ?></label>
                <?php } ?>
            </div>
            <div class="error-message" id="maneuvers-error">Please select at least one maneuver.</div><br>


            <input type="submit" class="form-submit" value="Submit">
            <a href="/summary">Summary</a>
            <a href="/">Back</a>
        </form>

        <h2 id="total-km">Total kms: <span id="total-distance"><?= htmlspecialchars($totalKms) ?> km</span></h2>
    </main>

    <footer class="footer">
        <p>&copy; 2024 Skibidi Ayan</p>
    </footer>

    <script src="/js/form.js"></script>
</body>
</html>
