<?php

include '../components/connect.php';

session_start();

if(isset($_SESSION['vrijwilliger_id'])){
   $vrijwilliger_id = $_SESSION['vrijwilliger_id'];
}else{
   $vrijwilliger_id = '';
   header('location:../home.php');
};

if(isset($_POST['delete'])){
   $cart_id = $_POST['cart_id'];
   $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE id = ?");
   $delete_cart_item->execute([$cart_id]);
}

if(isset($_GET['delete_all'])){
   $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
   $delete_cart_item->execute([$vrijwilliger_id]);
   header('location:cart_vrij.php');
}

if(isset($_POST['update_qty'])){
   $cart_id = $_POST['cart_id'];
   $qty = $_POST['qty'];
   $update_qty = $conn->prepare("UPDATE `cart` SET quantity = ? WHERE id = ?");
   $update_qty->execute([$qty, $cart_id]);
   $message[] = 'cart quantity updated';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>shopping cart</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/style.css">

</head>
<body>
   
<?php include '../components/vrijwilliger_header.php'; ?>

<section class="products shopping-cart">

   <h3 class="heading">Winkelmand</h3>

   <div class="box-container">

   <?php
      $grand_total = 0;
      $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
      $select_cart->execute([$vrijwilliger_id]);
      if($select_cart->rowCount() > 0){
         while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
   ?>
   <form action="" method="post" class="box">
      <input type="hidden" name="cart_id" value="<?= $fetch_cart['id']; ?>">
      <img src="../uploaded_img/<?= $fetch_cart['image']; ?>" alt="">
      <div class="name"><?= $fetch_cart['details']; ?></div>
      <div class="flex">
         <div class="price"><?= $fetch_cart['price']; ?></div>
         <input type="number" name="qty" class="qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="<?= $fetch_cart['quantity']; ?>">
         <button type="submit" class="fas fa-edit" name="update_qty"></button>
      </div>
      <!-- <div class="sub-total"> sub total : <span><?= $sub_total = ($fetch_cart['price'] * $fetch_cart['quantity']); ?>/-</span> </div> -->
      <input type="submit" value="delete item" onclick="return confirm('delete this from cart?');" class="delete-btn" name="delete">
   </form>
   <?php
   // $grand_total= $fetch_cart['quantity'];
      }
   }else{
      echo '<p class="empty">your cart is empty</p>';
   }
   ?>
   </div>

   <div class="cart-total">
      <!-- <p>Totaal producten : <span><?= $grand_total; ?></span></p> -->
      <a href="cart_vrij.php?delete_all" class="delete-btn " onclick="return confirm('delete all from cart?');">Verwijder alles uit je winkelmand</a>
      <a href="checkoutvrij.php" class="btn">verder met je bestelling</a>
   </div>

</section>













<?php include '../components/footer.php'; ?>

<script src="../js/script.js"></script>

</body>
</html>