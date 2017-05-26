<!-- 
<div class="container" style="margin-left: 25px">
	<div class="row">
		<br>
		<div class="col-xs-offset-8 col-xs-4" style="position: absolute; top: -50px">
			<img src="<?php  echo \Yii::$app->params['url_frontend'].'/img/logo.png'?>" alt="">
		</div>  
	</div>
	<div class="row">
	 
		<h4 class = "text-center  text-uppercase">
			RESULTADO INFORME TÉCNICO
		</h4>
	</div>
 
</div> -->
<?php
	foreach ($ot->fichas as $key => $value) {
	      modulos($value->CrossTecnica);
	// 	  $nombre = $value->trabajador->nombre . ' ' .$value->trabajador->paterno .' '.$value->trabajador->materno ;
		  
	// 	  foreach ($value->notas as $key => $x) {
	// 	  	 if(is_array($x)){
	// 	  	 	foreach ($x as $key => $y) {
	// 	  	 	$nota[$key] = array('nota' => $y );	
	// 	  	 	}
	// 	  	 }else{
	// 	  	 	$nota[$key] = array('nota' => $x );	
	// 	  	 }
		  	
	// 	  }
	// 	  print_r($nota);
	

	// echo '<pre>';
	//     echo  $ot->id . ' <br>' ;
	// 	echo  $nombre . '  <br>' ;
	// 	echo  $value->trabajador->id  . '  <br>' ;
	// 	echo  $value->trabajador->edad  . '  <br>' ;
	// 	echo  $value->trabajador->nivel  . '  <br>' ;
	// echo '</pre>';	 
	 
	}


function modulos($datos){
	foreach ($datos as $key => $modulos) {
		foreach ($modulos as $key => $modulo) {
			if($modulo){
				foreach ($modulo as $key => $m ) {
					 echo $key . " = " . $m; 
					 echo  ' <br>';
			    }
			     echo  ' <br>';
			}


		}
		break;

	}

}
 
?>