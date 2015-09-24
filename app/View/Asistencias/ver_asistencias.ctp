<?php 
	//Arreglo para los registros
	$output = array();
	     
			
	if(isset($result)){
		foreach($result['rows'] as $row) {
        		$output[] = $row['asistencias'];        	
        }
        foreach($result['total'] as $row) {
        		$output2 = $row[0]['total'];        	
        }
        $result['rows'] = $output;
        $result['total'] = $output2;
		echo json_encode($result);		
	} 
	//echo json_encode($result);
	
?>

