<?php

include '../components/connect.php';

session_start();

if(isset($_POST['submit'])){

   $name = $_POST['email'];
   $pass = sha1($_POST['password']);

   $select_vrijwilliger = $conn->prepare("SELECT * FROM `vrijwilligers` WHERE email = ? AND password = ?");
   $select_vrijwilliger->execute([$name, $pass]);
   $row = $select_vrijwilliger->fetch(PDO::FETCH_ASSOC);

   if($select_vrijwilliger->rowCount() > 0){
      $_SESSION['vrijwilliger_id'] = $row['id'];
      header('location:vrijwilliger_dashboard.php');
   }else{
      $message[] = 'incorrect username or password!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<?php include '../components/standard_header.php'; ?>
<body>

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

<section class="form-container">

<form action="" method="post">
      <h3>login</h3>
      <input type="email" name="email" required placeholder="enter your email" maxlength="50"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="password" required placeholder="enter your password" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="login now" class="btn" name="submit">
      <p>Andere gebruiker?</p>
      <a href="/voedselbank/admin/admin_login.php" class="option-btn">Directie</a>
      <a href="../home.php" class="option-btn">Medewerker</a>
   </form>

</section>
   
</body>
</html>