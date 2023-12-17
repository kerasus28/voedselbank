<?php

include '../components/connect.php';

session_start();

if(isset($_SESSION['admin_id'])){
   $admin_id = $_SESSION['admin_id'];
}else{
   $admin_id = '';
};

if(isset($_POST['submit'])){

   $name = $_POST['bedrijfsnaam'];
   $adres = $_POST['adres'];
   $persoon = $_POST['contactpersoon'];
   $email = $_POST['email'];
   $tel = $_POST['telefoonnummer'];
   $product = $_POST['product'];
   $aantal = $_POST['aantal'];   
   $leveringdatum = $_POST['leveringdatum'];
   
  

   $select_user = $conn->prepare("SELECT * FROM `leveranciers` WHERE email = ?");
   $select_user->execute([$email,]);
   $row = $select_user->fetch(PDO::FETCH_ASSOC);

   if($select_user->rowCount() > 0){
      $message[] = 'email already exists!';
      }else{
         $insert_user = $conn->prepare("INSERT INTO `leveranciers`(bedrijfsnaam, adres, contactpersoon,email, telefoonnummer, product, aantal, leveringdatum) VALUES(?,?,?,?,?,?,?,?)");
         $insert_user->execute([$name, $adres, $persoon,$email,$tel,$product,$aantal,$leveringdatum]);
         $message[] = 'registered successfully, login now please!';
         header("Location: leverancier_accounts.php");
      }
   }



?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/style.css">

</head>
<body>
   
<?php include '../components/admin_header.php'; ?>

<section class="form-container">

   <form action="" method="post">
      <h3>Leverancier toevoegen</h3>
      <input type="text" name="bedrijfsnaam" required placeholder="bedrijfsnaam" maxlength="100"  class="box">
      <input type="text" name="adres" required placeholder="adres"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="text" name="contactpersoon" required placeholder="contactpersoon" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="email" name="email" required placeholder="email"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="text" name="telefoonnummer" required placeholder="telefoonnummer" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="text" name="product" required placeholder="product"   class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="number" name="aantal" required placeholder="aantal"   class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="date" name="leveringdatum" required placeholder="leveringdatum"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="register now" class="btn" name="submit">
   </form>

</section>













<?php include '../components/footer.php'; ?>

<script src="../js/script.js"></script>

</body>
</html>