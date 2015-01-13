<?php
require "ceksesion.php";
require "db.php";
$pengaturan=$_POST['pengaturan'];
$get_p=$_GET['p'];

if($pengaturan=='' && $get_p==''){header('Location:index.php');}

if ($pengaturan=='lnss'){
	$tgl_byr=date("Y-m-d",strtotime($_POST['tgl_byr']));
	$idt=$_POST['idt'];
	$bank=$_POST['bank'];
	@mysql_query("UPDATE `transaksi` SET `tanggal_bayar` = '$tgl_byr', `bank` = '$bank', `status` = 'lunas' 
	WHERE `transaksi`.`id_transaksi` ='$idt';");
	header('Location: ' . $_SERVER['HTTP_REFERER']);}

if ($pengaturan=='batal'){
	$idt=$_POST['idt'];
	@mysql_query("UPDATE `transaksi` SET `tanggal_bayar` = NULL, `bank` = NULL, `status` = 'pesan' 
	WHERE `transaksi`.`id_transaksi` ='$idt';");
	header('Location: ' . $_SERVER['HTTP_REFERER']);}
	
if ($pengaturan=='kirim'){
	$tgl_krm=date("Y-m-d",strtotime($_POST['tgl_krm']));
	$resi=$_POST['resi'];
	$idt=$_POST['idt'];
	$query=@mysql_query ("SELECT 
						 transaksi.jumlah,
						 transaksi.id_barang,
  						 barang.stok,
						 barang.komisi
					From
  						transaksi Inner Join
  						barang On transaksi.id_barang = barang.id_barang
					Where
  					transaksi.id_transaksi = '$idt' LIMIT 1");
	while ($hasil=@mysql_fetch_array($query)){
			$jumlah=$hasil[0];
			$idb=$hasil[1];
			$stok=$hasil[2];
			$komisi=$hasil[3];}
	$stok_u=$stok-$jumlah;
	$komisi_b=$komisi*80/100*$jumlah;
	$komisi_d=$komisi*20/100*$jumlah;
	@mysql_query("UPDATE `barang` SET `stok` = '$stok_u' WHERE `id_barang` ='$idb';");
	@mysql_query("UPDATE `komisi` SET `jumlah` = '$komisi_b' 
	WHERE `id_transaksi` ='$idt' AND `jenis`= 'beli' AND `id_referral` > 0;");
	@mysql_query("UPDATE `komisi` SET `jumlah` = '$komisi_d' 
	WHERE `id_transaksi` ='$idt' AND `jenis`= 'daftar' AND `id_referral` > 0;");
	@mysql_query("UPDATE `transaksi` SET `tanggal_kirim` = '$tgl_krm', 
	`nomor_resi` = '$resi', `status` = 'terkirim' WHERE `transaksi`.`id_transaksi` ='$idt';");
	header('Location: ' . $_SERVER['HTTP_REFERER']);}
	
if ($pengaturan=='bayar_k'){
	$idp=$_POST['idp'];
	$opsi=$_POST['opsi'];
	if ($opsi=='bayar'){
		$tgl_bayar_k=date("Y-m-d",strtotime($_POST['tgl_bayar_k']));
		@mysql_query("UPDATE `bayar_komisi` SET `tgl_dibayar` = '$tgl_bayar_k', `status` = 'dibayar' 
		WHERE `id_bayar_k` ='$idp';");
		@mysql_query("UPDATE `komisi` SET `status` = 'dibayar' 
		WHERE `id_bk` ='$idp';");}
	if ($opsi=='tolak'){
		@mysql_query("UPDATE `komisi` SET `status` = 'valid' 
		WHERE `id_bk` ='$idp';");}
	header('Location: ' . $_SERVER['HTTP_REFERER']);}
	
if ($get_p=='user'){
	$opsi=$_GET['opsi'];
	$idu=$_GET['idu'];
	if ($opsi=='nonaktif'){
		@mysql_query("UPDATE `user` SET `pangkat` = 'non aktif' WHERE `id_user` ='$idu';");}
	if ($opsi=='aktif'){
		@mysql_query("UPDATE `user` SET `pangkat` = 'user' WHERE `id_user` ='$idu';");}
	header('Location: ' . $_SERVER['HTTP_REFERER']);}
	
if ($get_p=='komisi'){
	$opsi=$_GET['opsi'];
	$idk=$_GET['idk'];
	if ($opsi=='tdkvalid'){
		@mysql_query("UPDATE `komisi` SET `status` = 'ditolak' WHERE `id_komisi` ='$idk';");}
	if ($opsi=='valid'){
		@mysql_query("UPDATE `komisi` SET `status` = 'valid' WHERE `id_komisi` ='$idk';");}
	header('Location: ' . $_SERVER['HTTP_REFERER']);}	
	
if ($get_p=='transaksi'){
	$opsi=$_GET['opsi'];
	if ($opsi=='del'){
		@mysql_query("DELETE FROM `transaksi` WHERE `tanggal` < NOW() - INTERVAL 2 DAY AND `status` = 'pesan'");}
	header('Location: ' . $_SERVER['HTTP_REFERER']);}	

if ($get_p=='reqpass'){
	$opsi=$_GET['opsi'];
	$idp=$_GET['idp'];
	if ($opsi=='del'){
		@mysql_query("DELETE FROM `req_pass` WHERE `id_req_pass` = '$idp'");}
	header('Location: ' . $_SERVER['HTTP_REFERER']);}	
	
if ($get_p=='addcomment'){
	$idc=$_GET['idc'];
	if ($idc > 0 ){
		@mysql_query("UPDATE komentar SET status = 'p' WHERE id_komentar='$idc' AND status='m'");}
	header('Location: ' . $_SERVER['HTTP_REFERER']);}
	
if ($get_p=='delcomment'){
	$idc=$_GET['idc'];
	if ($idc > 0 ){
		@mysql_query("DELETE FROM komentar WHERE id_komentar='$idc' ");}
	header('Location: ' . $_SERVER['HTTP_REFERER']);}
	
?>