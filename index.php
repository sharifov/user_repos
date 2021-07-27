<?
	$LIMIT = 10;
	$datas = require_once('repos');
	krsort($datas);
	array_splice($datas, $LIMIT);
?>
<center>
	<h2>Last Updated <?=$LIMIT?> Repos</h2>

	<div>
		<ul>
			<?foreach($datas as $data):?>
			
				<li><?=$data?> <br/><br/></li>
			
			<?endforeach?>
		</ul>
	</div>

</center>