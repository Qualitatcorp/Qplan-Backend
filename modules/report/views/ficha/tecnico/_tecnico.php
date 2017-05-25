 
<?php 

$teoricas = arraynota($ficha->ficteoricas); //las notas de las fichas las guardamos en un array
$practicas = arraynota($ficha->ficpracticas);//las notas de las fichas las guardamos en un array
$x = 0;
$Ponderacion = null;
//test
$Ponderacion2 = null;
$promedioFinal = null;

foreach ( $ficha->fictercero as $key => $model) {
	$ponderacion =  $model->modulo->ponderacion;
	$key = $model->modulo->nombre;
	$nota =  $model->nota  * $ponderacion;
	$arrayNotasTabla[$key] = array('nota' => $nota, 'ponderacion' =>  $ponderacion ); 
}

$NotaTecnica = ( ($ficha->notas['teorica'] + $ficha->notas['practica']) /2);
$NotaCurricular = ($ficha->ficcurricular->nota * $ficha->ficcurricular->ponderacion);
$arrayNotasTabla['curricular'] =   array('nota' => $NotaCurricular, 'ponderacion' =>  $ficha->ficcurricular->ponderacion );
$arrayNotasTabla['tecnica']	   =   array('nota' => ($NotaTecnica ), 'ponderacion' =>  1 );



foreach ($arrayNotasTabla as $key => $v) {
    $Ponderacion2 += $v['ponderacion'];
    $promedioFinal +=  $v['nota'];
}  
echo nota($promedioFinal/$Ponderacion2);
 //test
foreach ($ficha->ot->modulos as $key => $value) {
	$teorica = null;
	$practica = null;
	$existeT = false;
	$existeP = false;
	$id = null;
	if((strpos($value['evaluacion'],  'TEORICA')!==false)  or  (strpos($value['evaluacion'],  'PRACTICA')!==false)){//se filtran los modulos
 	 	$id =  $value['id']; //tomamos el id del modulo
 	 	$Ponderacion =  $value['ponderacion'];  

 	 	if (isset($teoricas[$id])) { //si existe el valor en array
 	 	    $teorica = $teoricas[$id]*$Ponderacion;  //  nota teorica  del modulo correspondiente
 	 	  	$existeT = true;	//bandera
 	 	}
 	 	if (isset($practicas[$id])){
 	 	  	$practica = $practicas[$id]*$Ponderacion; 
 	 	  	$existeP = true;
 	 	}

 	 	if($existeP && $existeT){
 	 	  	$tecnica = ($practica  + $teorica) / 2;
 		}else if($existeP){
 	 	  	$tecnica = $practica;
 	 	}else if($existeT){
 	 	  	$tecnica = $teorica;
 	 	}
 	 	$notasArray[$id] = array('nombre'=> $value->nombre, 'teorica'=>$teorica, 'practica'=>  $practica, 'tecnica' => $tecnica);
 	 	//array que lista las notas
 	} 

}//fin foreach
 	 ?>
 	<div class="container">
 	 	<div class="row">
 	 		<div class="col-xs-7 "  > 
 	 			<table class="table table-striped col-xs-12    table-bordered"  style="font-size: 9px;">
 	 			<!-- tabla ot trabajador -->
 	 				<?php 
 	 				$nombreCompleto = $ficha->trabajador->nombre .' '.$ficha->trabajador->paterno . ' ' . $ficha->trabajador->materno;
 	 				$date = date_create($ficha->creacion);
 	 				$date = date_format($date, 'm-d-Y');
 	 				$arrayTr = array(  
 	 					array('medida'=>150,'nombre'=> 'Orden de Trabajo','contenido' =>  $ficha->ot->id),
 	 					array('medida'=>150,'nombre'=> 'Trabajador','contenido' => $nombreCompleto ),
 	 					array('medida'=>150,'nombre'=> 'Rut','contenido' =>  $ficha->trabajador->rut ),
 	 					array('medida'=>150,'nombre'=> 'Especialidad','contenido' =>  $ficha->ot->especialidad->nombre ),
 	 					array('medida'=>150,'nombre'=> 'EMP. Contratista','contenido' => $ficha->ot->mandante->nombre ),
 	 					array('medida'=>150,'nombre'=> 'Emp. Usuaria','contenido' => $ficha->ot->empresa->nombre ),
 	 					array('medida'=>150,'nombre'=> 'Fecha:','contenido' => $date)
 	 					);
 	 				echo contr_trtd($arrayTr);
 	 				?>
 	 			</table>
 	 		</div>

 	 		<div class="col-xs-12"  >
 	 			<table class="table table-striped col-xs-12    table-bordered"  style="font-size: 14px;"> 
 	 				<?php 
 	 				$arrayTr = array(
 	 					array('medida'=> 150, 'color' => '#CEE3F6', 'nombre' =>  'Nota Curricular'),
 	 					array('medida'=> 150, 'color' => '#CEE3F6', 'nombre' =>  'Nota Técnica'),
 	 					array('medida'=> 150, 'color' => '#CEE3F6', 'nombre' =>  'Nota Psicológica'),
 	 					array('medida'=> 150, 'color' => '#CEE3F6', 'nombre' =>  'Nota Seguridad '),
 	 					array('medida'=> 150, 'color' => '#CEE3F6', 'nombre' =>  'Nota Práctica '),
 	 					array('medida'=> 150, 'color' => '#CEE3F6', 'nombre' =>  'Nota final'),
 	 					array('medida'=> 150, 'color' => '#CEE3F6', 'nombre' =>  'Calificación '),
 	 					);
 	 				echo contr_trth($arrayTr);


 	 				if(isset($ficha->notas['teorica']) && isset($ficha->notas['practica'])){
 	 					$teorica = $ficha->notas['teorica'];
 	 					$practica =  $ficha->notas['practica'];
 	 					$nota_tecnica = nota([$practica,$teorica]);
 	 				}
 	 				$arrayTr = array(
 	 					array('medida'=> 150, 'color' => '#fff', 'nombre' =>  nota($ficha->notas['curricular'] ) ),
 	 					array('medida'=> 150, 'color' => '#fff', 'nombre' =>  $nota_tecnica),
 	 					array('medida'=> 150, 'color' => '#fff', 'nombre' =>  nota($ficha->notas['tercero']['Psicológico'])),
 	 					array('medida'=> 150, 'color' => '#fff', 'nombre' =>  nota($ficha->notas['tercero']['Seguridad']) ),
 	 					array('medida'=> 150, 'color' => '#fff', 'nombre' =>  nota($ficha->notas['practica']) ),
 	 					array('medida'=> 150, 'color' => '#fff', 'nombre' =>  nota($ficha->final) ),
 	 					array('medida'=> 150, 'color' => '#fff', 'nombre' =>  '---'),
 	 					);
 	 				echo contr_trth($arrayTr);
 	 				?>

 	 			</table>
 	 		</div>
 	 		<!-- detalles nota -->
 	 		<div class="col-xs-12" >
 	  	 		<table class="table table-striped col-xs-12    table-bordered"  style="font-size: 9px;">
 	 			<?php 
 	 				$arrayTr = array(
 	 					array('medida'=> 320, 'color' => '#CEE3F6', 'nombre' => "ITEM" ),
 	 					array('medida'=> 150, 'color' => '#CEE3F6', 'nombre' => "NOTA TEÓRICA" ),
 	 					array('medida'=> 150, 'color' => '#CEE3F6', 'nombre' => "NOTA PRÁCTICA" ),
 	 					array('medida'=> 150, 'color' => '#CEE3F6', 'nombre' => "NOTA FINAL" ),

 	 					);
 	 				echo contr_trth($arrayTr);
 	 			?>
 	 			</table>	
 	 			<?php 

 	 			foreach ($notasArray as $value) {
 				$x++;
 				echo  modulolista($x, $value);
 				
 				}
			?>


	</div>	
</div>

<?php  
//funciones de apoyo
function modulolista($x,$value){
 	$ancho = '20%';
 	//".nota($nota_teor)."
 	return "<table class=\"table table-striped col-xs-12    table-bordered\"  style=\"font-size: 9px; margin: 3 0 3 0 \">
 			<tr>
		 	<th   style='background-color: #CEE3F6; width: 300px; padding: 7 0 7 5;'  >
		 	{$x})	 {$value['nombre']}
		 	</th >
		 	<th  style='width: {$ancho};' class = \"text-center\">
		 		".nota($value['teorica'])."  
		 	</th >
		 	<th  style='width: {$ancho};'   class = \"text-center\">
		 		".nota($value['practica'])."  
		 	</th >
		 	<th  style='width: {$ancho};'   class = \"text-center\">
		 		".nota($value['tecnica'])."  
		 	</th > 
		 	</tr></table>";
			
}
// acepta un array y saca el promedio
//recibe un string y lo convierte a nota.
function nota($nota){
    if(!isset($nota)){
    	return '--';
    }
	if(is_array($nota) ){
		$promedio = 0;
		$n = count($nota);
		foreach ($nota as $value) {
			 $promedio += $value;
		}
		$nota = $promedio / $n;
	} 
	$nota = (round($nota * 6,1)+1);
	$nota = number_format($nota , 1, '.', '');
	return $nota;
}
function arraynota($notas){
	 
	 
	foreach ($notas as $key => $value) {
		$notasArray[$value->mod_id] = $value->nota;  	 
	}
	return $notasArray;
}
function  contr_trtd($datas){
	$res = '';
	if (is_array($datas)){
		foreach ($datas as $key => $data) {
			$res.="<tr><th   style=\"  background-color: #CEE3F6; width: ".$data['medida'] ."px; padding: 5px\"> ".$data['nombre']." :</th >
				<td style=\"padding: 5 0 0 15;\"> ".$data['contenido'] ."</td>
			</tr>";
		}	
	}
	return $res;
}
function  contr_trth($datas){
	$res = '';
	if (is_array($datas)){
		$res = '<tr>';
		foreach ($datas as $key => $data) {
			// $data['medida'] .$data['nombre'] $data['contenido']
			$res.="<th style=\"  background-color: ".$data['color']."; width: ".$data['medida']."px; padding: 5px\" class = \"text-center\">
		 				".$data['nombre']."
		 			</th > ";
		}	
		$res .= '</tr>';
	}
	return $res;
}

?>
