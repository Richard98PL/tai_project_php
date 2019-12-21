<?php include('server.php') ?>


<!DOCTYPE html>

<html>
<head>
   <title>Ryszard Rogalski Projekt TAI</title>
  <link rel="stylesheet" type="text/css" href="style.css">
  <script  type="text/javascript" src="stars.js"></script>
</head>

<body>

<?php include('nav.php'); ?>


  <form method="post" action="login.php" class="form">
    
    <div class="header">
    Logowanie
  </div>

  	<?php include('errors.php'); ?>

    <?php
      if(isset($_SESSION['msg'])){
        echo '<br/>'.$_SESSION['msg']; 
        unset($_SESSION['msg']);
    }
    ?>
    

  	<div class="input-group">
  		<label>Nazwa użytkownika</label>
  		<input type="text" name="username" >
  	</div>

  	<div class="input-group">
  		<label>Hasło</label>
  		<input type="password" name="password">
  	</div>

  	<div class="input-group">
  		<button type="submit" class="btn" name="login_user">Zaloguj się</button>
  	</div>

  	<p>
  		<p style="color: black;">Nie jesteś jeszcze zarejestrowany?</p> <a href="register.php">Zarejestruj się</a>
  	</p>
  </form>

</body>
</html>