<?php 
	
	$output = array();      
	
	if(isset($result)){
		foreach($result['rows'] as $row) {
        		$output[] = $row['Perfil'];        	
        }
        $result['rows'] = $output;
		echo json_encode($result);		
	} 
	
?>

