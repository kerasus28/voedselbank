<?php

if(isset($_POST['add_to_wishlist'])){

   if($vrijwilliger_id  == ''){
      header('location:../home.php');
   }else{

      $pid = $_POST['pid'];
      $name = $_POST['name'];
      $details = $_POST['details'];
      $price = $_POST['price'];
      $image = $_POST['image'];
   

      $check_wishlist_numbers = $conn->prepare("SELECT * FROM `wishlist` WHERE name = ? AND user_id = ?");
      $check_wishlist_numbers->execute([$name, $vrijwilliger_id]);

      $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
      $check_cart_numbers->execute([$name, $vrijwilliger_id]);

      if($check_wishlist_numbers->rowCount() > 0){
         $message[] = 'already added to wishlist!';
      }elseif($check_cart_numbers->rowCount() > 0){
         $message[] = 'already added to cart!';
      }else{
         $insert_wishlist = $conn->prepare("INSERT INTO `wishlist`(user_id, pid, name, price, image) VALUES(?,?,?,?,?)");
         $insert_wishlist->execute([$vrijwilliger_id, $pid, $name,$details, $price, $image]);
         $message[] = 'added to wishlist!';
      }

   }

}

if(isset($_POST['add_tocart'])){

   if($vrijwilliger_id == ''){
      header('location:home.php');
   }else{

      $pid = $_POST['pid'];
      $name = $_POST['name'];
      $details = $_POST['details'];
      $price = $_POST['price'];
      $image = $_POST['image'];
      $qty = $_POST['qty'];


      $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
      $check_cart_numbers->execute([$name, $vrijwilliger_id]);

      // if($check_cart_numbers->rowCount() ){
      //    $message[] = 'already added to cart!';
      // }else{

         $check_wishlist_numbers = $conn->prepare("SELECT * FROM `wishlist` WHERE name = ? AND user_id = ?");
         $check_wishlist_numbers->execute([$name, $vrijwilliger_id]);

         if($check_wishlist_numbers->rowCount() > 0){
            $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE name = ? AND user_id = ?");
            $delete_wishlist->execute([$name, $vrijwilliger_id]);
         }

         $insert_cart = $conn->prepare("INSERT INTO `cart`(user_id, pid, name, details, price, quantity, image) VALUES(?,?,?,?,?,?,?)");
         $insert_cart->execute([$vrijwilliger_id, $pid, $name,$details, $price, $qty, $image]);
         $message[] = 'added to cart!';
         
   // }
   }
   }



?>