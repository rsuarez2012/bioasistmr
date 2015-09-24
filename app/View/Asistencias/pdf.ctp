<?php
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
Area de Ingenieria en Sistemas<br /><br />
<h3>Asistencias</h3></td>
</tr>
</table>
<!--<h5 align="right">Desde: _____ Hasta: _____</h5>-->
<br>
<table border="1" >
<tr bgcolor="#D3D7FF">
    <th align="center" width="30px">id</th>
    <th align="center" width="80px">Cedula</th>
    <th align="center" width="120px">Profesor</th>
    <th align="center" width="200px">Materia</th>
    <th align="center" width="80px">Fecha</th>
        <th align="center" width="80px">Hora Entrada</th>
</tr>

EOD;
$i=1;
foreach($asistencias as $noticia){
$html = $html.'
        <tr>
        <td align="center">'.$i.'</td>
        <td align="center">'.$noticia['personal']['cedula'].'</td>
        <td align="center">'.$noticia['personal']['nombres'].' '.$noticia['personal']['apellidos'].'</td>
        <td align="center">'.$noticia['materias']['materia_nombre'].'</td>
        <td align="center">'.$noticia[0]['fecha'].'</td>
        <td align="center">'.$noticia[0]['hora_entrada'].'</td>

    </tr>
';
$i++;
}

$html = $html.'</table>';
// Print text using writeHTMLCell()

//$tcpdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$tcpdf->writeHTML($html, $ln=true, $fondo=false, $reseth=false, $cell=false);
$tcpdf->Output("ejemplo.pdf", "I");
exit()
?>
