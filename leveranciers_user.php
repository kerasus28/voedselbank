<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
  $user_id = $_SESSION['user_id'];
}else{
  $user_id = '';
};

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_user = $conn->prepare("DELETE FROM `leveranciers` WHERE id = ?");
   $delete_user->execute([$delete_id]);
   $delete_orders = $conn->prepare("DELETE FROM `leveranciers` WHERE bedrijfsnaam = ?");
   $delete_orders->execute([$delete_id]);
   $delete_messages = $conn->prepare("DELETE FROM `leveranciers` WHERE adres = ?");
   $delete_messages->execute([$delete_id]);
   $delete_cart = $conn->prepare("DELETE FROM `leveranciers` WHERE contactpersoon = ?");
   $delete_cart->execute([$delete_id]);
   $delete_wishlist = $conn->prepare("DELETE FROM `leveranciers` WHERE email = ?");
   $delete_wishlist->execute([$delete_id]);
   header('location:vrijwi_accounts.php');
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

   <link rel="stylesheet" href="css/admin_style.css">
   
   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include 'components/user_header.php'; ?>


<section class="accounts">

<h1 class="heading">leveranciers</h1>

<div class="box-container">

<div class="box">
   <p>Leverancier toevoegen</p>
   <a href="leverancier_register.php" class="option-btn">Toevoegen</a>
</div>

<?php
   $select_accounts = $conn->prepare("SELECT * FROM `leveranciers`");
   $select_accounts->execute();
   if($select_accounts->rowCount() > 0){
      while($fetch_accounts = $select_accounts->fetch(PDO::FETCH_ASSOC)){ 
      }}  
?>

   <div class="box-container">

   <?php
      $select_accounts = $conn->prepare("SELECT * FROM `leveranciers`");
      $select_accounts->execute();
      if($select_accounts->rowCount() > 0){
         while($fetch_accounts = $select_accounts->fetch(PDO::FETCH_ASSOC)){   
   ?>
   <div class="box">
      <p> Bedrijfsnaam : <span><?= $fetch_accounts['bedrijfsnaam']; ?></span> </p>
      <p> Contactpersoon : <span><?= $fetch_accounts['contactpersoon']; ?></span> </p>
      <p> Email : <span><?= $fetch_accounts['email']; ?></span> </p>
      <p> Product : <span><?= $fetch_accounts['product']; ?></span> </p>
      <p> Aantal : <span><?= $fetch_accounts['aantal']; ?></span> </p>
      <p> Leveringdatum : <span><?= $fetch_accounts['leveringdatum']; ?></span> </p>
      <div class="flex-btn">
      <a href="update_leverancier.php?update=<?= $fetch_accounts['id']; ?>" class="option-btn">update</a>
      <a href="leverancier_accounts_user.php?delete=<?= $fetch_accounts['id']; ?>" onclick="return confirm('delete this account? the user related information will also be delete!')" class="delete-btn">delete</a>
      </div>
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">no accounts available!</p>';
      }
   ?>

   </div>

</section>












<script src="js/admin_script.js"></script>
   
</body>
</html>