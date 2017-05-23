<?php 
use app\modules\v1\models\FichaPractica;
use app\modules\v1\models\FichaTeorico;
$contador = 0;
$limitePrimeraHoja= 16;

// echo '<pre>';
// foreach ($ficha->modulos as $key => $value) {
// 	  $value->id;
// 	  print_r($FichaPractica = FichaPractica::find()->where(['id'=>1])->one());
// }

// echo '</pre>';
// exit;
 
			
                	foreach ($ficha->modulos as $modulo) {
                		$id = $modulo->id;
                 		$FichaPractica = FichaPractica::find()->where(['mod_id'=> $id])->one();
	            		$FichaTeorica = FichaTeorico::find()->where(['mod_id'=> $id])->one();

               			
                	}
                exit;
                die();
?>
<div class="container">
	<div class="row">
	<!-- col-xs-offset-5 Datos del trabajador -->
		<div class="col-xs-7 "  > 
	   	 	<table class="table table-striped col-xs-12    table-bordered"  style="font-size: 9px;">
	 		  
	 			<tr>
		 			<th   style="  background-color: #CEE3F6; width: 150px; padding: 5px"> Orden de Trabajo:</th >
					<td style="padding: 5 0 0 15;"> <?php echo $ficha->ot->id ?></td>
				</tr>
			 
			    <tr>
			    	<th style="background-color: #CEE3F6; padding: 5px   "> Trabajador:</th>
			    	<td style="padding: 5 0 0 15; "><?php echo $ficha->trabajador->nombre ?></td>
			    </tr>
			   
		        <tr>
			    	<th style="background-color: #CEE3F6;  padding: 5px  ">Rut:</th>
			    	<td style="padding: 5 0 0 15; "><?php echo $ficha->trabajador->rut ?></td>
			    </tr>

		        <tr>
			    	<th style="background-color: #CEE3F6;  padding: 5px  ">Especialidad:</th>
			    	<td style="padding: 5 0 0 15; "><?php echo $ficha->ot->especialidad->nombre ?></td>
			    </tr>
   				<tr>
			    <th style="background-color: #CEE3F6; padding: 5px "  > EMP. Contratista: </th>
			    	<td style="padding: 5 0 0 15; ">   <?php  echo $ficha->ot->mandante->nombre;?> </td>
				</tr>
				<tr>
				<th style="background-color: #CEE3F6; padding: 5px ">Emp. Usuaria::</th>
				<td style="padding: 5 0 0 15; "><?php  echo $ficha->ot->empresa->nombre;?> </td>
				</tr>
				<tr>
					<th style="background-color: #CEE3F6; padding: 5px ">Fecha:</th>
					<td style="padding: 5 0 0 15; "><?php 
					 $date = date_create($ficha->creacion);
					 echo date_format($date, 'm-d-Y');
					 ?> </td>
				</tr>

			</table>
		</div>
	  

		<!-- cabecera de notas finales -->
		<div class="col-xs-12"  >
			<table class="table table-striped col-xs-12    table-bordered"  style="font-size: 14px;">
			 		  
	 			<tr>
		 			<th   style="  background-color: #CEE3F6; width: 150px; padding: 5px" class = "text-center">
		 				Nota Curricular
		 			</th >
					<th   style="  background-color: #CEE3F6; width: 150px; padding: 5px" class = "text-center"> 
						Nota Técnica
					</th >
					<th   style="  background-color: #CEE3F6; width: 150px; padding: 5px" class = "text-center"> 
						Nota Psicológica
					</th >
					<th   style="  background-color: #CEE3F6; width: 150px; padding: 5px" class = "text-center"> 
						Nota Seguridad 
					</th >
					<th   style="  background-color: #CEE3F6; width: 150px; padding: 5px" class = "text-center"> 
						Nota Usuaria
					</th >
					<th   style="  background-color: #CEE3F6; width: 150px; padding: 5px" class = "text-center"> 
						Nota Práctica
					</th >
					<th   style="  background-color: #CEE3F6; width: 150px; padding: 5px" class = "text-center"> 
						Nota Final 
					</th >

					<th   style="  background-color: #CEE3F6; width: 150px; padding: 5px" class = "text-center"> 
						Calificación 
					</th >

				</tr>
			 
			    <tr>
			    <!-- notas finales -->
		 			<th   style="padding:10px; " class = "text-center">
		 			<!-- curricular --> 
		 			<?php echo nota($ficha->notas['curricular'])?>
		 				 
		 			</th >
		 			<th   style="padding:10px; " class = "text-center">
		 			<!-- tecnica teorica y practica --> 
		 			<?php 
		 			$teorica = $ficha->notas['teorica'];
		 			$practica =  $ficha->notas['practica'];
		 			echo (nota([$practica,$teorica]) )?>
		 				 
		 			</th >
		 			<th   style="padding:10px; " class = "text-center">
		 			<!-- psicologico -->
		 			<?php echo nota($ficha->notas['tercero']['Psicológico']) ?>
		 				 
		 			</th >
		 			<th   style="padding:10px; " class = "text-center">
		 			<!-- nota de seguridad -->
		 			<?php echo nota($ficha->notas['tercero']['Seguridad']) ?> 
		 				 
		 			</th >
		 			<th   style="padding:10px; " class = "text-center">
		 			--
		 			<!-- nota usuaria -->
		 			<?php  ?>
		 				 
		 			</th >
		 			<th   style="padding:10px; " class = "text-center">
		 			<!-- nota practica -->
		 			<?php echo nota($ficha->notas['practica']) ?>
		 				 
		 			</th >
		 			<th   style="padding:10px; " class = "text-center">
		 			<!-- nota final -->
		 			<?php   ?>
		 			--
		 			</th >
		 			<th   style="padding:10px; " class = "text-center">
		 			--
		 			<!-- calificacion -->
		 			<?php   ?>
		 				 
		 			</th >

					 
				</tr>
			</table>
		</div>
	  	<!-- detalles nota -->
		<div class="col-xs-12" >
			<table class="table table-striped col-xs-12    table-bordered"  style="font-size: 9px;">
			 		  
	 			<tr>
		 			<th   style="  background-color: #CEE3F6; width:330px; padding: 7 0 7 5;" class = "text-center" >
		 				ITEM
		 			</th >
					<th   style="  background-color: #CEE3F6; width: 165px; padding: 5px" class = "text-center" > 
						NOTA TEÓRICA
					</th >
					<th   style="  background-color: #CEE3F6; width: 150px; padding: 5px" class = "text-center" > 
						NOTA PRÁCTICA
					</th >
					<th   style="  background-color: #CEE3F6; width: 150px; padding: 5px; " class = "text-center" > 
						NOTA FINAL
					</th >
				</tr>
			</table>	
			<?php 
			
			 
 
			 
 

		
				
				// if($contador==$limitePrimeraHoja && $contador <> 0 ){
				// 	echo "<newpage>";
					 
				// }
				// $contador++;
				
				// $nombre= $ficha->modulos[$modulo->id]->nombre;

             
    //             return  $nota_teor;
    //             die();
				// echo  modullista($contador,$nombre,nota_pract ,$nota_teor);
				 
					
				// }

			?>


	</div>	
</div>

<?php  
//funciones de apoyo
 function modullista($contador,$nombre,$nota_pract,$nota_teor){
 	
 	return "<table class=\"table table-striped col-xs-12    table-bordered\"  style=\"font-size: 9px; margin: 3 0 3 0 \">
 			<tr>
		 	<th   style='background-color: #CEE3F6; width: 300px; padding: 7 0 7 5;'  >
		 	{$contador})	 {$nombre}
		 	</th >
		 	<th  class = \"text-center\">
		 		".nota($nota_teor)."
		 	</th >
		 	<th    class = \"text-center\">
		 	".nota($nota_pract)."
		 	</th >
		 	<th    class = \"text-center\">
		 		--
		 	</th > 
		 	</tr></table>";
			
}
// acepta un array y saca el promedio
//recibe un string y lo convierte a nota.
function nota($nota){
	if(is_array($nota)){
		$promedio = 0;
		$n = count($nota);
		foreach ($nota as $value) {
			 $promedio += $value;
		}
		$nota = $promedio / $n;

	} 
	$nota = round($nota * 7,1);
	$nota = number_format($nota , 1, '.', '');
	return $nota;
}
?>