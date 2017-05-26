 

	<div class="row">
			<div  style="margin-left: 381px; width: 581px;   background-color: #CEE3F6; font-size: 9px; padding: 5 0 5  0; text-align: center; border: 1px solid #ccc; margin-top: 18px ; ">
				<strong>Notas</strong>
			</div>
	</div>
	<div class="row " > 
	<!-- padding: 5 0 5  0 -->
		 
		<table class="table table-striped table-bordered  table-condensed" style="width: 98%">
			<thead  >
				<?php 
						echo head_tab(
							array(
								array('ancho'=>10, 'nombre'=>'RUT'),
								array('ancho'=>2, 'nombre'=>'Fecha Cert'),
								array('ancho'=>8, 'nombre'=> 'Trabajador'),
								array('ancho'=>8, 'nombre'=> 'Especialidad'),
								array('ancho'=>5, 'nombre'=> 'Curricular'),
								array('ancho'=>5, 'nombre'=> 'Tecnica'),
								array('ancho'=>5, 'nombre'=> 'Psicologica'),
								array('ancho'=>5, 'nombre'=> 'Seguridad'),
								array('ancho'=>5, 'nombre'=> 'Usuaria'),
								array('ancho'=>5, 'nombre'=> 'Practica'),
								array('ancho'=>5, 'nombre'=> 'Final'),
								array('ancho'=>42, 'nombre'=> 'Calificacion'),
								)
						)
					 ?>
			</thead>
			<tbody>
			<?php 
		
				for ($i=0; $i < 1 ; $i++) { 
						$DetallesNota[] =
				array(
					array('nombre'=>'17.081.014-7'),
					array('nombre'=>'Fecha Cert'),
					array('nombre'=> 'Trabajador'),
					array('nombre'=> 'Especialidad'),
					array('nombre'=> 'Curricular'),
					array('nombre'=> 'Tecnica'),
					array('nombre'=> 'Psicologica'),
					array('nombre'=> 'Seguridad'),
					array('nombre'=> 'Usuaria'),
					array('nombre'=> 'Practica'),
					array('nombre'=> 'Final'),
					array('nombre'=> 'Calificacion'),
					
					);
				}

			echo body_tab($DetallesNota);
			?>
		  
			 
			</tbody>
		</table>
		</div>


 
 

<?php 

function lista($array){
	$tble = null;
	if (is_array($array)) {
		foreach ($$array as $key => $value) {
			var_dump($value);
			$tble .= ''; 
		}
	}
	return $tble;
}

function head_tab($array){
	//ancho,'nombre'
	$res = "<tr>";
	if(is_array($array)){
		foreach ($array as $key => $v) {
			$res .="
					<th style=\"width ".$v['ancho']."px!important; text-align:center;  background-color: #CEE3F6; font-size: 9; \" > ".$v['nombre']."</th>
					 	 
				";
		}
		$res .= "</tr>";
	}
	return $res;
}

function body_tab($variable){
	$res = null;
	if(is_array($variable)){
		foreach ($variable as $key => $array) {
			$res .= "<tr>";
			foreach ($array as $key => $v) {
			// $res .="<div  style=\"margin-left: 0px; width: ".$v['ancho'] ."px;    font-size: 9px; padding: 5 0 5  0; text-align: center; border: 1px solid #ccc; margin-top: 0px; float: left;\">
			//     ".$v['nombre'] ."
			// </div>";
				$res .="<td style=\" text-align:center; padding: 2 0 2  5; height: 10px; font-size: 10; \" > ".$v['nombre']."</td>";
			}
			$res .= "</tr>";
		}
		
	}
	return $res;
}
?>