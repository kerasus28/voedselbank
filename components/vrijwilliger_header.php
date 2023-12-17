<?php
   if(isset($message)){
      foreach($message as $message){
         echo '
         <div class="message">
            <span>'.$message.'</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
         </div>
         ';
      }
   }
?>
<?php
$count_no_dates = $conn->prepare("SELECT COUNT(*) AS no_dates FROM `messages` m LEFT JOIN `orders` o ON m.name = o.name WHERE o.placed_on IS NULL");
$count_no_dates->execute();
$total_no_dates = $count_no_dates->fetch(PDO::FETCH_ASSOC)['no_dates'];

?>


<header class="header">

   <section class="flex">

      <a href="vrijwilliger_dashboard.php" class="logo">Maaskantje<span>.</span></a>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

<!-- custom css file link  -->
<link rel="stylesheet" href="../css/style.css">
<style>
.notification-count {
  display: inline-block;
  background-color: red;
  color: white;
  border-radius: 50%;
  padding: 4px 8px;
  font-size: 12px;
  margin-left: 4px; /* pas dit aan afhankelijk van de gewenste ruimte */
}
</style>


      <nav class="navbar">
         <a href="vrijwilliger_dashboard.php">Home</a>
         <!-- <a href="producten_vrijwilligers.php">Producten</a> -->
         <a href="overzichtvrij.php">Producten overzicht</a>
         <a href="messagess.php">Families</a>
         <a href="meldingen.php">Meldigen <span class="notification-count"><?= $total_no_dates; ?></span></a>
      </nav>

      <div class="icons">
         <?php
            $count_wishlist_items = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ?");
            $count_wishlist_items->execute([$vrijwilliger_id]);
            $total_wishlist_counts = $count_wishlist_items->rowCount();

            $count_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
            $count_cart_items->execute([$vrijwilliger_id]);
            $total_cart_counts = $count_cart_items->rowCount();
         ?>
         <div id="menu-btn" class="fas fa-bars"></div>
         <!-- <a href="../search_page.php"><i class="fas fa-search"></i></a> -->
         <!-- <a href="../wishlist.php"><i class="fas fa-heart"></i><span>(<?= $total_wishlist_counts; ?>)</span></a> -->
         <a href="../vrijwilligers/cart_vrij.php"><i class="fas fa-shopping-cart"></i><span>(<?= $total_cart_counts; ?>)</span></a>
         <div id="user-btn" class="fas fa-user"></div>
      </div>

      <div class="profile">
         <?php          
            $select_profile = $conn->prepare("SELECT * FROM `vrijwilligers` WHERE id = ?");
            $select_profile->execute([$vrijwilliger_id]);
            if($select_profile->rowCount() > 0){
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         <p><?= $fetch_profile["name"]; ?></p>
         <a href="update_vrijwilliger.php" class="btn">update profile</a>
         <a href="../components/vrijwilliger_logout.php" class="delete-btn" onclick="return confirm('logout from the website?');">Uitloggen</a> 
         <?php
            }else{
         ?>
      
         <?php
            }
         ?>      
         
         
      </div>

   </section>

</header>