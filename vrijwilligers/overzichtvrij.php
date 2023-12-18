<?php
include '../components/connect.php';

session_start();

$vrijwilliger_id = $_SESSION['vrijwilliger_id'];

if(!isset($vrijwilliger_id)){
   header('location:vrijwilliger_login.php');
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
<?php include '../components/vrijwilliger_header.php'; ?>
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
               <img src="../uploaded_img/<?= $fetch_products['image_01']; ?>" alt="">
               <div class="name"><?= $fetch_products['name']; ?></div>
               <div class="price"><span><?= $fetch_products['price']; ?></span></div>
               <div class="details"><span><?= $fetch_products['details']; ?></span></div>
               <div class="details"><span><?= $fetch_products['streepjescode']; ?></span></div>
               <div class="flex-btn">
                  <a href="update_productt.php?update=<?= $fetch_products['id']; ?>" class="option-btn">update</a>
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
<script src="../js/admin_script.js"></script>