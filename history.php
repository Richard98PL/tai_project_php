<?php include('server.php') ?>
<?php include('session_security.php') ?>

<!DOCTYPE html>

<html>
<head>
   <title>Ryszard Rogalski Projekt TAI</title>
  <link rel="stylesheet" type="text/css" href="style.css">
  <script  type="text/javascript" src="stars.js"></script>
</head>

<body>

<?php include('nav.php'); ?>

<div class="content">
    <!-- notification message -->
    <div class="header">
  <h2>Historia zakupów</h2>
</div>

    <!-- logged in user information -->
    <?php  if (isset($_SESSION['username'])) : ?>
      <p>Jesteś zalogowany/a jako <strong><?php echo $_SESSION['username']; ?></strong></p>
      <p> <a href="index.php?logout='1'" style="color: red;">Wyloguj się</a> </p>
    <?php endif ?>
</div>

    
</body>
</html>