<html>
	<head>
		<script type="text/javascript" src="js/prototype.js"></script>
		<script type="text/javascript" src="js/scriptaculous.js?load=effects,builder"></script>
		<script type="text/javascript" src="js/lightbox.js"></script>
		<link rel="stylesheet" href="css/lightbox.css" type="text/css" media="screen" />
	</head>
	<body style="background-color: black;">
		<center>
		<table width="700">
			<?php
				$list = glob('photos/MEDIUM_*');
				for($i = 0; $i < count($list); $i++){
					$list[$i] = substr($list[$i], strpos($list[$i], 'MEDIUM_')+strlen('MEDIUM_'));
				}
				sort($list, SORT_NUMERIC);
				echo '<tr>';
				for($i = 0; $i < count($list); $i++){
					if(!($i%4)) echo '</tr><tr>';
					echo '<td><a href="photos/'.$list[$i].'" rel="lightbox[gallery]"><img border="0" src="photos/MEDIUM_'.$list[$i].'"></a></td>';
				}
				echo '</tr>';
			?>
		</table>
		</center>
	</body>
</html>
