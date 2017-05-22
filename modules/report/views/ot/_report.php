 

<div class="container">
	<div class="row">
		<div class="col-xs-offset-8 col-xs-3">
			<img src="<?php echo \Yii::$app->params['url_frontend'].'/img/logo.png'?>" alt="">
		</div>

		
	</div>
	<div class="row">
		<h4 class = "text-center">LISTADO DE TRABAJADORES</h4>
		<h4 class = "text-center ">ORDEN DE TRABAJO Nº <?php echo  $ot->id ?></h4>	
		<br>
		<h5 class = "text-center text-uppercase">ESPECIALIDAD <?php echo  $ot->especialidad->nombre ?></h5>	 	 	 
	</div>
	<div class="row">
		<br>
		<table class="table table-striped table-bordered table-condensed">
			<thead  >
				<tr  >
					<th style="width:18%;text-align:center; " >RUT</th>
					<th  style="width:46%;text-align:center;" >TRABAJADOR</th>
					 
					<th style="width:36%;text-align:center;" >FIRMA</th>
				</tr>
			</thead>
			<tbody>
			<?php 
				if(!$ot->trabajador){
			?>
				<tr>
		 			
					<td>sin registro</td> 
					<td>sin registro</td>
					<td>sin registro</td>
				</tr>
			<?php
			}else{
				foreach ( $ot->getTrabajador()->orderBy(['rut'=> SORT_ASC])->all() as $key => $t) {  ?>
	 			<tr>
		 			<td  style=" text-align:right; padding-right: 20px; ";><?php   echo $t->rut; ?></td>	 
		 			<td  ><?php   echo  $t->nombre. ' ' . $t->paterno. ' ' .  $t->materno ; ?></td>
				
					<td></td> 
				</tr>
	 			<?php }// for each

	 		} //if trsabajador
	 		?> 
			 
				 

			</tbody>
			
		</table>
		 
	</div>

</div>

