<?php
require "ceksesion.php";
include 'db.php';
$query1= mysql_query("select * from katagori where id_kepala IS NULL");
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
<?php 
require 'a_top.php'; 
require 'a_menu.php';
?>


<div class="isi">
	<div style="float:left; width:auto; margin-bottom:15px;">
	<a class='createuser' href="tambahartikel.php"> Tambah Artikel</a>
	<a class='createuser' href="katagori.php"> Katagori</a>
	<a class='createuser' href="artikel.php?c=del"> Dihapus</a>
	</div>
<table id="rounded-corner">
		<thead>
			<tr>
				<th scope="col" class="rounded-company" width="150">Katagori</th>
				<th scope="col" class="rounded-company" width="150">Pengaturan</th>
				<th scope="col" class="rounded-q1"width="150">Sub Katagori</th>
				<th scope="col" class="rounded-company"width="150">Pengaturan</th>
			</tr>
		</thead>
		<tbody>
			<tr>
		<?php
		while ($baris =mysql_fetch_array($query1)){	
				$query2= mysql_query("SELECT * FROM `katagori` where id_kepala='$baris[0]'");
				$jumlahsub=mysql_num_rows($query2);
				if ($baris[0]==21){
					echo "<td rowspan='".$jumlahsub."'>".$baris[2]."</td><td></td>";}
				else{
					echo "<td rowspan='".$jumlahsub."'>".$baris[2]."</td>";
					echo "<td rowspan='".$jumlahsub."'>
					<a href='hapus.php?idkat=".$baris[0]."' class='konfirm'>
					<img src='../icon/del.png' /></a></td>";}
				if ($jumlahsub >0){
					while ($baris2 =mysql_fetch_array($query2)){
						echo "<td>".$baris2[2]."</td>";
						echo "<td> <a href='hapus.php?idsubkat=".$baris2[0]."' class='konfirm'>
						<img src='../icon/del.png' /></a></td></tr><tr>";}
				}
				else { echo "<td>&nbsp;</td><td>&nbsp;</td></tr><tr>";}
				}
		?>
 			</tr>		
		</tbody>
	</table>	
<br><br>
<table id="rounded-corner">
		<thead>
			<tr>
				<th colspan="2" width="150">Penambahan Katagori</th>

			</tr>
		</thead>		
		<tr>
			<td width="320">
				<form method="post" action="submit.php">
				Katagori <br />
				<input type="text" name="katagori" /><br />
				<input type="submit" value="simpan"  size="7"/><br /><br />
				</form>
			</td>
			<td>
				<form method="post" action="submit.php">
				Sub Katagori <br />
				<select name="id_katagori">
				
				<?php 
				$query1= mysql_query('select * from katagori where id_kepala IS NULL');
				while ($baris =mysql_fetch_array($query1)){
				echo "<option value=".$baris[0].">".$baris[2]."</option>";}
				?>
				
				<input type="text" name="subkatagori" /><br />
				<input type="submit" value="simpan" size="7" />
				</form>
			</td>
		</tr>
	</table>

</div>
</body>
</html>
