<?php
session_start();
if	(!isset ($_SESSION['aname'])){ 
	header ("location:login.php");}
?>