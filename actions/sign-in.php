<?php 

include '../classes/User.php';
$user = new User;

$user->signIn($_POST['username'],$_POST['password']);

