<?php

include 'components/connect.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:producten_overzicht.php');
};

if(isset($_GET['delete'])){

   $delete_id = $_GET['delete'];
   $delete_product_image = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
   $delete_product_image->execute([$delete_id]);
   $fetch_delete_image = $delete_product_image->fetch(PDO::FETCH_ASSOC);
   unlink('../uploaded_img/'.$fetch_delete_image['image_01']);
   $delete_product = $conn->prepare("DELETE FROM `products` WHERE id = ?");
   $delete_product->execute([$delete_id]);
   $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE pid = ?");
   $delete_cart->execute([$delete_id]);
   $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE pid = ?");
   $delete_wishlist->execute([$delete_id]);
   header('location:producten_overzicht.php');
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
<section class="show-products">
   <h1 class="heading">Toegevoegde producten</h1>
   <input type="text" id="searchInput" placeholder="Zoek op naam of streepjescode..." >
   <div class="box-container" id="productContainer">
      <?php
      $select_products = $conn->prepare("SELECT * FROM `products`");
      $select_products->execute();
      if ($select_products->rowCount() > 0) {
         while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <div class="box">
               <img src="uploaded_img/<?= $fetch_products['image_01']; ?>" alt="">
               <div class="name"><?= $fetch_products['name']; ?></div>
               <div class="price"><span><?= $fetch_products['price']; ?></span></div>
               <div class="details"><span><?= $fetch_products['details']; ?></span></div>
               <div class="details"><span><?= $fetch_products['streepjescode']; ?></span></div>
               <div class="flex-btn">
                  <a href="update_product.php?update=<?= $fetch_products['id']; ?>" class="option-btn">update</a>
                  <a href="producten_overzicht.php?delete=<?= $fetch_products['id']; ?>" class="delete-btn" onclick="return confirm('delete this product?');">delete</a>
               </div>
            </div>
            <?php
         }
      } else {
         echo '<p class="empty">Geen producten beschikbaar!</p>';
      }
      ?>
   </div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
$(document).ready(function() {
   $('#searchInput').on('input', function() {
      const searchTerm = $(this).val().toLowerCase();

      $('.box').each(function() {
         const productName = $(this).find('.name').text().toLowerCase();
         const productDetails = $(this).find('.details').text().toLowerCase();
         
         if (productName.includes(searchTerm) || productDetails.includes(searchTerm)) {
            $(this).show();
         } else {
            $(this).hide();
         }
      });
   });
});
</script>
   
</body>
<style>
#searchInput {
   width: 20%;
   position: relative;
   padding: 8px;
   margin-bottom: 16px;
  
   border: 1px solid #ccc;
   border-radius: 4px;
   font-size: 14px;
}</style>
</html>






<script src="js/admin_script.js"></script>
   
</body>
</html>