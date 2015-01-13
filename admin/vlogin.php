<?php
session_start();
$aname=$_POST['aname'];
$apass=$_POST['apass'];
if ($aname =='bondan13' and $apass =='1jamsaja'){ 
	unset ($_POST);
	$_SESSION['aname']='bondan13';
	header ("location:.");
	}
else{
	$konfirmasi = "Gagal Login";
	header ("location:login.php?konfirmasi=".$konfirmasi);
	}
?>