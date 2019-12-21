<?php include('server.php'); ?>

<!DOCTYPE html>

<html>

<head>
  <title>Ryszard Rogalski Projekt TAI</title>
  <link rel="stylesheet" type="text/css" href="style.css">
  <script  type="text/javascript" src="stars.js"></script>

</head>

<body>

<?php include('nav.php'); ?>

  <form method="post" action="register.php" class="form">

    <div class="header">
    Rejestracja
  </div>

  	<?php include('errors.php'); ?>

  	<div class="input-group">
  	  <label>Nazwa użytkownika</label>
  	  <input type="text" name="username">
  	</div>

  	<div class="input-group">
  	  <label>Email</label>
  	  <input type="email" name="email">
  	</div>

  	<div class="input-group">
  	  <label>Hasło</label>
  	  <input type="password" name="password_1">
  	</div>

  	<div class="input-group">
  	  <label>Potwierdź hasło</label>
  	  <input type="password" name="password_2">
  	</div>

  	<div class="input-group">
  	  <button type="submit" class="btn" name="reg_user">Zarejestruj</button>
  	</div>

  	<p>
  		<p style="color: black;">Jesteś już zarejestrowany?</p> <a href="login.php">Zaloguj się.</a>
  	</p>

  </form>

</body>

</html>