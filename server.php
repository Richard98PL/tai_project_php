<?php
session_start();

include('user.php');
$DATABASE_NAME = 'YmXJZhIq7a';
$SERVER = 'remotemysql.com';
$LOGIN = 'YmXJZhIq7a';
$PASSWORD = '3FEUqbSX8j';

//default mySQL port is 3306 :)

// $DATABASE_NAME = 'tai_project';
// $SERVER = 'localhost';
// $LOGIN = 'root';
// $PASSWORD = '';

// connect to the database
$db = mysqli_connect($SERVER,$LOGIN,$PASSWORD,$DATABASE_NAME) or die('Error connecting to mysql: '.mysqli_error());
// CREATE USER
$user = new User($db);

// $test_query = "SHOW TABLES FROM $DATABASE_NAME";
// $result = mysqli_query($db, $test_query);

// $tblCnt = 0;
// while($tbl = mysqli_fetch_array($result)) {
//   $tblCnt++;
//   #echo $tbl[0]."<br />\n";
// }

// if (!$tblCnt) {
//   echo "There are no tables<br />\n";
// } else {
//   echo "There are $tblCnt tables<br />\n";
// } 


if (isset($_POST['reg_user'])) {
  // receive all input values from the form
 $user->register(mysqli_real_escape_string($db, $_POST['username']),
                 mysqli_real_escape_string($db, $_POST['email']),
                 mysqli_real_escape_string($db, $_POST['password_1']),
                 mysqli_real_escape_string($db, $_POST['password_2'])
               );
}

if ( isset($_POST['login_user']) ) {
  if( isset($_POST['username']) && isset($_POST['password']) ){
  	$user->login(mysqli_real_escape_string($db, $_POST['username']),
              mysqli_real_escape_string($db, $_POST['password'])
              );
  }
}

if ( isset($_POST['buy_tickets']) ) {
  if ( isset($_POST['place']) && isset($_POST['tickets_quantity']) &&
        isset($_POST['gift_quantity']) && isset($_POST['isVip']) ){
    $place = '';
    $tickets_quantity = '';
    $gift_quantity = '';
    $isVip = '';
    $cost = 0;
    $date = '';

    switch (mysqli_real_escape_string($db, $_POST['place'])){
      case 15 : $place = "Strefa C"; break;
      case 25 : $place = "Strefa B"; break;
      case 35 : $place = "Strefa A"; break;
      case 45 : $place = "Płyta widowiskowa"; break;
      default:  $place = "Pod sceną";
    }

    $tickets_quantity = mysqli_real_escape_string($db, $_POST['tickets_quantity']);
    $gift_quantity = mysqli_real_escape_string($db, $_POST['gift_quantity']);
    $cost = mysqli_real_escape_string($db,$_POST['cost']);
    $date = date("Y-m-d H:i:s");

    switch (mysqli_real_escape_string($db, $_POST['isVip'])){
      case 1: $isVip = false; break;
      default: $isVip = true;
    }

    $user->buy_tickets($place,$tickets_quantity,$gift_quantity,$isVip,$cost,$date);
  }
 }

 if ( isset($_POST['get_history']) ){
  $user->get_history();
 }

 if ( isset($_POST['get_profile']) ){
  $user->get_profile();
 }

 if ( isset($_POST['update_user']) ){

  $new_username = mysqli_real_escape_string($db,$_POST['new_username']);
  $new_email = mysqli_real_escape_string($db,$_POST['new_email']);
  $new_name = mysqli_real_escape_string($db,$_POST['new_name']);
  $new_surname = mysqli_real_escape_string($db,$_POST['new_surname']);
  $user_id = mysqli_real_escape_string($db,$_POST['id']);

  $user->update_user($new_username,$new_email,$new_name,$new_surname,$user_id);
 }

 if ( isset($_POST['update_password']) ){

  $old_password = mysqli_real_escape_string($db,$_POST['old_password']);
  $new_password_1 = mysqli_real_escape_string($db,$_POST['new_password_1']);
  $new_password_2 = mysqli_real_escape_string($db,$_POST['new_password_2']);

  $user->try_to_update_password($old_password,$new_password_1,$new_password_2);

 }
?>