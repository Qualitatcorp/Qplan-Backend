<div class="container">
	<div class="row">
		<div class="col-xs-offset-8 col-xs-3">
			<img src="<?php echo \Yii::$app->params['url_frontend'].'/img/logo.png'?>" alt="">
		</div>

		
	</div>
	<div class="row">
		<h5 class = "text-center">LISTADO DE TRABAJADORES</h5>
		<h5 class = "text-center">ORDEN DE TRABAJO Nº47</h5>	 	 
	</div>
	<div class="row">
		<br>
		<table class="table table-striped">
			<thead>
				<tr>
					<th>RUT</th>
					<th>TRABAJADOR</th>
					<th>ESPECIALIDAD</th>
					<th>FIRMA</th>
				</tr>
			</thead>
			<tbody>
		<?php 	
			foreach ($ot-> as $key => $value) {
				?>
				 <tr>
				
					<td><?php print_r($value[]);?> </td>
					<td></td>
				</tr>
		 <?php 	}
		 ?>
				<tr>
					<td>17.081.014-7</td>
					<td>Daniel Rivera</td>
					<td>Mecanico</td>
					<td></td>
				</tr>
			
				 

			</tbody>
			
		</table>
	</div>

</div>

