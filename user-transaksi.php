<?php
require 'ceksesion.php';
require 'db.php';
if ($login!='true'){header('Location:login.php');}	
//=====================================================================halaman
	$itemperpage=15;
	if (isset($_GET['h'])){
		$hal=$_GET['h'];
		$posisi=($hal-1)*$itemperpage;}
	else if (empty($_GET['h'])){
		$hal=1;
		$posisi=0;}
//=====================================================================halaman
$query=@mysql_query("Select transaksi.id_transaksi, transaksi.tanggal, barang.nm_barang, transaksi.status, transaksi.jumlah
					From
					barang Inner Join transaksi On transaksi.id_barang = barang.id_barang WHERE id_user='$s_uid' ORDER BY 		            		transaksi.tanggal desc LIMIT $posisi,$itemperpage");
//=====================================================================halaman
$jumlahdata=@mysql_num_rows(mysql_query("SELECT id_transaksi FROM transaksi WHERE id_user='$s_uid'")); 
$jumlahhalaman=ceil($jumlahdata/$itemperpage);
//=====================================================================halaman	
?>
<html>
	<head>
	<?php require'head.php'; ?>
	<link rel="stylesheet" type="text/css" href="tampilan/style-table.css">
	<script>
		$(function() {
		$( ".katag" ).button();
		});
	</script>
	</head>
	<body>
		<?php 
		require 'top.php';
		require 'menu.php'; 
		?> 
		<div class="isi">
		<div class="katag"><a href="profile.php">Profil </a></div> <div class="katag">Transaksi</div>
			<?php 
			if ($s_pangkat == 'affiliasi'){
				echo "<div class='katag'><a href='komisi.php'>Komisi</a></div> ";
				echo "<div class='katag'><a href='req_payment.php'>Pembayaran Komisi</a></div>";}
			?>
		<hr>
		<table id="rounded-corner" summary="2007 Major IT Companies' Profit">
			<thead>
				<tr>
					<th scope="col" class="rounded-company" width="100">Tanggal</th>
					<th scope="col" class="rounded-q1" width="100">ID Transaksi</th>
					<th scope="col" class="rounded-q2">Barang</th>
					<th scope="col" class="rounded-q3" width="100">Jumlah</th>
					<th scope="col" class="rounded-q4" width="100">Status</th>
				</tr>
			</thead>
				<tbody>
		<?php while ($baris=@mysql_fetch_array($query)){
				echo "<tr>";
					echo "<td><a class='table' href='pembelian.php?
					idt=".$baris[0]."'>".date("j F Y", strtotime($baris[1]))."</a></td>";
					echo "<td><a class='table' href='pembelian.php?idt=".$baris[0]."'>".$baris[0]."</a></td>";
					echo "<td><a class='table' href='pembelian.php?idt=".$baris[0]."'>".substr($baris[2], 0, 45)."</a></td>";
					echo "<td><a class='table' href='pembelian.php?idt=".$baris[0]."'>".$baris[4]."</a></td>";
					echo "<td><a class='table' href='pembelian.php?idt=".$baris[0]."'>".$baris[3]."</a></td>";
				echo "</tr>";
		}?>
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
							echo "<a href='".$_SERVER['HTTP_SERVER']."/design/user-transaksi.php'>first</a>";}
							
						if ($jumlahhalaman>1){
							for ($i=$blockhal; $i<=$itemblok; $i++){
								echo "<a class='paging' href='".$_SERVER['HTTP_SERVER'].
								"/design/user-transaksi.php?h=".$i."'>".$i."</a>";}
							}
								
						if ($jumlahhalaman>5 && $jumlahhalaman-2 > $hal){
							echo "<a href='".$_SERVER['HTTP_SERVER']."/design/user-transaksi.php?h=".$jumlahhalaman."'>last</a>";}		
						echo "</div></div>";	
		//=====================================================================halaman
		?>
		</div>
		<?php include "footer.php"; ?>
	</body>
</html>