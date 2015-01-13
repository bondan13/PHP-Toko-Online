<?php
	require 'ceksesion.php';
	require 'db.php';
	$pengaturan=$_POST['pengaturan'];
	
	if ($pengaturan == ''){
		header ("location:index.php");}
	
	
	if ($pengaturan == 'daftar'){
		$notelp=$_POST['notelp'];
		$d_password=md5($_POST['password']);
		$password=$_POST['password'];
		$nama=$_POST['nama'];
		$idreff=$_COOKIE['creff'];
		if(strlen($notelp)>9 && strlen($password)>3 && strlen($nama) >3 && is_numeric($notelp)){
			$notelp_db=@mysql_fetch_row(@mysql_query("SELECT notelp FROM user WHERE notelp = '$notelp'"));
			if ($notelp_db > 0){ header ("location:daftar.php?registrasi=notelp");}
			else {
				@mysql_query ("INSERT INTO `ragnarok`.`user` 
				(`notelp`, `password`, `nama`, `id_refferal`) 
				VALUES ('$notelp', '$d_password', '$nama', '$idreff')");
				header ("location:index.php?registrasi=sukses");}}
		else {
			header ("location:daftar.php?registrasi=gagal");}}
		
	
	if ($pengaturan == 'edit-profile'){
		if ($login != 'true'){
			header ("location:login.php");}
		$nama=$_POST['nama'];
		$alamat=$_POST['alamat'];
		$notelp=$_POST['notelp'];
		$idl=$_POST['idl'];
		$norek=$_POST['norek'];
		$bank=$_POST['bank'];
		$notelp_db=@mysql_fetch_row(@mysql_query("SELECT notelp FROM user WHERE notelp = '$notelp' AND id_user != '$s_uid'"));
		if($notelp_db > 0){
			header ("location:profile.php?edit=gagal_notelp");}
		else if(strlen($notelp)>9 && strlen($nama) >3 && is_numeric($notelp)){
			if ($idl!=NULL){
				@mysql_query("UPDATE user SET notelp='$notelp', nama='$nama', 
				alamat='$alamat', id_kota='$idl' WHERE id_user='$s_uid'");
				@mysql_query("UPDATE refferal SET no_rek='$norek', bank='$bank' WHERE id_user='$s_uid'");
				$_SESSION['d_nama']=$nama;}
	
			if ($idl==NULL) {
				@mysql_query("UPDATE user SET notelp='$notelp', nama='$nama', 
				alamat='$alamat' WHERE id_user='$s_uid'");
				@mysql_query("UPDATE refferal SET no_rek='$norek', bank='$bank' WHERE id_user='$s_uid'");
				$_SESSION['d_nama']=$nama;}
			header ("location:profile.php");}
		else{
			header ("location:profile.php?edit=gagal");}}
?>