<div class="container-fluid">  
<?php  
   	$x = 0;
 	$corte =8;
 	$margin = 0;
 	 
 	foreach ($ficha->ot->modpractica as $key => $value)
 	{ 
 		if(!($x %  $corte)  && $x > 1){
 			echo '</div> <newpage type="NEXT-ODD"> <div class="container-fluid">';
 		}
 		$x++;
 		if($x%2 == 0 && $x > 1){
 			$margin =50;
 		}else{
 			$margin =0;
 		}	   
 		echo tabla($x,$value->nombre,$margin);
 	}//fin foreach 
 
 	?>
 </div>
 
<?php 
function tabla($x,$nombre,$margin){
	return 	"<div class='col-xs-5' style=' margin-left: {$margin}px' > <table class='table table-striped col-xs-12  table-condensed table-bordered'  style='font-size: 8px;'>
	 		<thead><tr><th   style='height: 38px; vertical-align: text-top; background-color: #CEE3F6; '>{$x}) {$nombre}</th >
			<td style='width: 40px'></td></tr>
			</thead><tbody> 
		    <tr><th>A)</th><td></td></tr><tr><th>B)</th><td ></td></tr>
		    <tr><th>C)</th><td></td></tr><tr><th>D)</th><td ></td></tr>
		    <tr><th>E)</th><td></td></tr>
		    </tbody>
			</table></div>";
}
 
?> 