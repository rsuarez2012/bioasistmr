<?php 
	
	$output = array();      	
	if(isset($result)){
		foreach($result as $row) {        		
        		$output[] = $row['BloquesHora'];        	
        }        
        $result = $output;
		echo json_encode($result);		
	} 
	
?>

