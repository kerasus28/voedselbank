<?php
include '../components/connect.php';
session_start();

$vrijwilliger_id = $_SESSION['vrijwilliger_id'];

if (!isset($vrijwilliger_id)) {
   header('location:vrijwilliger_login.php');
}

if (isset($_GET['delete'])) {
   // Verwijderingsquery's voor de specifieke ID hier
   // ...
   header('location:messages.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">
   
   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/style.css">
   <style>
   .box {
  border: 1px solid #ccc;
  border-radius: 5px;
  padding: 15px;
  margin-bottom: 20px;
  background-color: #f9f9f9;
  /* Voeg andere gewenste stijlen toe */
}

.box p {
  margin: 8px 0;
  font-size:14px;
}

.empty {
  /* Stijlen voor het geval er geen resultaten zijn */
}
</style>
</head>
<body>

<?php include '../components/vrijwilliger_header.php'; ?>

<section class="accounts">
   <h1 class="heading">Families zonder voedselpakketdatum</h1>
   
   <?php
   $select_accounts = $conn->prepare("SELECT m.*
   FROM `messages` m 
   LEFT JOIN `orders` o ON m.name = o.name
   WHERE o.placed_on IS NULL
   OR (o.placed_on < CURDATE())");
$select_accounts->execute();


   if ($select_accounts->rowCount() > 0) {
      while ($fetch_account = $select_accounts->fetch(PDO::FETCH_ASSOC)) {
         ?> <div class="box">
            <p> Achternaam : <span><?= $fetch_account['name']; ?></span> </p>
            <p> Adres : <span><?= $fetch_account['adres']; ?></span>  <span><?= $fetch_account['postcode']; ?></span></p>
            <p><strong>Waarschuwing:</strong> Geen datum voor een voedselpakket ingesteld voor deze familie.</p>
         </div>
         </div>
      <?php
      }
   } else {
      echo '<p class="empty">Geen families zonder voedselpakketdatum beschikbaar!</p>';
   }
   ?>
</section>
<script src="../js/admin_script.js"></script>
</body>
</html>
