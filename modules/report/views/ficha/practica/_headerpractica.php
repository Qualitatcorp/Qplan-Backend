
<?php 
//config
	$FSizeT = 11; 
?>
<div class="container" style="margin-left: 25px">
	<div class="row">
		<br>
		<div class="col-xs-offset-8 col-xs-4" style="position: absolute; top: -50px">
			<img src="<?php echo \Yii::$app->params['url_frontend'].'/img/logo.png'?>" alt="">
		</div>  
	</div>
	<div class="row">
	 
		<h4 class = "text-center  text-uppercase">
			EVALUACION PRACTICA <?php echo  $ficha->ot->especialidad->nombre ?> 
		</h4>
	</div>
	<div class="row">
    	 
		<div class="col-xs-3 " >
			<table class="table table-striped   table-condensed" style=" font-size:  <?php echo $FSizeT ?>;">
				<tr>
				    <th style="width: 60px">NOMBRE: </th>
					<td> 
						<?php  echo $ficha->trabajador->nombre;?> 
						<?php  echo $ficha->trabajador->paterno   ;?>
					</td>
				</tr>
				<tr>
					<th>RUT: </th>
					<td> <?php echo $ficha->trabajador->rut;?></td>
				</tr>
			</table>
		</div>
	<div class = "col-xs-4" >
   
	  		<table class="table table-striped   table-condensed"  style=" font-size:  <?php echo $FSizeT ?>;">
			    <tr>
			    	<th style="width: 130px"  > EMP. Contratista: </th>
			    	<td   ><?php  echo $ficha->ot->mandante->nombre;?> </td>
				</tr>
				<tr>
					<th  style="width: 130px">Emp. Usuaria::</th>
					<td  ><?php  echo $ficha->ot->empresa->nombre;?> </td>
				</tr>
			</table>
	</div>
	<div class = "col-xs-3">
			
		 
			<table class="table table-striped   table-condensed"  style="font-size:  <?php echo $FSizeT ?>;">
			    <tr>
			    	<th style="width: 100px"> Orden de trabajo </th>
			    	<td><?php  echo $ficha->ot->id;?> </td>
				</tr>
				<tr>
					<th>Fecha:</th>
					<td><?php 
					 $date = date_create($ficha->creacion);
					 echo date_format($date, 'm-d-Y');
					 ?> </td>
				</tr>
			</table>
		  
		</div>  
	</div>
</div>