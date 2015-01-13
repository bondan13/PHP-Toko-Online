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
	if ($opsi=='valid'){
		$query=@mysql_query("SELECT komisi.id_transaksi,komisi.jenis,komisi.id_referral,komisi.jumlah,
					user.nama,user.notelp,komisi.status
					FROM komisi Inner Join user On komisi.id_referral = user.id_user 
					WHERE komisi.status = 'valid' AND komisi.jumlah > 0
			  		ORDER BY komisi.id_transaksi DESC LIMIT $posisi,$itemperpage ");
		$jumlahdata=@mysql_num_rows(mysql_query("SELECT id_komisi FROM komisi 
		WHERE komisi.status = 'valid' AND komisi.jumlah > 0")); }
	
	if ($opsi=='bayar'){
		$query=@mysql_query("SELECT komisi.id_transaksi,komisi.jenis,komisi.id_referral,komisi.jumlah,
					user.nama,user.notelp,komisi.status
					FROM komisi Inner Join user On komisi.id_referral = user.id_user 
					WHERE komisi.status = 'dibayar' AND komisi.jumlah > 0
			  		ORDER BY komisi.id_transaksi DESC LIMIT $posisi,$itemperpage ");
		$jumlahdata=@mysql_num_rows(mysql_query("SELECT id_komisi FROM komisi 
		WHERE komisi.status = 'dibayar' AND komisi.jumlah > 0")); }
	
	if ($opsi=='hapus'){
		$query=@mysql_query("SELECT komisi.id_transaksi,komisi.jenis,komisi.id_referral,komisi.jumlah,
					user.nama,user.notelp,komisi.status
					FROM komisi Inner Join user On komisi.id_referral = user.id_user 
					WHERE komisi.status = 'tidak valid' AND komisi.jumlah > 0
			  		ORDER BY komisi.id_transaksi DESC LIMIT $posisi,$itemperpage ");
		$jumlahdata=@mysql_num_rows(mysql_query("SELECT id_komisi FROM komisi 
		WHERE komisi.status = 'tidak valid' AND komisi.jumlah > 0")); }
	
	if ($opsi=='nf'){
		$query=@mysql_query("SELECT komisi.id_transaksi,komisi.jenis,komisi.id_referral,komisi.jumlah,
					user.nama,user.notelp,komisi.status
					FROM komisi Inner Join user On komisi.id_referral = user.id_user 
					WHERE komisi.id_transaksi LIKE '%$cari%' AND komisi.jumlah > 0
			  		ORDER BY komisi.id_transaksi DESC LIMIT $posisi,$itemperpage ");
		$jumlahdata=@mysql_num_rows(mysql_query("SELECT id_komisi FROM komisi 
		WHERE id_transaksi LIKE '%$cari%' AND komisi.jumlah > 0")); }
	
	if ($opsi=='nm'){
		$query=@mysql_query("SELECT komisi.id_transaksi,komisi.jenis,komisi.id_referral,komisi.jumlah,
					user.nama,user.notelp,komisi.status
					FROM komisi Inner Join user On komisi.id_referral = user.id_user 
					WHERE user.nama LIKE '%$cari%' AND komisi.jumlah > 0
			  		ORDER BY komisi.id_transaksi DESC LIMIT $posisi,$itemperpage ");
		$jumlahdata=@mysql_num_rows(mysql_query("SELECT id_komisi FROM komisi Inner Join user On komisi.id_referral = user.id_user
		WHERE user.nama LIKE '%$cari%' AND komisi.jumlah > 0")); }
	
	if ($opsi=='nt'){
		$query=@mysql_query("SELECT komisi.id_transaksi,komisi.jenis,komisi.id_referral,komisi.jumlah,
					user.nama,user.notelp,komisi.status
					FROM komisi Inner Join user On komisi.id_referral = user.id_user 
					WHERE user.notelp LIKE '%$cari%' AND komisi.jumlah > 0
			  		ORDER BY komisi.id_transaksi DESC LIMIT $posisi,$itemperpage ");
		$jumlahdata=@mysql_num_rows(mysql_query("SELECT id_komisi FROM komisi Inner Join user On komisi.id_referral = user.id_user
		WHERE user.notelp LIKE '%$cari%' AND komisi.jumlah > 0"));}
	$link="c=".$opsi."&cari=".$cari."&";}

else{

		$query=@mysql_query("SELECT komisi.id_transaksi,komisi.jenis,komisi.id_referral,komisi.jumlah,
					user.nama,user.notelp,komisi.status
					FROM komisi Inner Join user On komisi.id_referral = user.id_user 
					WHERE  komisi.jumlah > 0
			  		ORDER BY komisi.id_transaksi DESC LIMIT $posisi,$itemperpage ");
		$jumlahdata=@mysql_num_rows(mysql_query("SELECT id_komisi FROM komisi WHERE  komisi.jumlah > 0"));} 
//=====================================================================halaman
$jumlahhalaman=ceil($jumlahdata/$itemperpage);
//=====================================================================halaman		
?>
<html>
<head>
	<?php require'a_head.php';?>
	<link rel="stylesheet" type="text/css" href="../tampilan/style-table.css">
</head>
<body>
	<?php require 'a_top.php'; require 'a_menu.php';?>
<div class='isi'>
	<div style="float:left; width:auto; margin-bottom:15px;">
	<a class='createuser' href="komisi.php"> Semua</a>
	<a class='createuser' href="komisi.php?c=valid"> Valid</a>
	<a class='createuser' href="komisi.php?c=bayar">Dibayar</a>
	<a class='createuser' href="komisi.php?c=hapus">Dihapus</a>
	</div>
	<div style="float:right; width:auto; border:1px solid #CCCCCC; height:24;">
	<form method="get" action="komisi.php">
	<select name="c" style="border:0px;">
	  	<option value="nf">No Faktur</option>
	 	<option value="nm">Nama</option>
		<option value="nt">No Telp</option>
	</select> 
	<input type="text" name="cari"/><input type="submit" value="cari" />
	</form>
	</div>
	<table id="rounded-corner">
		<thead>
			<tr>
				<th width="80">No Faktur</th>
				<th width="50">Id User</th>
				<th >Nama</th>
				<th width="100">No telp</th>
				<th width="80">Jenis Komisi</th>
				<th width="100">Jumlah</th>
				<th width="70">Status</th>

			</tr>
		</thead>
		<tbody>
			<?php						
			while ($baris =@mysql_fetch_array($query)){	
				echo "<tr>";
				echo "<td><a href='../admin/dtransaksi.php?idt=".$baris[0]."'>".$baris[0]."</a></td>";
				echo "<td><a href='../admin/d-user.php?idu=".$baris[2]."'>".$baris[2]."</a></td>";
				echo "<td><a href='../admin/d-user.php?idu=".$baris[2]."'>".$baris[4]."</a></td>";		
				echo "<td >".$baris[5]."</td>";
				echo "<td >".$baris[1]."</td>";
				echo "<td >Rp ".number_format($baris[3],0,',','.')."</td>";
				echo "<td >".$baris[6]."</td>";
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
					echo "<a href='".$_SERVER['HTTP_SERVER']."/design/admin/komisi.php'>first</a>";}
					
				if ($jumlahhalaman>1){
					for ($i=$blockhal; $i<=$itemblok; $i++){
						echo "<a class='paging' href='".$_SERVER['HTTP_SERVER'].
						"/design/admin/komisi.php?".$link."h=".$i."'>".$i."</a>";}
					}
						
				if ($jumlahhalaman>5 && $jumlahhalaman-2 > $hal){
					echo "<a href='".$_SERVER['HTTP_SERVER']."/design/admin/komisi.php?".$link."h=".$jumlahhalaman."'>last</a>";}
							
				echo "</div></div>";	
//=====================================================================halaman
?>
</div>
</body>
</html>
