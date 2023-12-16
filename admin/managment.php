<?php
include '../components/connect.php';

if (isset($_POST['submit'])) {
    $selected_date = $_POST['selected_date'];

    // Haal de maand en het jaar op uit de geselecteerde datum
    $timestamp = strtotime($selected_date);
    $month = date('m', $timestamp);
    $year = date('Y', $timestamp);

    // Query voorbereiden en uitvoeren
    $query = $conn->prepare("
        SELECT 
            postcode,
            COUNT(user_id) AS total_products
        FROM 
            orders
        WHERE 
            MONTH(placed_on) = ? AND YEAR(placed_on) = ?
        GROUP BY 
            postcode
    ");

    $query->execute([$month, $year]);

    // Resultaten weergeven
    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
        echo "Postcode: " . $row['postcode'] . " - Aantal bestellingen: " . $row['total_products'] . "<br>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Maandoverzicht per postcode</title>
</head>
<body>
    <form action="" method="post">
        <label for="selected_date">Kies een datum:</label>
        <input type="date" id="selected_date" name="selected_date">
        <input type="submit" name="submit" value="Genereer overzicht">
    </form>
</body>
</html>
