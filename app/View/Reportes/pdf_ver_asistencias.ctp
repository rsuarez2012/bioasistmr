<?php

function bloqueHora($bloques, $bloque_id) {
        foreach($bloques as $b) {
                if($b['BloquesHora']['id']==$bloque_id) {
                        $hora = $b['BloquesHora']['bloque'];
                }
        }
        return $hora;
}	

$inicio = date('d-m-Y', strtotime($inicio));
$fin = date('d-m-Y', strtotime($fin));

//$raul ="hola-mundo";
//$nombre=$post['Post']['title'];
//$nombre2=$post['Post']['body'];
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
App::import('Vendor','tcpdf/tcpdf');
App::import('Vendor','tcpdf/config/lang/spa');
$tcpdf = new TCPDF('P');
$textfont = 'helvetica';
$tcpdf->SetCreator(PDF_CREATOR);
$tcpdf->SetAuthor("autor");
$tcpdf->SetTitle("Título");
$tcpdf->SetSubject("Tutorial TCPDF en cakePHP");
$tcpdf->SetKeywords("TCPDF, PDF, cakePHP, ejemplo");
$tcpdf->setPrintHeader(FALSE);
$tcpdf->setPrintFooter(true);
$tcpdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$tcpdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$tcpdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
$tcpdf->setHeaderMargin(3);
$tcpdf->getAliasNumPage();
//$tcpdf->Image('../webroot/img/Unerg-1.png', 0, 0, 210, 297);




$tcpdf->AliasNbPages();
$tcpdf->AddPage();
//$tcpdf->SetFont("freesans", "BI", 20);
$tcpdf->SetFont('helvetica', '', 10); 
//$tcpdf->Cell(0,10,"Hola mundo",1,1,'C');
//$tcpdf->AddPage();

// set text shadow effect
//$tcpdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

// Set some content to print
//$tcpdf->Image('../../webroot/img/Unerg-1.png', 15, 140, 75, 113, 'JPG', '', true, 150, '', false, false, 1, false, false, false);
$html = <<<EOD
<table>
<tr>
    <td width="150"><img src="../webroot/img/Unerg-1.png" width="150" align="left"></td>
<td align="center">República Bolivariana de venezuela<br />
Universidad Nacional Experimental<br /> Romulo Gallegos<br />
Area de Ingenieria en Sistemas<br /><br /></td>
</tr>
</table>
<h3 align="center">Horarios</h3>
<h5 align="right">Desde: $inicio Hasta: $fin</h5>
<br>
<table border="1">
    <tr bgcolor="#D3D7FF">
        <th align="center" width="20px">Nº</th>
        <th align="center" width="130px">Materias</th>
        <th align="center" width="230">Profesor</th>        
        <th align="center" width="50px">Seccion</th>        
        <th align="center" width="70px">Inicio</th>
        <th align="center" width="70px">Fin</th>
        <th align="center" width="40px">Aula</th>
    </tr>

EOD;
$i=1;
foreach($asistencias as $asistencia){
$html = $html.'
    <tr>
        <td align="center">'.$i.'</td>
        <td align="center">'.$asistencia['materias']['materia_nombre'].'</td>
        <td align="center">'.$asistencia['personal']['nombres'].' '.$asistencia['personal']['apellidos'].'</td>        
        <td align="center">'.$asistencia['secciones']['seccion_nombre'].'</td>        
        <td align="center">'.bloqueHora($bloques,$asistencia['horarios']['inicio']).'</td>
        <td align="center">'.bloqueHora($bloques,$asistencia['horarios']['fin']).'</td>
        <td align="center">'.$asistencia['aulas']['aula_nombre'].'</td>
    </tr>
';
$i++;
}

$html = $html.'</table>';
// Print text using writeHTMLCell()

//$tcpdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$tcpdf->writeHTML($html, $ln=true, $fondo=false, $reseth=false, $cell=false);
$tcpdf->Output("HorarioHoy.pdf", "I");
exit()
?>
