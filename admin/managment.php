<?php
include '../components/connect.php';
session_start();

$admin_id = $_SESSION['admin_id'];
if (!isset($admin_id)) {
    header('location:admin_login.php');
}

$resultTable = ''; // Een variabele om de resultaten op te slaan

if (isset($_POST['submit'])) {
    $selected_start_date = $_POST['selected_start_date'];
    $selected_end_date = $_POST['selected_end_date'];
    $selected_postcode = $_POST['selected_postcode'];

    // Query voorbereiden en uitvoeren
    $query = $conn->prepare("
            SELECT 
    messages.name AS family_name,
    messages.postcode AS postcode,
    orders.total_products AS total_products,
    orders.placed_on AS order_date
FROM 
    orders
INNER JOIN 
    messages ON orders.postcode = messages.postcode
WHERE 
    orders.placed_on BETWEEN ? AND ?
    AND orders.postcode = ?
GROUP BY 
    messages.name, orders.postcode, orders.placed_on

    ");

    $query->execute([$selected_start_date, $selected_end_date, $selected_postcode]);

    // Resultaten opbouwen
    $resultTable .= "<table>";
    $resultTable .= "<tr><th>Familienaam</th><th>Totaal Producten</th><th>Postcode</th><th>Datum</th></tr>";
    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
        $resultTable .= "<tr>";
        $resultTable .= "<td>" . $row['family_name'] . "</td>";
        $resultTable .= "<td>" . $row['total_products'] . "</td>";
        $resultTable .= "<td>" . $row['postcode'] . "</td>";
        $resultTable .= "<td>" . $row['order_date'] . "</td>";
        $resultTable .= "</tr>";
    }
    $resultTable .= "</table>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Overzicht van bestellingen per postcode binnen een bepaalde tijd</title>
    <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">
   
   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/style.css">

    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            font-size: 20px;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
        
    </style>
</head>
<body>
    <?php include '../components/admin_header.php'; ?>
    <section class="form-container">
        <form action="" method="post">
            <h3>Maandoverzicht</h3>
            <label for="selected_start_date" style="font-size: 17px">Kies een startdatum:</label>
            <input type="date" id="selected_start_date" name="selected_start_date" class="box">

            <label for="selected_end_date" style="font-size: 17px">Kies een einddatum:</label>
            <input type="date" id="selected_end_date" name="selected_end_date" class="box">

            <label for="selected_postcode" style="font-size: 17px">Voer een postcode in:</label>
            <input type="text" id="selected_postcode" name="selected_postcode" class="box">
            
            <input type="submit" name="submit" value="Genereer overzicht" class="btn" name="submit">
        </form>


    </section>
</body>
<section class="form-container">
    <?php echo $resultTable; // De resultaten worden hier weergegeven ?>
    </section>
    <script src="../js/admin_script.js"></script>
</html>
