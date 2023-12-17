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
   $placed_on = $_POST['date'];
   $postcode=$_POST['postcode'];
  

   $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
   $check_cart->execute([$vrijwilliger_id]);

   if($check_cart->rowCount() > 0){

      $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, name,total_products,placed_on,postcode) VALUES(?,?,?,?,?)");
      $insert_order->execute([$vrijwilliger_id, $name, $total_products,$placed_on,$postcode]);

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
  <style>
.inputBox{
   font-size: 20px;
}
.flex{
   font-size: 20px;
}
</style>
</head>
<body>
   
<?php include '../components/vrijwilliger_header.php'; ?>

<section class="checkout-orders">

   <form action="" method="POST" class="form-container">

   <h3>Producten</h3>

      <div class="display-orders">
      <?php
         $grand_total = 0;
         $cart_items[] = '';
         $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
         $select_cart->execute([$vrijwilliger_id]);
         if($select_cart->rowCount() > 0){
            while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
               $cart_items[] = $fetch_cart['details'].' ( x '. $fetch_cart['quantity'].') - ';
               $total_products = implode($cart_items);
               $grand_total += ( $fetch_cart['quantity']);
      ?>
         <p> <?= $fetch_cart['details']; ?> <span>(<?= $fetch_cart['quantity']; ?>)</span> </p>
      <?php
            }
         }else{
            echo '<p class="empty">your cart is empty!</p>';
         }
      ?>
         <input type="hidden" name="total_products" value="<?= $total_products; ?>">
      </div>

      <h3>Voeg voedselpakket aan een familie</h3>

<div class="flex">
      <select name="name" class="box" id="familyName" required>
    <!-- Optionele standaardoptie -->
    <option class="box"value="">Selecteer een familie</option>
    <?php
    $select_names = $conn->prepare("SELECT name FROM `messages`");
    $select_names->execute();
    $results = $select_names->fetchAll();

    foreach ($results as $result) {
        $name = $result['name'];
        echo "<option value='$name'>$name</option>";
    }
    ?>
</select>
</div>
<!-- Voeg een script toe om de waarde van $name bij te werken -->
<script>
    const select = document.getElementById('familyName');
    select.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const selectedName = selectedOption.value;

        // Verstuur geselecteerde naam naar de server voor het bijwerken van de postcode
        fetch('get_postcode.php', {
            method: 'POST',
            body: JSON.stringify({ name: selectedName }),
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            // Bijgewerkte postcode in de inputvelden invoegen
            document.querySelector('.box[name="postcode"]').value = data.postcode;
            document.querySelector('input[readonly]').value = data.postcode;
        })
        .catch(error => console.error('Error:', error));
    });
</script>
      </div>
<div class="inputBox"><br>
        <span>Postcode:</span>
        <br>
      <?php
      $select_postcode = $conn->prepare("SELECT postcode FROM messages WHERE name = ?");
      $select_postcode->execute([$name]);
      // Nu kun je de postcode ophalen als die beschikbaar is
      $postcode = $select_postcode->fetchColumn();
      ?>
    <input type="hidden" class="box" name="postcode" value="<?= $postcode ?>"> 
    <input type="text" class="box" value="<?= $postcode ?>" readonly>
</div>

<div class="inputBox"><br>
        <span>Datum:</span>
        <br>
        <input type="date" name="date" class="box">
        </div>
</div>

<input type="submit" name="order" class="btn <?= ($grand_total > 1)?'':'disabled'; ?>" value="place order">


</section>
</form>














<script src="../js/script.js"></script>

</body>
</html>