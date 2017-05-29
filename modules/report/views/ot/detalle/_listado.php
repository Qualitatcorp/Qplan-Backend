<?php 

foreach ($ot->fichas as $key => $ficha) {
  // pre($ficha->trabajador);
	pre($ficha->CrossTecnica,1);
}
die();
function pre($data,$f=null){
	echo '<pre>';
	if($f === null){
		var_dump($data);
	}else{
		print_r($data);
	}
	echo '</pre>';

}
?>