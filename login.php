<?php
  $username = $_POST["username"];
  $password = $_POST["password"];

  $chkuser = "admin";
  $chkpass = "1234";

  if ($username == $chkuser && $password == $chkpass) {
    header ("location:listar.php");
  } else {
    header( "location:error.html" );
  }
?>