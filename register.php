<?php
  $usuario = $_POST["username"];
  $password = $_POST["password"];

  $chkuser = "admin";
  $chkpass = "1234";

  if ($usuario == $chkuser && $password == $chkpass) {
    header ("location:login.html");
  } else {
    header( "location:error.html" );
  }
?>