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
	if ($opsi=='moderasi'){
		$query=@mysql_query("Select
							  komentar.komentar,
							  komentar.status,
							  barang.link,
							  barang.id_barang As id_barang1,
							  komentar.id_komentar,
							  komentar.tanggal,
							  komentar.id_user
							From
							  barang Inner Join
							  komentar On komentar.id_barang = barang.id_barang
							WHERE komentar.status = 'm'
							ORDER BY komentar.tanggal DESC LIMIT $posisi,$itemperpage ");
		$jumlahdata=@mysql_num_rows(mysql_query("SELECT komentar.id_komentar 
													From barang Inner Join komentar On komentar.id_barang = barang.id_barang
													WHERE komentar.status = 'm'"));}

	$link="c=".$opsi."&cari=".$cari."&";}

else{

		$query=@mysql_query("Select
							  komentar.komentar,
							  komentar.status,
							  barang.link,
							  barang.id_barang As id_barang1,
							  komentar.id_komentar,
							  komentar.tanggal,
							  komentar.id_user
							From
							  barang Inner Join
							  komentar On komentar.id_barang = barang.id_barang
							ORDER BY komentar.tanggal DESC LIMIT $posisi,$itemperpage ");
		$jumlahdata=@mysql_num_rows(mysql_query("SELECT komentar.id_komentar 
													From barang Inner Join komentar On komentar.id_barang = barang.id_barang"));} 
//=====================================================================halaman
$jumlahhalaman=ceil($jumlahdata/$itemperpage);
//=====================================================================halaman		
?>
<html>
<head>
	<?php require'a_head.php';?>
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
	<?php require 'a_top.php'; require 'a_menu.php';?>
<div class='isi'>
	<div style="float:left; width:auto; margin-bottom:15px;">
	<a class='createuser' href="komentar.php"> Semua </a>
	<a class='createuser' href="komentar.php?c=moderasi">Dalam moderasi</a>
	</div>
	<table id="rounded-corner">
		<thead>
			<tr>
				<th width="100">Tanggal</th>
				<th width="40">ID Barang</th>
				<th width="20">ID User</th>
				<th >komentar</th>
				<th width="40">status</th>
				<th align="center" width="40" colspan="2">opsi</th>
			</tr>
		</thead>
		<tbody>
			<?php						
			while ($baris =@mysql_fetch_array($query)){	
				echo "<tr>";
				echo "<td >".date("j F Y", strtotime($baris[5]))."</td>";
				echo "<td ><a href='../produk.php?idb=".$baris[3]."'>".$baris[3]."</a></td>";
				echo "<td ><a href='d-user.php?idu=".$baris[6]."'>".$baris[6]."</a></td>";		
				echo "<td >".$baris[0]."</td>";
				echo "<td align='center'>".$baris[1]."</td>";
				if ($baris[1]=='m'){
					echo "<td width='20'><a href='verifikasi.php?p=addcomment&idc=".$baris[4]."'>add</a></td>";}
				else {
					echo "<td width='20'>-</td>";}
				echo "<td width='20'><a class='konfirm' href='verifikasi.php?p=delcomment&idc=".$baris[4]."'>del</a></td>";
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
					echo "<a href='".$_SERVER['HTTP_SERVER']."/design/admin/komentar.php'>first</a>";}
					
				if ($jumlahhalaman>1){
					for ($i=$blockhal; $i<=$itemblok; $i++){
						echo "<a class='paging' href='".$_SERVER['HTTP_SERVER'].
						"/design/admin/komentar.php?".$link."h=".$i."'>".$i."</a>";}
					}
						
				if ($jumlahhalaman>5 && $jumlahhalaman-2 > $hal){
					echo "<a href='".$_SERVER['HTTP_SERVER']."/design/admin/komentar.php?".$link."h=".$jumlahhalaman."'>last</a>";}
							
				echo "</div></div>";	
//=====================================================================halaman
?>
</div>
</body>
</html>
