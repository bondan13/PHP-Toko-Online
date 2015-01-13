<?php
require 'ceksesion.php';
if ($login==true){
	require 'db.php';
	$a=$_GET['term'];
	$query=@mysql_query("SELECT * FROM `kota` WHERE `nama` LIKE '%$a%' ");
		while ($hasil=@mysql_fetch_assoc($query)){
		$arr[]=array( 'id'=>$hasil['id_wilayah'], 'value'=>$hasil['nama']);}
	echo json_encode($arr);
	}
else {header ("location:index.php"); }
?>