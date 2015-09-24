<?php 
	
	$output = array();      	
	if(isset($result)){
		foreach($result as $row) {        		
        		$output[] = $row['Aula'];        	
        }        
        $result = $output;
		echo json_encode($result);		
	} 
	
?>

