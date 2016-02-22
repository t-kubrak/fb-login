<!--Logged-in users page-->
<?php
session_start();
require_once __DIR__ . '/vendor/autoload.php';
include 'jsLogin-helper.html';

if(!isset($_SESSION['fb_access_token'])){
  echo "<a href=\"#\" onClick=\"logInWithFacebook()\"><img src='img/FB-f-Logo__blue_50.png'></a>";
}else{
  $fb = new Facebook\Facebook([
	  'app_id' => 'APP ID HERE',
	  'app_secret' => 'APP SECRET ID HERE',
	  'default_graph_version' => 'v2.2',
  ]);

  echo "<a href=\"logout.php\">Logout</a>";

  $fb_user = $_SESSION['fb_user'];
  echo nl2br("\n<img src=\"//graph.facebook.com/".$_SESSION['id']."/picture\">\n");
  echo $_SESSION['name'];

/*	  echo $fb_user;
  $fbu = json_decode($fb_user);*/
}

?>
