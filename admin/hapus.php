<?php
require 'ceksesion.php';
require 'db.php';
$idkat=$_GET['idkat'];
$idsubkat=$_GET['idsubkat'];
$id_img=$_GET['id_img'];
$idb=$_GET['idb'];

//=============================Hapus Katagori
if (isset($idkat)){
	$query=mysql_query("SELECT `id_katagori` FROM `katagori` WHERE `id_kepala` = '$idkat'");
		while ($baris =mysql_fetch_array($query)){
		mysql_query("UPDATE `barang` SET `id_katagori` = '21' WHERE `id_katagori` ='$baris[0]'");}
	mysql_query("UPDATE `barang` SET `id_katagori` = '21' WHERE `id_katagori` ='$idkat'");
	mysql_query("DELETE FROM `katagori` WHERE `id_kepala` = '$idkat'");
	mysql_query("DELETE FROM `katagori` WHERE `id_katagori` = '$idkat'");}
	
//=============================Hapus Sub Katagori
if (isset($idsubkat)){
	mysql_query("DELETE FROM `katagori` WHERE `id_katagori` = '$idsubkat'");
	mysql_query("UPDATE `barang` SET `id_katagori` = '21' WHERE `id_katagori` ='$idsubkat'");}
	

//=============================Hapus Artikel	
if (isset ($idb)){
	mysql_query("UPDATE `barang` SET `stok` = '0', `publish` = 'n' WHERE id_barang='$idb'");}

//=============================Hapus Foto
if (isset($id_img)){
	@mysql_query("DELETE FROM `foto` WHERE `id_foto` = '$id_img'");
	unlink('../gambar/'.$id_img.'.jpg');
	unlink('../gambar/'.$id_img.'s.jpg');}

header('Location:' .$_SERVER['HTTP_REFERER']);
?>
