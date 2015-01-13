<div class="menu">
	<ul id="menu">		
		<?php
		$query1= @mysql_query('select * from katagori where id_kepala IS NULL ORDER BY `nama` ASC');
		while ($baris =@mysql_fetch_array($query1)){	
			echo "<li><a href='index.php?katagori=".$baris[0]."'>".$baris[2]."</a></li>";}
		?>
	</ul>
</div>