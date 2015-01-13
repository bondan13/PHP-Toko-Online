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
	if ($opsi=='req'){
		$query=@mysql_query("Select DISTINCT
							  komisi.id_referral,
							  bayar_komisi.id_bayar_k,
							  bayar_komisi.tgl_pengajuan,
							  bayar_komisi.jumlah,
							  bayar_komisi.status,
							  bayar_komisi.tgl_dibayar
							From
							  bayar_komisi Inner Join
							  komisi On bayar_komisi.id_bayar_k = komisi.id_bk
							WHERE bayar_komisi.status = 'diajukan'
							ORDER BY bayar_komisi.tgl_pengajuan DESC LIMIT $posisi,$itemperpage ");
			$jumlahdata=@mysql_num_rows(mysql_query("SELECT  id_bayar_k FROM bayar_komisi
			WHERE status = 'diajukan' "));}
	
	if ($opsi=='bayar'){
		$query=@mysql_query("Select DISTINCT
							  komisi.id_referral,
							  bayar_komisi.id_bayar_k,
							  bayar_komisi.tgl_pengajuan,
							  bayar_komisi.jumlah,
							  bayar_komisi.status,
							  bayar_komisi.tgl_dibayar
							From
							  bayar_komisi Inner Join
							  komisi On bayar_komisi.id_bayar_k = komisi.id_bk
							WHERE bayar_komisi.status = 'dibayar'
							ORDER BY bayar_komisi.tgl_pengajuan DESC LIMIT $posisi,$itemperpage ");
			$jumlahdata=@mysql_num_rows(mysql_query("SELECT  id_bayar_k FROM bayar_komisi
			WHERE status = 'dibayar' "));}
	
	if ($opsi=='batal'){
		$query=@mysql_query("Select DISTINCT
							  komisi.id_referral,
							  bayar_komisi.id_bayar_k,
							  bayar_komisi.tgl_pengajuan,
							  bayar_komisi.jumlah,
							  bayar_komisi.status,
							  bayar_komisi.tgl_dibayar
							From
							  bayar_komisi Inner Join
							  komisi On bayar_komisi.id_bayar_k = komisi.id_bk
							WHERE bayar_komisi.status = 'ditolak'
							ORDER BY bayar_komisi.tgl_pengajuan DESC LIMIT $posisi,$itemperpage ");
			$jumlahdata=@mysql_num_rows(mysql_query("SELECT  id_bayar_k FROM bayar_komisi
			WHERE status = 'ditolak' ")); }
			
	$link="c=".$opsi."&cari=".$cari."&";}

else{
	$query=@mysql_query("Select DISTINCT
							  komisi.id_referral,
							  bayar_komisi.id_bayar_k,
							  bayar_komisi.tgl_pengajuan,
							  bayar_komisi.jumlah,
							  bayar_komisi.status,
							  bayar_komisi.tgl_dibayar
							From
							  bayar_komisi Inner Join
							  komisi On bayar_komisi.id_bayar_k = komisi.id_bk
							  
							ORDER BY bayar_komisi.tgl_pengajuan DESC LIMIT $posisi,$itemperpage ");
	$jumlahdata=@mysql_num_rows(mysql_query("SELECT  id_bayar_k FROM bayar_komisi")); }
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
		<a class='createuser' href="payment.php"> Semua</a>
		<a class='createuser' href="payment.php?c=req"> Request</a>
		<a class='createuser' href="payment.php?c=bayar">Dibayar</a>
		<a class='createuser' href="payment.php?c=batal">Batal</a>
		</div>
		<table id="rounded-corner">
			<thead>
				<tr>
					<th width="120">Tgl Pengajuan</th>
					<th>ID User</th>
					<th width="100">Jumlah</th>
					<th width="80">Status</th>
					<th width="120">Tgl Dibayar</th>
					
	
				</tr>
			</thead>
			<tbody>
				<?php						
				while ($baris =@mysql_fetch_array($query)){	
					echo "<tr>";
					echo "<td >".date("j F Y", strtotime($baris[2]))."</td>";
					echo "<td ><a href='d-user.php?idu=".$baris[0]."'>".$baris[0]."</a></td>";
					echo "<td >Rp ".number_format($baris[3],0,',','.')."</td>";
					echo "<td >".$baris[4]."</td><td>";
					if ($baris[5]!=NULL){
						echo date("j F Y", strtotime($baris[5]));}
					echo "</td>";
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
						echo "<a href='".$_SERVER['HTTP_SERVER']."/design/admin/komisi.php?".$link."h=".
						$jumlahhalaman."'>last</a>";}
								
					echo "</div></div>";	
	//=====================================================================halaman
	?>
	</div>
	</body>
</html>
