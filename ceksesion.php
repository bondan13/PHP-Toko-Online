<?php
	session_start();
	if($_SESSION['d_uid']!=NULL && $_SESSION['d_nama']!=NULL){
		$login='true';
		$s_uid=$_SESSION['d_uid'];
		$s_nama=$_SESSION['d_nama'];
		$s_pangkat=$_SESSION['d_pangkat'];}
?>