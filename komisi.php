<?php
require 'ceksesion.php';
require 'db.php';
if ($login!='true'){header('Location:login.php');}	
if ($s_pangkat!='affiliasi'){header('Location:profile.php');}				
//=====================================================================halaman
	$itemperpage=15;
	if (isset($_GET['h'])){
		$hal=$_GET['h'];
		$posisi=($hal-1)*$itemperpage;}
	else if (empty($_GET['h'])){
		$hal=1;
		$posisi=0;}
//=====================================================================halaman
$query=@mysql_query("SELECT id_komisi,id_transaksi,jenis,jumlah,status
			FROM komisi WHERE  jumlah > 0 AND id_referral= '$s_uid' ORDER BY id_transaksi DESC LIMIT $posisi,$itemperpage ");
//=====================================================================halaman
$jumlahdata=@mysql_num_rows(mysql_query("SELECT id_komisi FROM komisi WHERE  jumlah > 0 AND id_referral= '$s_uid'"));
$jumlahhalaman=ceil($jumlahdata/$itemperpage);
$jkomisi=@mysql_result(mysql_query("SELECT SUM(jumlah) FROM komisi WHERE jumlah > 0 AND status='valid' AND id_referral= '$s_uid'"),0,0);
//=====================================================================halaman	
?>
<html>
	<head>
		<title>
		Komisi
		</title>
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
		<div class="katag"><a href="profile.php">Profil </a></div> <div class="katag"><a href="user-transaksi.php">Transaksi</a></div>
			<?php 
			if ($s_pangkat == 'affiliasi'){
				echo "<div class='katag'>Komisi</div> ";
				echo "<div class='katag'><a href='req_payment.php'>Pembayaran Komisi</a></div>";}
			?>
		<hr>
		<table id="rounded-corner">
			<thead>
				<tr>
					<th >Jumlah komisi yang belum dibayar 
					<?php 
						echo "Rp ".number_format($jkomisi,0,',','.');
						if ($jkomisi >= 50000){
							echo " <a href='verifikasi.php?pengaturan=req_payment' class='katag' style='float:right;'> 
							Ajukan pembayaran komisi</a>";} 
					?>
					</th>
				</tr>
			</thead>
		</table><br>
		<table id="rounded-corner">
			<thead>
				<tr>
					<th >No Faktur</th>
					<th >Jenis Komisi</th>
					<th >Jumlah</th>
					<th >status</th>
				</tr>
			</thead>
				<tbody>
				<?php 
				while ($baris=@mysql_fetch_array($query)){
					echo "<tr>";
					echo "<td>".$baris[1]."</td>";	
					echo "<td >".$baris[2]."</td>";
					echo "<td >Rp ".number_format($baris[3],0,',','.')."</td>";
					echo "<td>".$baris[4]."</td>";
					echo "</tr>";}
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
							echo "<a href='".$_SERVER['HTTP_SERVER']."/design/komisi.php'>first</a>";}
							
						if ($jumlahhalaman>1){
							for ($i=$blockhal; $i<=$itemblok; $i++){
								echo "<a class='paging' href='".$_SERVER['HTTP_SERVER'].
								"/design/komisi.php?h=".$i."'>".$i."</a>";}
							}
								
						if ($jumlahhalaman>5 && $jumlahhalaman-2 > $hal){
							echo "<a href='".$_SERVER['HTTP_SERVER']."/design/komisi.php?h=".$jumlahhalaman."'>last</a>";}		
						echo "</div></div>";	
		//=====================================================================halaman
		?>
		</div>
		<?php include "footer.php"; ?>
	</body>
</html>
