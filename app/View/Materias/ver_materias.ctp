<?php 
	
	$output = array();      
		
	if(isset($result)){
		foreach($result['rows'] as $row) {
        		$output[] = $row['Materia'];        	
        }
        $result['rows'] = $output;
		echo json_encode($result);		
	} 
	
?>

