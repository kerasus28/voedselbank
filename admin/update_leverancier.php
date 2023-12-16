<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:home.php');
}

if(isset($_POST['update'])){

   $pid = $_POST['id'];
   $leveringdatum = $_POST['leveringdatum'];
   $name=$_POST['name'];
  

   $update_info = $conn->prepare("UPDATE `leveranciers` SET leveringdatum = ?,bedrijfsnaam = ? WHERE id= ?");
   $update_info->execute([$leveringdatum,$name,$pid]);

   $message[] = 'Leveringdatum aangepast!';



}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Update leveranciers</title>

   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">
   
   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/style.css">

</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="update-product">

   <h1 class="heading">Update leverancier</h1>

   <?php
      $update_id = $_GET['update'];
      $select_products = $conn->prepare("SELECT * FROM `leveranciers` WHERE id = ?");
      $select_products->execute([$update_id]);
      if($select_products->rowCount() > 0){
         while($fetch_info = $select_products->fetch(PDO::FETCH_ASSOC)){ 
   ?>
   <form action="" method="post" enctype="multipart/form-data">
      <span>Update leveringdatum</span>
      <input type="hidden" name="id" value="<?= $fetch_info['id']; ?>">
      <input type="text" name="name" required class="box" maxlength="100"  value="<?= $fetch_info['bedrijfsnaam']; ?>">
      <input type="date" name="leveringdatum" required class="box" maxlength="100" placeholder="" value="<?= $fetch_info['leveringdatum']; ?>">
      <div class="flex-btn">
         <input type="submit" name="update" class="btn" value="update">
         <a href="producten_overzicht.php" class="option-btn">go back</a>
      </div>
   </form>
   
   <?php
         }
      }else{
         echo '<p class="empty">no product found!</p>';
      }
   ?>

</section>












<script src="../js/admin_script.js"></script>
   
</body>
</html>