<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_user = $conn->prepare("DELETE FROM `messages` WHERE id = ?");
   $delete_user->execute([$delete_id]);
   $delete_orders = $conn->prepare("DELETE FROM `messages` WHERE user_id = ?");
   $delete_orders->execute([$delete_id]);
   $delete_messages = $conn->prepare("DELETE FROM `messages` WHERE name = ?");
   $delete_messages->execute([$delete_id]);
   $delete_cart = $conn->prepare("DELETE FROM `messages` WHERE email = ?");
   $delete_cart->execute([$delete_id]);
   $delete_wishlist = $conn->prepare("DELETE FROM `messages` WHERE number = ?");
   $delete_wishlist->execute([$delete_id]);
   $delete_wishlist = $conn->prepare("DELETE FROM `messages` WHERE message = ?");
   $delete_wishlist->execute([$delete_id]);
   $delete_wishlist = $conn->prepare("DELETE FROM `messages` WHERE volwassenen = ?");
   $delete_wishlist->execute([$delete_id]);
   $delete_wishlist = $conn->prepare("DELETE FROM `messages` WHERE kinderen = ?");
   $delete_wishlist->execute([$delete_id]);
   $delete_wishlist = $conn->prepare("DELETE FROM `messages` WHERE baby = ?");
   $delete_wishlist->execute([$delete_id]);
   $delete_wishlist = $conn->prepare("DELETE FROM `messages` WHERE alergieen1 = ?");
   $delete_wishlist->execute([$delete_id]);
   $delete_wishlist = $conn->prepare("DELETE FROM `messages` WHERE alergieen2 = ?");
   $delete_wishlist->execute([$delete_id]);
   $delete_wishlist = $conn->prepare("DELETE FROM `messages` WHERE adres = ?");
   $delete_wishlist->execute([$delete_id]);
   header('location:messages.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>users accounts</title>
   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">
   
   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/style.css">

   

</head>
<body>

<?php include '../components/admin_header.php'; ?>


<section class="accounts">

<h1 class="heading">Families</h1>



<div class="box-container">

<div class="box">
   <p>Familie toevoegen</p>
   <a href="families_register.php" class="option-btn">Toevoegen</a>
</div>

<?php
   $select_accounts = $conn->prepare("SELECT * FROM `messages`");
   $select_accounts->execute();
   if($select_accounts->rowCount() > 0){
      while($fetch_accounts = $select_accounts->fetch(PDO::FETCH_ASSOC)){ 
      }}  
?>

   <div class="box-container">

   <?php
      $select_accounts = $conn->prepare("SELECT * FROM `messages`");
      $select_accounts->execute();
      if($select_accounts->rowCount() > 0){
         while($fetch_accounts = $select_accounts->fetch(PDO::FETCH_ASSOC)){   
   ?>
   <div class="box">
      <p> Achternaam : <span><?= $fetch_accounts['name']; ?></span> </p>
      <p> Adres : <span><?= $fetch_accounts['adres']; ?></span> </p>
      <p> <span><?= $fetch_accounts['postcode']; ?></span> </p>
      <p> email : <span><?= $fetch_accounts['email']; ?></span> </p>
      <p> Telefoonnummer : <span><?= $fetch_accounts['number']; ?></span> </p>
      <p> <span><?= $fetch_accounts['volwassenen']; ?></span> </p>
      <p> <span><?= $fetch_accounts['kinderen']; ?></span> </p>
      <p> <span><?= $fetch_accounts['baby']; ?></span> </p>
      <p> Wens 1 : <span><?= $fetch_accounts['alergieen1']; ?></span> </p>
      <p> Wens 2 : <span><?= $fetch_accounts['alergieen2']; ?></span> </p>
      <p> Opmerkingen : <span><?= $fetch_accounts['message']; ?></span> </p>
      <a href="messages.php?delete=<?= $fetch_accounts['id']; ?>" onclick="return confirm('delete this account? the user related information will also be delete!')" class="delete-btn">delete</a>
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">no accounts available!</p>';
      }
   ?>

   </div>

</section>
<script src="../js/admin_script.js"></script>