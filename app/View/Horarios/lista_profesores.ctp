<?php 
	
	$output = array();      	
	if(isset($result)){
		foreach($result as $row) {        		
        		$output[] = $row['Personal'];        	
        }        
        $result = $output;
		echo json_encode($result);		
	} 
	
?>

