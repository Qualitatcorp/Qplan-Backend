 
<!--  <div class="container" style="margin-left: 25px">
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
	</div> -->
 
</div>  
<?php

// function obtenerFicha(){
// 		foreach ($ot->fichas as $key => $value) {
// 	     // modulos($value->CrossTecnica);
// 	      //break;
// 		  $nombre = $value->trabajador->nombre . ' ' .$value->trabajador->paterno .' '.$value->trabajador->materno ;
		  
// 		  // foreach ($value->notas as $key => $x) {
// 		  // 	 if(is_array($x)){
// 		  // 	 	foreach ($x as $key => $y) {
// 		  // 	 	$nota[$key] = array('nota' => $y );	
// 		  // 	 	}
// 		  // 	 }else{
// 		  // 	 	$nota[$key] = array('nota' => $x );	
// 		  // 	 }
		  	
// 		  // }
// 		  // print_r($nota);
	

		
//         $trabajador[]  = array(
//         	'id' => $ot->id ,
//         	'nombre' => $nombre ,
//          	'rut' => $value->trabajador->rut  ,
//          	'edad' => $value->trabajador->edad  ,
//          	'nivel' => $value->trabajador->nivel  ,
//          	'personal' => $ot->personal ,
//          	'nombre' => $ot->especialidad->nombre ,
//          	'direccion' => $value->trabajador->direccion  ,
//          	'experiencia' => $value->trabajador->antiguedad  ,
//          	'nombre' => $ot->mandante->nombre  ,
//          	'empresa' => $ot->empresa->nombre  ,
//          	'certificacion' => $ot->termino ,
//         );
		


// 		return $trabajador;
	 
// 	}

// }

// var_dump(obtenerFicha());
function modulos($datos){
	foreach ($datos as $key => $modulos) {
	    echo  $modulos['modulo']->nombre;
	    
	    echo ' final ' .(($modulos['practica']['nota'] + $modulos['teorica']['nota'] ) /2);
	     
		
		 echo  ' <br>';
	}

}
 
?>