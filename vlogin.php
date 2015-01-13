<?php
	session_start();
	include "db.php";
	$notelp=$_POST['notelp'];
	$password=$_POST['password'];
	$asal=$_POST['link_b'];
	if ($notelp !=NULL and $password !=NULL) { 
		$query=("select * from user where notelp = '$notelp'");
		$hasil=@mysql_query($query);
		$d_uid=@mysql_result($hasil,0,0);
		$d_pass=@mysql_result($hasil,0,2);
		$d_nama=@mysql_result($hasil,0,3);
		$d_pangkat=@mysql_result($hasil,0,7);
		
		if (md5($password) == $d_pass){
			unset ($_POST);
			$_SESSION['d_uid']=$d_uid;
			$_SESSION['d_nama']=$d_nama;
			$_SESSION['d_pangkat']=$d_pangkat;
			if (isset ($asal)){
				header('Location:' . $asal);}
			else {header('Location:' .$_SERVER['HTTP_REFERER']);}
		}
		else {
			$konfirmasi = "Nomor Handphone atau Password salah";
			header ("location:login.php?konfirmasi=".$konfirmasi);	
		}
	}
	else{
		$konfirmasi = "Nomor Handphone atau Password tidak boleh kosong";
		header ("location:login.php?konfirmasi=".$konfirmasi);}
?>