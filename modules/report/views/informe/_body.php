<?php 
$FSizeT = 11; 
?>
<div class="container">
	<div class="row">
		<div class="col-xs-7" style=" margin-left: px" >
	   	 	<table class="table table-striped col-xs-12    table-bordered"  style="font-size: 12px;">
	 		  
	 			<tr>
		 			<th   style="  background-color: #CEE3F6; width: 150px; padding: 5px"> Orden de Trabajo:</th >
					<td style="padding: 5px "> <?php echo $informe->ot->id ?></td>
				</tr>
			 
			    <tr>
			    	<th style="background-color: #CEE3F6; padding: 5px   "> Trabajador:</th>
			    	<td style="padding: 5px "><?php echo $informe->trabajador->nombre ?></td>
			    </tr>
			   
		        <tr>
			    	<th style="background-color: #CEE3F6;  padding: 5px  ">Rut:</th>
			    	<td style="padding: 5px "><?php echo $informe->trabajador->rut ?></td>
			    </tr>

		        <tr>
			    	<th style="background-color: #CEE3F6;  padding: 5px  ">Especialidad:</th>
			    	<td style="padding: 5px "><?php echo $informe->ot->especialidad->nombre ?></td>
			    </tr>
   				<tr>
			    <th style="background-color: #CEE3F6; padding: 5px "  > EMP. Contratista: </th>
			    	<td style="padding: 5px ">   <?php  echo $informe->ot->mandante->nombre;?> </td>
				</tr>
				<tr>
				<th style="background-color: #CEE3F6; padding: 5px ">Emp. Usuaria::</th>
				<td style="padding: 5px "><?php  echo $informe->ot->empresa->nombre;?> </td>
				</tr>
				<tr>
					<th style="background-color: #CEE3F6; padding: 5px ">Fecha:</th>
					<td style="padding: 5px "><?php 
					 $date = date_create($informe->creacion);
					 echo date_format($date, 'm-d-Y');
					 ?> </td>
				</tr>

			</table>
		</div>
	  


		<div class="col-xs-12" style=" margin-left: px" >
			<table class="table table-striped col-xs-12    table-bordered"  style="font-size: 12px;">
			 		  
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
		 			<th   style="padding:10px; " class = "text-center">
		 			1.0
		 				 
		 			</th >
		 			<th   style="padding:10px; " class = "text-center">
		 			1.0
		 				 
		 			</th >
		 			<th   style="padding:10px; " class = "text-center">
		 			1.0
		 				 
		 			</th >
		 			<th   style="padding:10px; " class = "text-center">
		 			1.0
		 				 
		 			</th >
		 			<th   style="padding:10px; " class = "text-center">
		 			1.0
		 				 
		 			</th >
		 			<th   style="padding:10px; " class = "text-center">
		 			1.0
		 				 
		 			</th >
		 			<th   style="padding:10px; " class = "text-center">
		 			1.0
		 				 
		 			</th >
		 			<th   style="padding:10px; " class = "text-center">
		 			1.0
		 				 
		 			</th >

					 
				</tr>
			 

			</table>
		</div>
	  	
		<div class="col-xs-12" style=" margin-left: px" >
			<table class="table table-striped col-xs-12    table-bordered"  style="font-size: 7px;">
			 		  
	 			<tr>
		 			<th   style="  background-color: #CEE3F6; width: 150px; padding: 5px" class = "text-center" >
		 				ITEM
		 			</th >
					<th   style="  background-color: #CEE3F6; width: 150px; padding: 5px" class = "text-center" > 
						NOTA TEÓRICA
					</th >
					<th   style="  background-color: #CEE3F6; width: 150px; padding: 5px" class = "text-center" > 
						NOTA PRÁCTICA
					</th >
					<th   style="  background-color: #CEE3F6; width: 150px; padding: 5px" class = "text-center" > 
						NOTA FINAL

					</th >
				 

				</tr>
			 
			    <tr>
		 			<th   style="padding:10px; " class = "text-center">
		 			1.0
		 				 
		 			</th >
		 			<th   style="padding:10px; " class = "text-center">
		 			1.0
		 				 
		 			</th >
		 			<th   style="padding:10px; " class = "text-center">
		 			1.0
		 				 
		 			</th >
		 			<th   style="padding:10px; " class = "text-center">
		 			1.0
		 				 
		 			</th >
		 			 
		 		 

					 
				</tr>
			 

			</table>
			

			<table class="table table-striped col-xs-12    table-bordered"  style="font-size: 7px;">
					 
			    <tr>
		 			<th   style="  background-color: #CEE3F6; width: 150px; padding: 5px"  class = "text-center">
		 			1.0
		 				 
		 			</th >
		 			<th   style="padding:10px; " class = "text-center">
		 			1.0
		 				 
		 			</th >
		 			<th   style="padding:10px; " class = "text-center">
		 			1.0
		 				 
		 			</th >
		 			<th   style="padding:10px; " class = "text-center">
		 			1.0
		 				 
		 			</th >
		 			 
		 		 

					 
				</tr>
			</table>
		</div>


	</div>	
</div>

<?php  
 
?>