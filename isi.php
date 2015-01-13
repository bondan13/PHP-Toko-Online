<div class="isi">
<?php 
$itemperpage=12;
if (isset($_GET['h'])){
	$hal=$_GET['h'];
	$posisi=($hal-1)*$itemperpage;
	}
else if (empty($_GET['h'])){
	$hal=1;
	$posisi=0;}

if (isset($_GET['katagori'])){
	$katagori=$_GET['katagori'];
	$lkatagori='katagori='.$katagori.'&';
	 	if(isset($_GET['sub'])){
			$sub=$_GET['sub'];
			$query=@mysql_query("SELECT
									barang.id_barang,
									barang.nm_barang,
									barang.link,
									barang.harga,
									barang.komisi,
									(Select 
										foto.foto_kecil 
									 From 
									 	foto 
									 WHERE 
									 	foto.id_barang = barang.id_barang 
									 LIMIT 
									 	1) 
									as foto 
								 FROM 
								 	barang
								 WHERE 
								 	barang.id_katagori='$sub' 
								 	AND barang.stok > 0 
									AND barang.publish = 'y' 
								 ORDER BY 
								 	id_barang desc 
								 LIMIT 
								 	$posisi,$itemperpage");
								 
			$jumlahdata=@mysql_num_rows(mysql_query("SELECT 
														id_barang 
													 FROM 
													 	barang 
													 WHERE 
														id_katagori='$sub'
														AND publish = 'y'
														AND stok > 0"));
			
			$query2=@mysql_query("SELECT 
									* 
								  FROM 
								  	katagori 
								  WHERE 
								  	katagori.id_katagori='$katagori' 
								  LIMIT 1");
			
			echo "<div class='katagoriatas'>";
			while ($baris2 =@mysql_fetch_array($query2)){  
			echo "<div class='katag'><a href='index.php?katagori=".$baris2[0]."'>".$baris2[2]."</a></div>";}		
			
			$query3=@mysql_query("select nama from katagori where katagori.id_katagori='$sub'
			ORDER BY katagori.id_katagori ASC limit 1");
			while ($baris3 =@mysql_fetch_array($query3)){  
			echo "<div class='katag'>".$baris3[0]."</div>";}	
			echo "</div>";
		}
		
		else {
			$query=@mysql_query("Select
			barang.id_barang,
			barang.nm_barang,
			barang.link,
			barang.harga,
			barang.komisi,
			(Select foto.foto_kecil From foto WHERE foto.id_barang = barang.id_barang LIMIT 1) as foto
			From barang Inner Join katagori On barang.id_katagori = katagori.id_katagori
			WHERE barang.stok > 0 AND barang.publish = 'y' AND 
			(katagori.id_kepala='$katagori' OR katagori.id_katagori='$katagori')  
			ORDER BY id_barang desc LIMIT $posisi,$itemperpage");
			$jumlahdata=@mysql_num_rows(mysql_query("Select
			barang.id_barang From barang Inner Join katagori On barang.id_katagori = katagori.id_katagori
			WHERE barang.stok > 0 AND barang.publish = 'y' AND 
			(katagori.id_kepala='$katagori' OR katagori.id_katagori='$katagori')"));
			
			$query2=@mysql_query("select * from katagori where katagori.id_katagori='$katagori'");
			echo "<div class='katagoriatas'>";
			while ($baris2 =@mysql_fetch_array($query2)){ 
				$query3=@mysql_query("select * from katagori where katagori.id_kepala='$katagori'");
				while ($baris3 =@mysql_fetch_array($query3)){  
				echo "<div class='katag'><a href='index.php?katagori=".$baris2[0]."&sub=".$baris3[0]."'>".$baris3[2]."</a></div>";}
				}
			echo "</div>";}
		}

else if (isset($_GET['cari'])){	
	$cari=$_GET['cari'];
	$query=@mysql_query("Select
  		barang.id_barang,
 		barang.nm_barang,
		barang.link,
		barang.harga,
		barang.komisi,
  		(Select foto.foto_kecil From foto WHERE foto.id_barang = barang.id_barang LIMIT 1) as foto 
		From barang 
		WHERE barang.stok >0 
		AND barang.publish = 'y' 
		AND barang.nm_barang LIKE '%$cari%' 
		ORDER BY id_barang desc LIMIT $posisi,$itemperpage");
	$jumlahdata=@mysql_num_rows(mysql_query("select * from barang WHERE barang.stok >0 
		AND barang.publish = 'y' AND barang.nm_barang LIKE '%$cari%'"));
	$lkatagori='cari='.$cari.'&';}
	
else {	
	$query=@mysql_query("Select
  		barang.id_barang,
 		barang.nm_barang,
		barang.link,
		barang.harga,
		barang.komisi,
  		(Select foto.foto_kecil From foto WHERE foto.id_barang = barang.id_barang LIMIT 1) 
		as foto From barang WHERE barang.stok >0 AND barang.publish = 'y'  ORDER BY id_barang desc LIMIT $posisi,$itemperpage");
	$jumlahdata=@mysql_num_rows(mysql_query("select * from barang WHERE stok >0 AND publish = 'y'"));
	$lkatagori='';}

$jumlahhalaman=ceil($jumlahdata/$itemperpage);

?>
	<div class="box">
		<?php
			while ($baris =@mysql_fetch_array($query)){
			if ($s_pangkat=='affiliasi'){
				echo "<div class='img' title='Komisi Rp. ".number_format($baris[4],0,',','.')."'>";}
			else{
				echo "<div class='img'>";}  
			echo "<a href='../design/".$baris[2]."-".$baris[0].".html' ><img src='gambar/".$baris[5]."'></a>";
			echo "<div class='desc'><a href='../design/".$baris[2]."-".$baris[0].".html'>".substr($baris[1], 0, 35)."
			</a></div><div class='harga'>Rp " . number_format($baris[3],0,',','.')."</div>";
			if (isset($aff)){
				echo"<div style='background:#3399ff; color:#ffffff;'>K " . number_format($baris[4],0,',','.')."</div>";}
			echo "</div>";
			}
		
		?>
	</div>
<div align="center" style="width:100%; float:inherit">
	<?php
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
			echo "<a href=$_SERVER[PHP_SELF]?".$lkatagori."h=1>first</a>";}
			
		if ($jumlahhalaman>1){
			for ($i=$blockhal; $i<=$itemblok; $i++){
				echo "<a class='paging'  href=$_SERVER[PHP_SELF]?".$lkatagori."h=".$i.">".$i."</a>";}}
				
		if ($jumlahhalaman>5 && $jumlahhalaman-2 > $hal){
			echo "<a href=$_SERVER[PHP_SELF]?".$lkatagori."h=".$jumlahhalaman.">last</a>";}	
			
	echo "</div>";
	?>

	<script>
		$(function() {
			$( ".katag" ).button();
		});
		
		$(function() {
		$( document ).tooltip();
		});
	</script>
	</div>
</div>

<?php include "footer.php"; ?>