<?php

// In diesem assoziativen Array werden alls Validierungsfehler aufgenommen
$errors = [];

/**
 * Bestätigt, ob ein Name eingegebene wurde und ob dieser
 * nicht länger ist als 25 Zeichen ist
 * @param $name
 * @return bool
 */
function validateName($name) {
    // Mit global erhält man Zugriff auf die globale Variable errors
    // sonst würde $errors als lokale Variable der Funktion gewertet
    global $errors;

    if (strlen($name) == 0) {
        $errors['name'] = "Der Name darf nicht leer sein";
        return false;
    } else if (strlen($name) > 25) {
        $errors['name'] = "Der Name ist zu lang";
        return false;
    } else {
        return true;
    }
}

/**
 * Bestätigt, ob ein Datum eingegeben wurde
 * und ob dieses Datum gültig, also nicht in der Zukunft liegt.
 * @param $measuringDate
 * @return bool
 */
function validateMeasuringDate($measuringDate) {
    // Mit global erhält man Zugriff auf die globale Variable errors
    // sonst würde $errors als lokale Variable der Funktion gewertet
    global $errors;

    try {
        if ($measuringDate == "") {
            $errors['measuringDate'] = "Das Messdatum darf nicht leer sein";
            return false;
        } else if (new DateTime($measuringDate) > new DateTime()) {
            $errors['measuringDate'] = "Das Messdatum darf nicht in der Zukunft liegen";
            return false;
        } else {
            return true;
        }
    } catch (Exception $e) {
        $errors['measuringDate'] = "Das Messdatum ist nicht gültig";
        return false;
    }
}

/**
 * Bestätigt, ob der übergebene Wert eine Zahl ist und
 * ob diese im Bereich 120-230 liegt
 * @param $height
 * @return bool
 */
function validateHeight($height) {
    // Mit global erhält man Zugriff auf die globale Variable errors
    // sonst würde $errors als lokale Variable der Funktion gewertet
    global $errors;

    // Prüft ob es eine Zahl ist und ob sie zwischen 120 bis 230 liegt
    if (!is_numeric($height) || $height < 120 || $height > 230) {
        $errors['height'] = "Die eingegebene Größe ist ungültig";
        return false;
    } else {
        return true;
    }
}

/**
 * Bestätigt, ob der übergebene Wert eine Zahl ist und
 * ob diese im Bereich 40-250 liegt
 * @param $weight
 * @return bool
 */
function validateWeight($weight) {
    // Mit global erhält man Zugriff auf die globale Variable errors
    // sonst würde $errors als lokale Variable der Funktion gewertet
    global $errors;

    // Prüft ob es eine Zahl ist und ob sie zwischen 40 bis 250 liegt
    if (!is_numeric($weight) || $weight < 40 || $weight > 250) {
        $errors['weight'] = "Das eingegebene Gewicht ist ungültig";
        return false;
    } else {
        return true;
    }
}

/**
 *
 * Bestätigt die Richtigkeit aller Eingabefehler oder gibt deren Fehler aus
 * @param $name
 * @param $measuringDate
 * @param $height
 * @param $weight
 * @return bool
 */
function validate($name, $measuringDate, $height, $weight) {

    return validateName($name)
        & validateMeasuringDate($measuringDate)
        & validateHeight($height)
        & validateWeight($weight);
}





