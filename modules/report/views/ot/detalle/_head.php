<div class="container" style="margin-left: -30px;">
	<div class="row"  >
		<div class="col-xs-4" >
			  <table class="table table-striped table-bordered table-condensed" style="font-size: 10px; " > 
			  	<?php echo createHead(array(
			  			array('nombre' => 'Fecha Solicitud', 'detalle' => fecha($ot->inicio)),
			  			array('nombre' => 'Empresa Usuaria', 'detalle' =>  $ot->empresa->nombre),
			  			array('nombre' => 'Tipo Personal', 'detalle' => $ot->personal),
			  			array('nombre' => 'Dirección', 'detalle' => $ot->direccion),
			  			array('nombre' => 'Fecha Inicio', 'detalle' => fecha($ot->inicio)),
			  			
			  	)); ?>
			  </table>
		</div>
		<div class="col-xs-4" >
			 <table class="table table-striped table-bordered table-condensed" style="font-size: 10px; " >
			  		<?php echo createHead(array(
			  			array('nombre' => 'Solicitado Por', 'detalle' => $ot->usuario->nombre . ' ' . $ot->usuario->paterno  . ' ' . $ot->usuario->materno),
			  			array('nombre' => 'Empresa Contratista', 'detalle' => $ot->mandante->nombre),
			  			array('nombre' => 'Tipo Certificación', 'detalle' => $ot->tipo),
			  			array('nombre' => 'Estado Orden', 'detalle' => $ot->estado),
			  			array('nombre' => 'Fecha Termino', 'detalle' => $ot->termino),
			  			
			  		)); ?>
			  </table>
		</div>
		<div class="col-xs-offset-1 col-xs-2" style="margin-right: 15px">
			<div class="row">
				<img   src="<?php echo \Yii::$app->params['url_frontend'].'/img/logo.png'?>" alt="">
			</div>
			<div class="row">
				<div style="width: 200px;   background-color: #CEE3F6; font-size: 14px; padding: 5 0 5  0; text-align: center; border: 1px solid #ccc; margin-top: 18px">
					N° de Orden
				</div>
				<div style="width: 200px; font-size: 14px; padding:  5 0 5 0; text-align: center; border:1px solid #ccc; ">
					 1
				</div>
			</div>
		</div>
	</div>
</div>

<?php 
function createHead($datos){
	 $res  = null;
	if(is_array($datos)){
		foreach ($datos as $key => $v) {
	  		$res  .= "<tr ><th style = \" background-color: #CEE3F6;  padding: 5 0 5 5; width:150px; height:27px;  \">  ". $v['nombre'] ."</th> 
	  					  <td style = \"padding: 5 0 5  5;  width 60%!important\" > ". $v['detalle'] ." </td>
	  				  </tr>";	  	
		}
	}
	return $res;
	
}
function fecha($date){
	return date_format( date_create($date), 'm-d-Y');
}
?>