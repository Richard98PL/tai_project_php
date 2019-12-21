<?php include('server.php') ?>

<?php 
  if (!isset($_SESSION['username'])) {
  	$_SESSION['msg'] = "Aby korzystać z serwisu w pełni, najpierw się zaloguj. </br>";
  	header('location: login.php');
  }
  if (isset($_GET['logout'])) {
  	session_destroy();
  	unset($_SESSION['username']);
  	header("location: login.php");
  }
?>

<!DOCTYPE html>

<html>

<head>
	<title>Strona domowa</title>
	<link rel="stylesheet" type="text/css" href="style.css">
  <script  type="text/javascript" src="stars.js"></script>

</head>

<body>

<?php include('nav.php'); ?>
<?php include('session_security.php') ?>

    
    
<div class="content">
  	<!-- notification message -->
    <div class="header">
  <h2>Project_TAI</h2>
</div>



    <!-- logged in user information -->
    <?php  if (isset($_SESSION['username'])) : ?>
    	<p>Jesteś zalogowany/a jako <strong><?php echo $_SESSION['username']; ?></strong></p>
    	<p> <a href="index.php?logout='1'" style="color: red;">Wyloguj się</a> </p>
    <?php endif ?>
</div>

  <form class="form2" action="success.php" method="post">
      
     <div class="input-group">
                 <label>Miejsca</label>
                 <select class="form-control" id="place" onchange="finalCost()" name="place">
                     <option value="0" selected>Wybierz miejsce</option>
                     <option value="15"> Strefa C </option>
                     <option value="25"> Strefa B </option>
                     <option value="35"> Strefa A </option>
                     <option value="45"> Płyta widowiskowa  </option>
                     <option value="55"> Pod sceną </option>
                    </select>
             </div>

             <div class="input-group">
                 <label>Ilość biletów</label>
                 <select class="form-control" id="tickets" onchange="finalCost()" name="tickets_quantity">
                     <option value="0"> 0 </option>
                     <option value="1"> 1 </option>
                     <option value="2"> 2 </option>
                     <option value="3"> 3 </option>
                     <option value="4"> 4 </option>
                     <option value="5"> 5 </option>
                     <option value="6"> 6 </option>
                     <option value="7"> 7 </option>
                 </select>
             </div>

             <div class="input-group">
                 <label>Ilość zestawów pamiątkowych</label>
                 <select class="form-control" id="gift_number" onchange="finalCost()" name="gift_quantity">
                     <option value="0"> 0 </option>
                     <option value="1"> 1 </option>
                     <option value="2"> 2 </option>
                     <option value="3"> 3 </option>
                     <option value="4"> 4 </option>
                     <option value="5"> 5 </option>
                     <option value="6"> 6 </option>
                     <option value="7"> 7 </option>
                 </select>
             </div>

             <div class="input-group">
                 <label>Czy wejścia VIP?</label>
                 <select class="form-control" id="vip" onchange="finalCost()" name="isVip">
                     <option value="1.5"> Tak </option>
                     <option value="1" selected> Nie </option>
                 </select>
             </div><br>

             <div class="input-group">
                 <label>Koszt całkowity: </label>
                 <span id="result" style="background-color: #7527b0;color: #fff;padding: 6px 70px;font-weight: 600;font-size: 18px;border-radius: 5px;">0 PLN</span>
                 <input  id="cost" name="cost" hidden>
             </div>



    <div class="input-group">
      <button type="submit" class="btn" name="buy_tickets" disabled id="buy_tickets">Wybierz miejsca</button>
    </div>
      
      <script>
        function finalCost(){
            let place = document.getElementById("place").value;
            let tickets = document.getElementById("tickets").value;
            let giftNum = document.getElementById("gift_number").value;
            let vip = document.getElementById("vip").value;
            let total = ( ( (place*tickets) + (giftNum*15) ) * vip).toFixed(2) + " PLN";

            document.getElementById('cost').value = ((place*tickets) + (giftNum*15) * vip).toFixed(2);

            if(place == 0){
              total = 0;
            }
            console.log(total);
            document.getElementById("result").innerHTML = total;
            if(total != '0 PLN'){
              document.getElementById("buy_tickets").disabled = false;
              document.getElementById("buy_tickets").innerHTML = "Kup bilety";
            }else{
              document.getElementById("buy_tickets").disbaled = true;
              document.getElementById("buy_tickets").innerHTML = "Wybierz miejsca";
            }
        }
    </script>

    </form>


		
</body>
</html>