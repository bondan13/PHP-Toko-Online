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

		$query=@mysql_query("SELECT req_pass.id_req_pass, req_pass.password, user.id_user, user.notelp
		FROM req_pass Inner Join user 
		On req_pass.id_user = user.id_user LIMIT $posisi,$itemperpage ");
		$jumlahdata=@mysql_num_rows(mysql_query("SELECT id_user FROM user"));
//=====================================================================halaman
$jumlahhalaman=ceil($jumlahdata/$itemperpage);
//=====================================================================halaman		
?>
<html>
	<head>
		<title>
		Lupa Password
		</title>
		<?php require'a_head.php';?>
		<link rel="stylesheet" type="text/css" href="../tampilan/style-table.css">
	</head>
	<body>
		<?php require 'a_top.php'; require 'a_menu.php';?>
	<div class='isi'>
		<div style="float:left; width:auto; margin-bottom:15px;">
		<a class='createuser' href="req_pass.php"> Request Password</a>
		</div>
		<table id="rounded-corner">
			<thead>
				<tr>
					<th width="100">Notelp</th>
					<th width="200">Password</th>
					<th >Pengaturan</th>
				</tr>
			</thead>
			<tbody>
				<?php						
				while ($baris =@mysql_fetch_array($query)){	
					echo "<tr>";			
					echo "<td>".$baris[3]."</td>";
					echo "<td>".$baris[1]."</td>";
					echo "<td><a href='verifikasi.php?idp=".$baris[0]."&p=reqpass&opsi=del'>hapus</a></td>";
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
