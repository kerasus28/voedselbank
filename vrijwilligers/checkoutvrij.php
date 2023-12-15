<?php

include '../components/connect.php';

session_start();

if(isset($_SESSION['vrijwilliger_id'])){
   $vrijwilliger_id = $_SESSION['vrijwilliger_id'];
}else{
   $vrijwilliger_id = '';
   header('location:../home.php');
};




if(isset($_POST['order'])){

   $name = $_POST['name'];
   $total_products = $_POST['total_products'];
  

   $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
   $check_cart->execute([$vrijwilliger_id]);

   if($check_cart->rowCount() > 0){

      $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, name,total_products) VALUES(?,?,?)");
      $insert_order->execute([$vrijwilliger_id, $name, $total_products]);

      $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
      $delete_cart->execute([$vrijwilliger_id]);

      $message[] = 'order placed successfully!';
   }else{
      $message[] = 'your cart is empty';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>checkout</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/style.css">

</head>
<body>
   
<?php include '../components/vrijwilliger_header.php'; ?>

<section class="checkout-orders">

   <form action="" method="POST">

   <h3>your orders</h3>

      <div class="display-orders">
      <?php
         $grand_total = 0;
         $cart_items[] = '';
         $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
         $select_cart->execute([$vrijwilliger_id]);
         if($select_cart->rowCount() > 0){
            while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
               $cart_items[] = $fetch_cart['name'].' ('.$fetch_cart['price'].' x '. $fetch_cart['quantity'].') - ';
               $total_products = implode($cart_items);
               $grand_total += ($fetch_cart['price'] * $fetch_cart['quantity']);
      ?>
         <p> <?= $fetch_cart['name']; ?> <span>(<?= '$'.$fetch_cart['price'].'/- x '. $fetch_cart['quantity']; ?>)</span> </p>
      <?php
            }
         }else{
            echo '<p class="empty">your cart is empty!</p>';
         }
      ?>
         <input type="hidden" name="total_products" value="<?= $total_products; ?>">
         <!-- <input type="hidden" name="total_price" value="<?= $grand_total; ?>" value="">
         <div class="grand-total">grand total : <span><?= $grand_total; ?></span></div> -->
      </div>

      <h3>place your orders</h3>

      <div class="flex">
    <div class="inputBox">
        <span>payment method :</span>
        <select name="name" class="box" required>
            <?php
                $select_names = $conn->prepare("SELECT name FROM `messages`");
                $select_names->execute();
                $results = $select_names->fetchAll(); // Haal alle rijen op

                foreach ($results as $result) {
                    $name = $result['name']; // De naam uit de database
                    echo "<option value='$name'>$name</option>"; // Optie toevoegen aan de dropdown
                }
            ?>
        </select>
    </div>
</div>


      </div>
         </div>

      <input type="submit" name="order" class="btn <?= ($grand_total > 1)?'':'disabled'; ?>" value="place order">

   </form>

</section>















<script src="../js/script.js"></script>

</body>
</html>