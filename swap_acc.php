<?php 
session_start();
$st = $_GET['st'];
$id = $_GET['id'];
if ($st === "return_acc") {
	$_SESSION['id'] = $_SESSION['id_original'];
	header('location:menu.php');
}elseif($st === "swap_acc"){
	$_SESSION['id'] = $id;
	header('location:menu.php');
}
?>