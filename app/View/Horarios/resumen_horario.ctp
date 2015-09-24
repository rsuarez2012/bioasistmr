<?php
	$resumen['total'] = 0;
	$resumen['rows'] = array();
	$resumen['footer'] = array(array('precio' => 'Subtotal:', 'subtotal' => 0.00), 
								array('precio' => 'I.V.A.(12%):', 'subtotal' => 0.00),
								array('precio' => 'Desc.:', 'subtotal' => 0.00),
								array('precio' => 'Total:', 'subtotal' => 0.00)								
								);	
	echo json_encode($resumen);
?>