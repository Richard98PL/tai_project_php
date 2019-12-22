<?php

class User{

	private $username = "";
	private $email    = "";
	private $password_1 = "";
	private $password_2 = "";
	private $password = "";
	public $errors = array(); 
	private $db;

	function __construct($db){
		$this->db = $db;
	}

	function register($_username,$_email,$_password_1,$_password_2){
		 $this->username = $_username;
		 $this->email = $_email;
		 $this->password_1 = $_password_1;
		 $this->password_2 = $_password_2;
		 $this->validate_register();
	}

	function validate_register(){

	  if (empty($this->username)) { 
	    array_push($this->errors, "Wymagana nazwa użytkownika."); 
	  }
	  if (empty($this->email)) { 
	    array_push($this->errors, "Email jest wymagany."); 
	  }
	  if (empty($this->password_1)) { 
	    array_push($this->errors, "Należy podać hasło."); 
	  }
	  if ($this->password_1 != $this->password_2) {
		 array_push($this->errors, "Hasła do siebie nie pasują");
	  }

	  // first check the database to make sure 
	  // a user does not already exist with the same username and/or email
	  $user_check_query = "SELECT * FROM user WHERE username='$this->username' OR email='$this->email' LIMIT 1";
	  $result = mysqli_query($this->db, $user_check_query);
	  $user = mysqli_fetch_assoc($result);
	  
	  if ($user) { // if user exists
	    if ($user['username'] === $this->username) {
	      array_push($this->errors, "Taki użytkownik już istnieje.");
	    }

	    if ($user['email'] === $this->email) {
	      array_push($this->errors, "Email już zajęty.");
	    }
	  }

	  	 if (count($this->errors) == 0){
	  	 	$this->register_user();
	  	 }

	}

	function register_user(){
	$this->password = md5($this->password_1);//encrypt the password before saving in the database
	$register_date = date("Y-m-d H:i:s");
	
  	$query = "INSERT INTO user (username, email, password,register_date) 
  			  VALUES('$this->username', '$this->email', '$this->password','$register_date')";
  	

  	$_SESSION['username'] = $this->username;
  	$_SESSION['success'] = "Jesteś zalogowany.";
  	header('location: index.php');
  	$result = mysqli_query($this->db, $query);

  	if(! $result ) {
               die('Could not enter data: ' . mysqli_error($this->db));
            }
  }
	
	function login($_username, $_password){
		$this->username = $_username;
		$this->password = $_password;
		$this->validate_login();
	}

	function validate_login(){

		if (empty($this->username)) {
	    array_push($this->errors, "Wymagana nazwa użytkownika do zalogowania.");
		  }
		  if (empty($this->password)) {
	    array_push($this->errors, "Hasło jest wymagane do zalogowania.");
	  }

	  if (count($this->errors) == 0) {
	  		$this->login_user();
	}

  }

  function login_user(){
  	$this->password = md5($this->password);
  	$query = "SELECT * FROM user WHERE username = '$this->username' AND password = '$this->password' ";
  	$results = mysqli_query($this->db, $query);
  	if (mysqli_num_rows($results) == 1) {
  	  $_SESSION['username'] = $this->username;
  	  $_SESSION['success'] = "Jesteś zalogowany";
  	  header('location: index.php');
  	}else {
  		array_push($this->errors, "Złe hasło lub nazwa użytkownika.");
  	}
  }

	private $place;
	private $tickets_quantity;
	private $gift_quantity;
	private $isVip;
	private $cost;
	private $date;

  function buy_tickets($_place,$_tickets_quantity,$_gift_quantity,$_isVip,$_cost,$_date){
  	$this->place = $_place;
  	$this->tickets_quantity = $_tickets_quantity;
  	$this->gift_quantity = $_gift_quantity;
  	$this->isVip = $_isVip;
  	$this->cost = $_cost;
  	$this->date = $_date;
  	$ticket_username = $_SESSION['username'];

  	$query = "INSERT INTO tickets (username,place,tickets_quantity,gift_quantity,isVip,cost,date) 
  			  VALUES('$ticket_username', '$this->place', '$this->tickets_quantity','$this->gift_quantity','$this->isVip','$this->cost','$this->date')";
  	$result = mysqli_query($this->db, $query);

  	if(! $result ) {
               die('Could not enter data: ' . mysqli_error($this->db));
            }
  
  }

  function get_history(){
  	$history_username = $_SESSION['username'];
  	$query = "SELECT * FROM tickets WHERE username = '$history_username'";
  	$result = mysqli_query($this->db, $query);

	  	print "
	  <table border=\"5\" class=\"results_table\">
	   <tr>
	  <td>Id zakupu</td>
	  <td>Użytkownik</td> 
	  <td>Miejsce</td> 
	  <td>Ilość biletów</td> 
	  <td>Ilość zestawów pamiątkowych</td>
	  <td>Czy wejścia VIP</td> 
	  <td>Koszt</td> 
	  <td>Data</td> 
	  </tr>"; 
	 while($row = mysqli_fetch_array($result))
	 { 
	print "<tr>"; 
	print "<td>" . $row['id'] ."</td>";
	print "<td>" . $row['username'] . "</td>"; 
	print "<td>" . $row['place'] . "</td>"; 
	print "<td>" . $row['tickets_quantity'] . "</td>";
	print "<td>" . $row['gift_quantity'] . "</td>";
	$vipBool;
	if($row['isVip'] == 1){
		$vipBool = 'Tak';
	}else{
		$vipBool = 'Nie';
	}
	print "<td>" . $vipBool . "</td>";
	print "<td>" . $row['cost'] . "</td>";
	print "<td>" . $row['date'] . "</td>"; 
	print "</tr>"; 
	} 
	print "</table>"; 

  }

  function get_profile(){
  	$profile_username = $_SESSION['username'];
  	$query = "SELECT * FROM user WHERE username = '$profile_username' LIMIT 1";
  	$result = mysqli_query($this->db, $query);

  	print "
  	<form action=\"success_on_profile_change.php\" class=\"profile_form\" method=\"post\">
	  <table class=\"profile_table\">
	   <tr>
	  <td>Nazwa użytkownika</td>
	  <td>Email</td> 
	  <td>Imie</td> 
	  <td>Nazwisko</td> 
	  <td>Data rejestracji</td> 
	  </tr>"; 
	 while($row = mysqli_fetch_array($result))
	 { 
	print "<tr>"; 
	print "<td>". $row['username'] ."</td>"; 
	print "<td><input name =\"new_email\" type=\"text\" value='"  . $row['email'] . "' required></input></td>";
	print "<td><input name =\"new_name\" type=\"text\" value='"  . $row['name'] . "'></input></td>";
	print "<td><input name =\"new_surname\" type=\"text\" value='"  . $row['surname'] . "'></input></td>";
	print "<td>" . $row['register_date'] . "</td>";
	print "</tr>"; 
	print "<input name=\"id\" value='"  . $row['id'] . "' hidden></input>"; //necessary to get id in SQLDB
	} 
	
	print "</table>";
	print "<button type=\"submit\"name=\"update_user\" class = \"btn\" style=\"margin: 5px;\">Zmień dane</button>";

	print "</form>";

//action=\"success_on_password_change.php\"
  	print "
  	<form class=\"password_form\" method=\"post\">

  	<table class=\"profile_table\">
  	<tr>
  		<td>Stare hasło</td> <td> <input name=\"old_password\" type=\"password\" required></input</td>
  	</tr>
  	<tr>
  		<td>Nowe hasło</td> <td> <input name=\"new_password_1\" type=\"password\" required></input</td>
  	</tr>
  	<tr>
  		<td>Potwierdź nowe hasło</td> <td> <input name=\"new_password_2\" type=\"password\" required></input</td>
  	</tr>
  	<tr>
  		<td></td> <td><button type=\"submit\"name=\"update_password\" class = \"btn\" style=\"margin: 5px;\">Zmień hasło</button></td>
  	</tr>";

  	print "</table>";
  	print "</form>";

  }

  private $new_username;
  private $new_email;
  private $new_name;
  private $new_surname;
  private $user_id;

  function update_user($_new_username,$_new_email,$_new_name, $_new_surname,$_user_id){

  	$this->new_username = $_new_username;
  	$this->new_email = $_new_email;
  	$this->new_name = $_new_name;
  	$this->new_surname = $_new_surname;
  	$this->user_id = $_user_id;

  	$query = "UPDATE user SET username = '$this->new_username', email = '$this->new_email', name = '$this->new_name', surname = '$this->new_surname' WHERE id ='$this->user_id' ";
  	mysqli_query($this->db, $query);
  }

  private $old_password;
  private $new_password_1;
  private $new_password_2;

  function try_to_update_password($_old_password,$_new_password_1,$_new_password_2){
  	$this->old_password = $_old_password;
  	$this->new_password_1 = $_new_password_1;
  	$this->new_password_2 = $_new_password_2;

  	 if (empty($this->old_password)) { 
	    array_push($this->errors, "Wymagane podanie starego hasła."); 
	    $this->get_profile();
	  }
	  if (empty($this->new_password_1)) { 
	    array_push($this->errors, "Wymaganie podania nowego hasła."); 
	    $this->get_profile();
	  }
	  if (empty($this->new_password_2)) { 
	    array_push($this->errors, "Wymagane podanie potwierdzenia nowego hasła."); 
	    $this->get_profile();
	  }
	  if ($this->new_password_1 != $this->new_password_2) {
		 array_push($this->errors, "Hasła do siebie nie pasują.");
		 $this->get_profile();
	  }
	  	$username = $_SESSION['username'];
	  	$this->old_password = md5($this->old_password);

		$query = "SELECT * FROM user WHERE username = '$username' AND password = '$this->old_password' ";
	  	$results = mysqli_query($this->db, $query);
	  	if (mysqli_num_rows($results) == 1) {  
	  	}else {
	  		array_push($this->errors, "Złe stare hasło.");
	  		$this->get_profile();
	  	}

	  if (count($this->errors) == 0) {
	  		$this->update_password($this->new_password_1, $_SESSION['username']);
	}

  }

  function update_password($_new_password,$_username){

  	 $_new_password = md5($_new_password);
  	 $query = "UPDATE user SET password = '$_new_password' WHERE username = '$_username' ";
  	 mysqli_query($this->db, $query);
  	 header('location: success_on_password_change.php');
  	 echo $_new_password;
  	echo $_username;
  }

 }

?>
