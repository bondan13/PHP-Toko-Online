<?php
require 'ceksesion.php';
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
//=====================================================================halaman
if (isset($_GET['c'])){
	$opsi=$_GET['c'];
	$cari=$_GET['cari'];
	if ($opsi=='stok'){
		$query= @mysql_query("SELECT `id_barang`, `nm_barang`, `link`, `stok` FROM barang WHERE `publish` ='y' 
		AND `stok` = '$cari' Order by `id_barang` desc LIMIT $posisi,$itemperpage ");
		$jumlahdata=@mysql_num_rows(mysql_query("SELECT id_barang FROM barang WHERE `publish` ='y' AND `stok` = '$cari'"));}
		
	if($opsi=='nm'){
		$query= @mysql_query("SELECT `id_barang`, `nm_barang`, `link`, `stok` FROM barang WHERE `publish` ='y' 
		AND `nm_barang` LIKE '%$cari%' Order by `id_barang` desc LIMIT $posisi,$itemperpage ");
		$jumlahdata=@mysql_num_rows(mysql_query("SELECT id_barang FROM barang WHERE `publish` ='y' 
		AND `nm_barang` LIKE '%$cari%'"));}
		
	if($opsi=='del'){
		$query= @mysql_query("SELECT `id_barang`, `nm_barang`, `link`, `stok` FROM barang WHERE `publish` ='n'
		Order by `id_barang` desc LIMIT $posisi,$itemperpage ");
		$jumlahdata=@mysql_num_rows(mysql_query("SELECT id_barang FROM barang WHERE `publish` = 'n'"));}	
		
	$link="c=".$opsi."&cari=".$cari."&";
	}

else {
	$query= @mysql_query("SELECT `id_barang`, `nm_barang`, `link`, `stok` FROM barang WHERE `publish` ='y' Order by `id_barang` 
	desc LIMIT $posisi,$itemperpage ");

	$jumlahdata=@mysql_num_rows(mysql_query("SELECT id_barang FROM barang WHERE `publish` ='y'")); }	
	$jumlahhalaman=ceil($jumlahdata/$itemperpage);
//=====================================================================halaman	
?>
<html>
<head>
<?php require 'a_head.php'; ?>
<link rel="stylesheet" type="text/css" href="../tampilan/style-table.css">
<script>
	$( document ).ready(function() {
	$('.konfirm').on('click', function () {
			return confirm('Apakah anda ingin menghapus?');
		});
	});
</script>
</head>
<body>
<?php require 'a_top.php'; ?>
<?php require 'a_menu.php'; ?>
<div class="isi">
	<div style="float:left; width:auto; margin-bottom:15px;">
	<a class='createuser' href="tambahartikel.php"> Tambah Artikel</a>
	<a class='createuser' href="katagori.php"> Katagori</a>
	<a class='createuser' href="artikel.php?c=del"> Dihapus</a>
	</div>
	<div style="float:right; width:auto; border:1px solid #CCCCCC; height:24;">
	<form method="get" action="artikel.php">
		<select name="c" style="border:0px;">
		  <option value="nm">Nama </option>
		  <option value="stok">Stok</option>
		</select> 
		<input type="text" name="cari">
		<input type="submit" value="cari" />
	</form>
	</div>
	<table id="rounded-corner" summary="2007 Major IT Companies' Profit" style="margin-top:5px;">
		<thead>
			<tr>
				<th scope="col" class="rounded-company">Nama Barang</th>
				<th scope="col" class="rounded-q1" width="50">Stok</th>
				<th align="center" colspan="2" scope="col" class="rounded-q2" width="70">Pengaturan</th>
			</tr>
		</thead>
			<tbody>
					<?php 
				while ($baris=@mysql_fetch_array($query)){
					echo "<tr>";
					echo "<td><a class='table' href='../".$baris[2]."-".$baris[0].".html'>".$baris[1]."</a></td>";
					echo "<td>".$baris[3]."</td>";
					echo "<td width='20'><a class='table' href='editartikel.php?idb=".$baris[0]."'>
					<img src='../icon/edit.png'></a></td><td width='20'>";
					if ($opsi!='del'){
						echo "<a class='konfirm' href='hapus.php?idb=".$baris[0]."'>
						<img src='../icon/del.png'></a>";}
					echo "</td></tr>";}?>
					
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
					echo "<a href='".$_SERVER['HTTP_SERVER']."/design/admin/artikel.php'>first</a>";}
					
				if ($jumlahhalaman>1){
					for ($i=$blockhal; $i<=$itemblok; $i++){
						echo "<a class='paging' href='".$_SERVER['HTTP_SERVER'].
						"/design/admin/artikel.php?".$link."h=".$i."'>".$i."</a>";}
					}
						
				if ($jumlahhalaman>5 && $jumlahhalaman-2 > $hal){
					echo "<a href='".$_SERVER['HTTP_SERVER']."/design/admin/artikel.php?".$link."h=".$jumlahhalaman."'>last</a>";}
							
				echo "</div></div>";	
//=====================================================================halaman
?>
</div>
</body>
</html>

