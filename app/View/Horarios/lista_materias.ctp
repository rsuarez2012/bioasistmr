<?php 
	
	$output = array();      	
	if(isset($result)){
		foreach($result as $row) {        		
        		$output[] = $row['Materia'];        	
        }        
        $result = $output;
		echo json_encode($result);		
	} 
	
?>

