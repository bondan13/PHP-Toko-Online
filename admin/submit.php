<?php
require 'ceksesion.php';
require 'db.php';

$notelp=$_POST['notelp'];
$password=md5($_POST['password']);
$nama=$_POST['nama'];
$alamat=$_POST['alamat'];
$kota=$_POST['id_kota'];
$norek=$_POST['norek'];

$id_katagori=$_POST['id_katagori'];
$subkatagori=$_POST['subkatagori'];

$katagori=$_POST['katagori'];

//=============================================Insert Pemasok
if (isset ($notelp) and isset ($password) and isset ($nama) and isset ($alamat) and isset ($kota)){
	@mysql_query ("INSERT INTO `ragnarok`.`user` (`notelp`, `password`, `nama`, `alamat`) 
	VALUES ('$notelp', '$password', '$nama', '$alamat')");
	$user_id=@mysql_insert_id();
	@mysql_query ("INSERT INTO `ragnarok`.`pemasok` (`id_user`, `no_rekening`, `kota`) 
	VALUES ('$user_id', '$norek', '$kota')");}

//=============================================Insert Sub Katagori
if (isset($id_katagori) and isset($subkatagori)){
	@mysql_query ("INSERT INTO `ragnarok`.`katagori` (`id_kepala`,`nama`) VALUES ('$id_katagori','$subkatagori')");}

//=============================================Insert Katagori
if (isset($katagori)){
	mysql_query ("INSERT INTO `ragnarok`.`katagori` (`nama`) VALUES ('$katagori')");
	}
	
unset ($_POST);
header('Location:' .$_SERVER['HTTP_REFERER']);
?>