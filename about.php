<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_POST['send'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $msg = $_POST['msg'];
   $msg = filter_var($msg, FILTER_SANITIZE_STRING);
   $volwassenen = $_POST['volwassenen'];
   $volwassenen = filter_var($volwassenen, FILTER_SANITIZE_STRING);
   $kinderen = $_POST['kinderen'];
   $kinderen = filter_var($kinderen, FILTER_SANITIZE_STRING);
   $baby = $_POST['baby'];
   $baby = filter_var($baby, FILTER_SANITIZE_STRING);
   $alergieen1 = $_POST['alergieen1'];
   $alergieen1 = filter_var($alergieen1, FILTER_SANITIZE_STRING);
   $alergieen2 = $_POST['alergieen2'];
   $alergieen2 = filter_var($alergieen2, FILTER_SANITIZE_STRING);
   

   $select_message = $conn->prepare("SELECT * FROM `messages` WHERE name = ? AND email = ? AND number = ? AND message = ? AND volwassenen = ? AND kinderen = ? AND baby = ? AND alergieen1 = ? AND alergieen2 = ?");
   $select_message->execute([$name, $email, $number, $msg, $volwassenen, $kinderen, $baby, $alergieen1, $alergieen2]);

   if($select_message->rowCount() > 0){
      $message[] = 'already sent message!';
   }else{

      $insert_message = $conn->prepare("INSERT INTO `messages`(user_id, name, email, number, message, volwassenen, kinderen, baby, alergieen1, alergieen2) VALUES(?,?,?,?,?,?,?,?,?,?)");
      $insert_message->execute([$user_id, $name, $email, $number, $msg, $volwassenen, $kinderen, $baby, $alergieen1, $alergieen2]);

      $message[] = 'sent message successfully!';

   }

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>contact</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="contact">

   <form action="" method="post">
      <h3>Familie registratie</h3>
      <h1>Gegevens</h1>
      <input type="text" name="name" placeholder="Naam" required maxlength="20" class="box">
      <input type="email" name="email" placeholder="Email" required maxlength="50" class="box">
      <input type="number" name="number" min="0" max="9999999999" placeholder="Telefoonnummer" required onkeypress="if(this.value.length == 10) return false;" class="box">
      <h1>Aantallen</h1>
      <select class="box" name="volwassenen" id="volwassenen"> 
<option class="box" value="volwassenen 1x">Volwassenen 1x</option> 
<option class="box" value="volwassenen 2x">Volwassenen 2x</option> 
<option class="box" value="volwassenen 3x">Volwassenen 3x</option> 
<option class="box" value="volwassenen 4x">Volwassenen 4x</option> 
<option class="box" value="volwassenen 5x">Volwassenen 5x</option> 
<option class="box" value="volwassenen 6x">Volwassenen 6x</option> 
</select> 
        <select class="box" name="kinderen" id="kinderen"> 
        <option class="box" value="-">-</option> 
        <option class="box" value="kinderen 1x">Kinderen 1x</option> 
        <option class="box" value="kinderen 2x">Kinderen 2x</option> 
        <option class="box" value="kinderen 3x">Kinderen 3x</option> 
        </select> 
<select class="box" name="baby" id="baby"> 
<option class="box" value="-">-</option> 
<option class="box" value="baby 1x">Baby 1x</option> 
<option class="box" value="baby 2x">Baby 2x</option> 
</select>
      <h1>Toevoegingen</h1>
      <select class="box" name="alergieen1" id="alergieen1"> 
      <option class="box" value="-">-</option>
      <option class="box" value="gluten">Gluten</option>
      <option class="box" value="lactose">Lactose</option>
      <option class="box" value="noten">Noten</option>
      <option class="box" value="veganistisch">Veganistisch</option> 
      <option class="box" value="vegetarisch">Vegetarisch</option> 
      <option class="box" value="noten">Noten</option>
      <option class="box" value="noten">Halal</option> 
      </select>
<select class="box" name="alergieen2" id="alergieen2"> 
<option class="box" value="-">-</option>
      <option class="box" value="gluten">Gluten</option>
      <option class="box" value="lactose">Lactose</option>
      <option class="box" value="noten">Noten</option>
      <option class="box" value="veganistisch">Veganistisch</option> 
      <option class="box" value="vegetarisch">Vegetarisch</option> 
      <option class="box" value="noten">Noten</option>
      <option class="box" value="noten">Halal</option> 
</select>
      <textarea name="msg" class="box" placeholder="Bericht" cols="30" rows="10"></textarea>
      <input type="submit" value="Familie toevoegen" name="send" class="btn">
      </form>

</section>













<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>