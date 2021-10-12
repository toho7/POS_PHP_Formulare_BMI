<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <title>BMI-Rechner</title>

    <!-- Einbindung JS File -->
    <script type="text/javascript" src="js/index.js"></script>
    <script type="text/javascript" src="js/ampel.js"></script>
</head>
<body>
<div class="container">

    <!-- Überschrift -->
    <h1 class="mt-5 mb-3">Body-Mass-Index-Rechner</h1>

    <!-- PHP Code - Formularbearbeitung -->

    <?php

    // Einbinden von Skripten.
    // Dazu gibt es 2 Möglichkeiten. include und require.
    // include funktioniert auch wenn der Pfad der zum Skript fehlerhaft ist
    // bei require muss der Pfad stimmen, sonst wird abgebrochen.
    require "lib/func.inc.php";

    // Initialisierung der Variablen mit einem Leerzeichen, damit die Bedingung auch dann durchgeführt werden kann
    // wenn vom Anwender ein Feld nicht ausgefüllt wurde
    $name = '';
    $measuringDate = '';
    $height = '';
    $weight = '';
    $bmi = '';

    // Prüfen ob man POST hat vom submit button
    if (isset($_POST['submit'])) {
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $measuringDate = isset($_POST['measuringDate']) ? $_POST['measuringDate'] : '';
        $height = isset($_POST['height']) ? $_POST['height'] : '';
        $weight = isset($_POST['weight']) ? $_POST['weight'] : '';

        // Überprüfung der Funktion validate aus func.inc.php
        // Bestätigt die Ausgaben der HTML-Seite
        // Anschließend wird angezeigt ob die Daten korrekt sind oder nicht
        if (validate($name, $measuringDate, $height, $weight)) {
            // Berechnung des BMIs lokal für die Ausgabe auf der Seite
            $heightInM = $height / 100;
            $bmilocal = $weight / (pow($heightInM, 2));
            $bmiRounded = round($bmilocal, 2);
            
            // Ausgabe der jeweiligen Berechnung mit entsprechender Meldung
            if($bmilocal >= 30.0)
                {
                    echo "<p class='alert alert-danger'>Adipositas, Dein BMI ${bmiRounded}</p>";
                }
                elseif ($bmilocal >= 25)
                {
                    echo "<p class='alert alert-warning'>Übergewicht, Dein BMI ${bmiRounded}</p>";
                }
                elseif ($bmilocal >= 18.5)
                {
                    echo "<p class='alert alert-success'>Normalgewicht, Dein BMI ${bmiRounded}</p>";
                } else
                {
                    echo "<p class='alert alert-warning'>Untergewicht, Dein BMI ${bmiRounded}</p>";
                }
            
            // Wenn die Daten nicht korrekt sind
            } else {
                echo "<div class='alert alert-danger'><p>Die eingegeben Daten sind nicht korrekt</p><ul>";
                
                // Ausgabe der Fehlermeldungen
                foreach ($errors as $key => $value) {
                    echo "<li>" . $value . "</li>";
                }
                echo "</ul></div>";
            }
        }

    ?>

    <!-- Formular -->
    <form id="form_bmi" action="index.php" method="post">

        <!-- Reihencontainer für alles -->
        <div class="row">

            <!-- Reihencontainer für Eingaben Benutzer -->
            <div class="col-sm-8">

                <!-- Reihencontainer für Name und Messdatum -->
                <div class="row">

                    <!-- Erste Spalte für Name -->
                    <div class="col-sm-8 form-group">
                        <label for="name">Name*</label>
                        <input id="name"
                               type="text"
                               name="name"
                               class="form-control <?= isset($errors['name']) ? 'is-invalid' : '' ?>"
                               value="<?= htmlspecialchars($name) ?>"
                               maxlength="25"
                               required="required"/> <!-- Required bedeuted verpflichtend auszufüllen -->
                    </div>

                    <!-- Zweite Spalte für Messdatum -->
                    <div class="col-sm-4 form-group">
                        <label for="measuringDate">Messdatum*</label>
                        <input id="measuringDate"
                               type="date"
                               name="measuringDate"
                               class="form-control <?= isset($errors['measuringDate']) ? 'is-invalid' : '' ?>"
                               onchange="validateMeasuringDate(this)"
                               required="required"
                               value="<?= htmlspecialchars($measuringDate) ?>"
                        />
                    </div>
                </div>

                <!-- Reihencontainer für Größe und Gewicht -->
                <div class="row">

                    <!-- Erste Spalte für Größe -->
                    <div class="col-sm-6 form-group">
                        <label for="height">Größe (cm)*</label>
                        <input id="height"
                               type="number"
                               name="height"
                               class="form-control <?= isset($errors['height']) ? 'is-invalid' : '' ?>"
                               min="120"
                               max="230"
                               onchange="calculateBmi()"
                               required="required"
                               value="<?= htmlspecialchars($height) ?>"
                        />
                    </div>

                    <!-- Zweite Spalte für Gewicht -->
                    <div class="col-sm-6 form-group">
                        <label for="weight">Gewicht (kg)*</label>
                        <input id="weight"
                               type="number"
                               name="weight"
                               class="form-control <?= isset($errors['weight']) ? 'is-invalid' : '' ?>"
                               min="40"
                               max="250"
                               onchange="calculateBmi()"
                               required="required"
                               value="<?= htmlspecialchars($weight) ?>"
                        />
                    </div>
                </div>

                <!-- Reihencontainer für Speichern und Löschen -->
                <div class="row mt-3">

                    <!-- Erste Spalte für Berechnen -->
                    <div class="col-sm-3 mb-3">
                        <input type="submit"
                               name="submit"
                               class="btn btn-primary btn-block"
                               value="Berechnen"
                        >
                    </div>

                    <!-- Zweite Spalte für Löschen -->
                    <div class="col-sm-3">
                        <a href="index.php"
                           class="btn btn-secondary btn-block">Löschen
                        </a>
                    </div>
                </div>
            </div>

            <!-- Reihencontainer Ausgabe Info-BMI-Werte und Ampel -->
            <div class="col-sm-4">
                <img class="col-sm-12">
                    <label for="text">
                        <h2>Info zum BMI:</h2>
                        <p>Unter 18.5 Untergewicht</p>
                        <p>18.5 - 24.9 Normal</p>
                        <p>25.0 - 29.9 Übergewicht</p>
                        <p>30.0 und darüber Adipositas</p>
                    </label>
                <div id="ampel">
                    <script>
                        getAmpelImage(calculateBmi());
                    </script>
                </div>
            </div>
        </div>
    </form>

</body>
</html>

