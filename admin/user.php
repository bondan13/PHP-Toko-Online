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
	if ($opsi=='affiliasi'){
		$query=@mysql_query("SELECT id_user,notelp,nama,pangkat FROM user
					WHERE pangkat = 'affiliasi'
			  		ORDER BY nama DESC LIMIT $posisi,$itemperpage ");
		$jumlahdata=@mysql_num_rows(mysql_query("SELECT id_user FROM user WHERE pangkat = 'affiliasi'"));} 
		
	if ($opsi=='nonaktif'){
		$query=@mysql_query("SELECT id_user,notelp,nama,pangkat FROM user
					WHERE pangkat = 'non aktif'
			  		ORDER BY nama DESC LIMIT $posisi,$itemperpage ");
		$jumlahdata=@mysql_num_rows(mysql_query("SELECT id_user FROM user WHERE pangkat = 'non aktif'"));} 

	if ($opsi=='nm'){
		$query=@mysql_query("SELECT id_user,notelp,nama,pangkat FROM user
					WHERE nama LIKE '%$cari%'
			  		ORDER BY nama DESC LIMIT $posisi,$itemperpage ");
		$jumlahdata=@mysql_num_rows(mysql_query("SELECT id_user FROM user WHERE nama LIKE '%$cari%'"));}  
		
	if ($opsi=='nt'){
		$query=@mysql_query("SELECT id_user,notelp,nama,pangkat FROM user
					WHERE notelp LIKE '%$cari%'
			  		ORDER BY nama DESC LIMIT $posisi,$itemperpage ");
		$jumlahdata=@mysql_num_rows(mysql_query("SELECT id_user FROM user WHERE notelp LIKE '%$cari%'"));} 
		
	$link="c=".$opsi."&cari=".$cari."&";
	}
	
else{
		$query=@mysql_query("SELECT id_user,notelp,nama,pangkat FROM user
			  		ORDER BY nama DESC LIMIT $posisi,$itemperpage ");
		$jumlahdata=@mysql_num_rows(mysql_query("SELECT id_user FROM user"));} 
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
	<a class='createuser' href="user.php"> Semua</a>
	<a class='createuser' href="user.php?c=affiliasi"> Affiliasi</a>
	<a class='createuser' href="user.php?c=nonaktif"> Non Aktif</a>
	</div>
	<div style="float:right; width:auto; border:1px solid #CCCCCC; height:24;">
	<form method="get" action="user.php">
	<select name="c" style="border:0px;">
	  	<option value="nm">Nama</option>
	 	<option value="nt">Notelp</option>
	</select> 
	<input type="text" name="cari"/><input type="submit" value="cari" />
	</form>
	</div>
	<table id="rounded-corner">
		<thead>
			<tr>
				<th >Nama</th>
				<th width="100">No telp</th>
				<th width="80">Pangkat</th>
			</tr>
		</thead>
		<tbody>
			<?php						
			while ($baris =@mysql_fetch_array($query)){	
				echo "<tr>";			
				echo "<td><a href='../admin/d-user.php?idu=".$baris[0]."'>".$baris[2]."</a></td>";
				echo "<td >".$baris[1]."</td>";
				echo "<td >".$baris[3]."</td>";
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
					echo "<a href='".$_SERVER['HTTP_SERVER']."/design/admin/user.php'>first</a>";}
					
				if ($jumlahhalaman>1){
					for ($i=$blockhal; $i<=$itemblok; $i++){
						echo "<a class='paging' href='".$_SERVER['HTTP_SERVER'].
						"/design/admin/user.php?".$link."h=".$i."'>".$i."</a>";}
					}
						
				if ($jumlahhalaman>5 && $jumlahhalaman-2 > $hal){
					echo "<a href='".$_SERVER['HTTP_SERVER']."/design/admin/user.php?".$link."h=".$jumlahhalaman."'>last</a>";}
							
				echo "</div></div>";	
//=====================================================================halaman
?>
</div>
</body>
</html>
