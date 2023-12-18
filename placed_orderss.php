<?php

include 'components/connect.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:home.php');
}

if(isset($_POST['update_payment'])){
   $order_id = $_POST['order_id'];
   $payment_status = $_POST['payment_status'];
   $update_payment = $conn->prepare("UPDATE `orders` SET payment_status = ? WHERE id = ?");
   $update_payment->execute([$payment_status, $order_id]);
   $message[] = 'payment status updated!';
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_order = $conn->prepare("DELETE FROM `orders` WHERE id = ?");
   $delete_order->execute([$delete_id]);
   header('location:placed_orders.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Magazijnverwerking van Bestellingen</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>

<?php include 'components/user_header.php'; ?>

<section class="orders">

<h1 class="heading">Magazijnverwerking van Bestellingen</h1>
<div class="box-container">
   <?php
      $select_orders = $conn->prepare("SELECT * FROM `orders`");
      $select_orders->execute();
      if($select_orders->rowCount() > 0){
         while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
   ?>
   <div class="box">
      <p> geplaatst op : <span><?= $fetch_orders['placed_on']; ?></span> </p>
      <p> naam : <span><?= $fetch_orders['name']; ?></span> </p>
      <p> postcode : <span><?= $fetch_orders['postcode']; ?></span> </p>
      <p> totaal producten : <span><?= $fetch_orders['total_products']; ?></span> </p>
      <form action="" method="post">
        <input type="hidden" name="order_id" value="<?= $fetch_orders['id']; ?>">
        <button class="process-btn" type="button" name="update_payment" value="processed">
            Bestelling verwerkt in het magazijn
        </button>
        <button class="delete-btn" type="submit" name="delete_order" value="<?= $fetch_orders['id']; ?>" style="display: none;">
            Verwijderen
        </button>
    </form>
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">no orders placed yet!</p>';
      }
   ?>

</div>

</section>
</section>
<script src="js/admin_script.js"></script>
<style>
/* Stijl voor de knop "Bestelling verwerkt in het magazijn" */
.process-btn {
    background-color: green;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
}

/* Stijl voor de knop "Verwijderen" */
.delete-btn {
    background-color: red;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
}
</style><style>
/* Stijl voor de knop "Bestelling verwerkt in het magazijn" */
.process-btn {
    background-color: green;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
}

/* Stijl voor de knop "Verwijderen" */
.permanent-btn {
    background-color: red;
    color: white;
    padding: 15px 25px; /* Pas de padding aan voor de grootte */
    border: none;
    border-radius: 5px;
    font-size: 18px; /* Pas de lettergrootte aan */
    cursor: pointer;
}
</style>
<script>
const boxes = document.querySelectorAll('.box');

boxes.forEach(box => {
    const processBtn = box.querySelector('.process-btn');
    const deleteBtn = box.querySelector('.delete-btn');
    const orderId = box.querySelector('input[name="order_id"]').value;

    processBtn.addEventListener('click', function (event) {
        event.preventDefault(); 
        this.style.backgroundColor = 'green';
        this.style.fontSize = '20px'; 
        this.style.padding = '15px 25px'; 


       
        
        const permanentDeleteBtn = document.createElement('button');
permanentDeleteBtn.innerText = 'Bestelling verwerkt';
permanentDeleteBtn.classList.add('permanent-btn'); // Voeg een klasse toe voor stijl

// Voeg deze knop toe aan de box
box.appendChild(permanentDeleteBtn);

       
        processBtn.style.display = 'none';
        deleteBtn.style.display = 'none';

        
        permanentDeleteBtn.addEventListener('click', function() {
            const confirmed = confirm('Weet je zeker dat je deze bestelling permanent wilt verwijderen?');
            if (confirmed) {
                box.style.display = 'none'; 
                const deletedOrders = JSON.parse(localStorage.getItem('deletedOrders')) || [];
                deletedOrders.push(orderId);
                localStorage.setItem('deletedOrders', JSON.stringify(deletedOrders));
            }
        });
    });

    // Laat verwijderde bestellingen niet opnieuw verschijnen bij het herladen van de pagina
    const deletedOrders = JSON.parse(localStorage.getItem('deletedOrders')) || [];
    if (deletedOrders.includes(orderId)) {
      box.style.display = 'none';
    }
});
</script>
</body>
</html>