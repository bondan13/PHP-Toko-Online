<?php
require "ceksesion.php";
require 'db.php'; 
//=====================================================================halaman
	$itemperpage=15;
	if (isset($_GET['h'])){
		$hal=$_GET['h'];
		$posisi=($hal-1)*$itemperpage;}
	else if (empty($_GET['h'])){
		$hal=1;
		$posisi=0;}
//=====================================================================halaman

if	(isset($_GET[c])){
	$opsi=$_GET['c'];
	$cari=$_GET['cari'];
	if ($opsi=='pesan'){
		$query=@mysql_query("Select transaksi.id_transaksi,DATE (transaksi.tanggal) AS DATE, 
					transaksi.status, user.nama, user.notelp From transaksi 
			  		Inner Join user On transaksi.id_user = user.id_user 
					WHERE transaksi.status = 'pesan' 
			  		Order by transaksi.id_transaksi desc, transaksi.tanggal
			  		desc LIMIT $posisi,$itemperpage ");
		$jumlahdata=@mysql_num_rows(mysql_query("SELECT id_transaksi FROM transaksi WHERE transaksi.status = 'pesan'"));} 
		
	if ($opsi=='konfirmasi'){
		$query=@mysql_query("Select transaksi.id_transaksi,DATE (transaksi.tanggal) AS DATE, 
					transaksi.status, user.nama, user.notelp From transaksi 
			  		Inner Join user On transaksi.id_user = user.id_user 
					WHERE transaksi.status = 'konfirmasi' 
			  		Order by transaksi.id_transaksi desc, transaksi.tanggal
			  		desc LIMIT $posisi,$itemperpage ");
		$jumlahdata=@mysql_num_rows(mysql_query("SELECT id_transaksi FROM transaksi WHERE transaksi.status = 'konfirmasi'"));} 

	if ($opsi=='lunas'){
		$query=@mysql_query("Select transaksi.id_transaksi,DATE (transaksi.tanggal) AS DATE, 
					transaksi.status, user.nama, user.notelp From transaksi 
			  		Inner Join user On transaksi.id_user = user.id_user 
					WHERE transaksi.status = 'lunas' 
			  		Order by transaksi.id_transaksi desc, transaksi.tanggal
			  		desc LIMIT $posisi,$itemperpage ");
		$jumlahdata=@mysql_num_rows(mysql_query("SELECT id_transaksi FROM transaksi WHERE transaksi.status = 'lunas'"));} 

	if ($opsi=='selesai'){
		$query=@mysql_query("Select transaksi.id_transaksi,DATE (transaksi.tanggal) AS DATE, 
					transaksi.status, user.nama, user.notelp From transaksi 
			  		Inner Join user On transaksi.id_user = user.id_user 
					WHERE transaksi.status = 'terkirim' 
			  		Order by transaksi.id_transaksi desc, transaksi.tanggal
			  		desc LIMIT $posisi,$itemperpage ");
		$jumlahdata=@mysql_num_rows(mysql_query("SELECT id_transaksi FROM transaksi WHERE transaksi.status = 'terkirim'"));} 
		
	if ($opsi=='nf'){
		$query=@mysql_query("Select transaksi.id_transaksi,DATE (transaksi.tanggal) AS DATE, 
					transaksi.status, user.nama, user.notelp From transaksi 
			  		Inner Join user On transaksi.id_user = user.id_user 
					WHERE transaksi.id_transaksi LIKE '%$cari%'
			  		Order by transaksi.id_transaksi desc, transaksi.tanggal
			  		desc LIMIT $posisi,$itemperpage ");
		$jumlahdata=@mysql_num_rows(mysql_query("SELECT id_transaksi FROM transaksi WHERE transaksi.id_transaksi LIKE '%$cari%'"));} 

	if ($opsi=='nm'){
		$query=@mysql_query("Select transaksi.id_transaksi,DATE (transaksi.tanggal) AS DATE, 
					transaksi.status, user.nama, user.notelp From transaksi 
			  		Inner Join user On transaksi.id_user = user.id_user 
					WHERE user.nama LIKE '%$cari%' 
			  		Order by transaksi.id_transaksi desc, transaksi.tanggal
			  		desc LIMIT $posisi,$itemperpage ");
		$jumlahdata=@mysql_num_rows(mysql_query("SELECT id_transaksi FROM transaksi WHERE user.nama LIKE '%$cari%'"));} 
		
	if ($opsi=='nt'){
		$query=@mysql_query("Select transaksi.id_transaksi,DATE (transaksi.tanggal) AS DATE, 
					transaksi.status, user.nama, user.notelp From transaksi 
			  		Inner Join user On transaksi.id_user = user.id_user 
					WHERE user.notelp LIKE '%$cari%' 
			  		Order by transaksi.id_transaksi desc, transaksi.tanggal
			  		desc LIMIT $posisi,$itemperpage ");
		$jumlahdata=@mysql_num_rows(mysql_query("SELECT id_transaksi FROM transaksi WHERE user.notelp LIKE '%$cari%'"));} 
		
	$link="c=".$opsi."&cari=".$cari."&";
	}
	
else{
$query=@mysql_query("Select transaksi.id_transaksi,DATE (transaksi.tanggal) AS DATE, 
					transaksi.status, user.nama, user.notelp From transaksi 
			  		Inner Join user On transaksi.id_user = user.id_user 
			  		Order by transaksi.id_transaksi desc, transaksi.tanggal
			  		desc LIMIT $posisi,$itemperpage ");
$jumlahdata=@mysql_num_rows(mysql_query("SELECT id_transaksi FROM transaksi"));} 
//=====================================================================halaman
$jumlahhalaman=ceil($jumlahdata/$itemperpage);
//=====================================================================halaman				
?>
<html>
<head>
<?php require'a_head.php' ?>
<link rel="stylesheet" type="text/css" href="../tampilan/style-table.css">
</head>
<body>
<?php 
require'a_top.php';
require'a_menu.php';
?>
<div class="isi">
	<div style="float:left; width:auto; margin-bottom:15px;">
	<a class='createuser' href="transaksi.php?c=pesan"> Pesan</a>
	<a class='createuser' href="transaksi.php?c=konfirmasi"> Konfirm</a>
	<a class='createuser' href="transaksi.php?c=lunas"> Lunas</a>
	<a class='createuser' href="transaksi.php?c=selesai"> Terkirim</a>
	</div>
	<div style="float:right; width:auto; border:1px solid #CCCCCC; height:24;">
	<form method="get" action="transaksi.php" id="cari">
	<select name="c" style="border:0px;">
		<option value="nf">No Faktur</option>
	  	<option value="nm">Nama</option>
	 	<option value="nt">Notelp</option>
	</select> 
	<input type="text" name="cari"/><input type="submit" value="cari" />
	</form>
	</div>
	<table id="rounded-corner">
		<thead>
			<tr>
				<th scope="col" class="rounded-company" width="100">Tanggal</th>
				<th scope="col" class="rounded-q1" width="80">No Faktur</th>
				<th scope="col" class="rounded-q2">Nama Pemesan</th>
				<th scope="col" class="rounded-q3" width="100">No Telp</th>
				<th scope="col" class="rounded-q4" width="50">Status</th>
			</tr>
		</thead>
			<tbody>
					<?php						
					while ($baris =mysql_fetch_array($query)){	
							echo "<tr>";
							echo "<td >".date("j F Y", strtotime($baris[1]))."</td>";
							echo "<td >
							<a href='../admin/dtransaksi.php?idt=".$baris[0]."'>
							".$baris[0]."</a></td>";
							echo "<td >".$baris[3]."</td>";
							echo "<td >".$baris[4]."</td>";
							echo "<td >
							<a href='../admin/dtransaksi.php?idt=".$baris[0]."'>
							".$baris[2]."</a></td>";
							echo "</tr>";
						}
					?>
			</tbody>
	</table>
<?php
//=====================================================================halaman				
				echo "<div align='center' style='width:100%; float:inherit; margin-top:10px;'>";
				if ($hal<=3){
					$blockhal=1;}
					else if ($hal==$jumlahhalaman-1 && $jumlahhalaman>5){
					$blockhal=$hal-3;}
					else if ($hal==$jumlahhalaman && $jumlahhalaman>5){
					$blockhal=$hal-4;}
					else {
					$blockhal=$hal-2;}
					
					
				if ($jumlahhalaman<=3){
					$itemblok=$jumlahhalaman;}
					else if ($hal==$jumlahhalaman-1){
					$itemblok=$hal+1;}
					else if ($hal==$jumlahhalaman){
					$itemblok=$hal;}
					else if ($jumlahhalaman==4){
					$itemblok=4;}
					else if ($hal <=3 && $jumlahhalaman>4){
					$itemblok=5;}
					else{
					$itemblok=$hal+2;}
					
				echo "<div class='paging'>";
				
				if ($hal>3){
					echo "<a href='".$_SERVER['HTTP_SERVER']."/design/admin/transaksi.php'>first</a>";}
					
				if ($jumlahhalaman>1){
					for ($i=$blockhal; $i<=$itemblok; $i++){
						echo "<a class='paging' href='".$_SERVER['HTTP_SERVER'].
						"/design/admin/transaksi.php?".$link."h=".$i."'>".$i."</a>";}
					}
						
				if ($jumlahhalaman>5 && $jumlahhalaman-2 > $hal){
					echo "<a href='".$_SERVER['HTTP_SERVER']."/design/admin/transaksi.php?".$link."h=".$jumlahhalaman."'>last</a>";}
							
				echo "</div></div>";	
//=====================================================================halaman
?>
</div>
</body>
</html>