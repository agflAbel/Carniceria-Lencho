<?php
include __DIR__.'/sistema.class.php';
include '../vendor/autoload.php';
use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;
class Reportes extends Sistema{
    function productos(){
        try {
            $this->conect();
            $sql="SELECT * from producto p
            join marca m on p.id_marca=m.id_marca order by 2,1";
            $stmt=$this->conn->prepare($sql);
            $stmt->execute();
            $result=$stmt->setFetchMode(PDO::FETCH_ASSOC);
            $datos=array();
            $datos=$stmt->fetchAll();
            include __DIR__."/views/reportes/productos.php";
            ob_start();
            $html2pdf = new Html2Pdf('P', 'A4', 'fr');
            $html2pdf->writeHTML($content);
            $html2pdf->output('productos.pdf');
        } catch (Html2PdfException $e) {
            $html2pdf->clean();
        
            $formatter = new ExceptionFormatter($e);
            echo $formatter->getHtmlMessage();
        }
    }
    function marcas(){
        try {
            $this->conect();
            $sql="SELECT m.marca,count(p.id_producto) productos from producto p
            join marca m on p.id_marca=m.id_marca group by 1 order by 2,1";
            $stmt=$this->conn->prepare($sql);
            $stmt->execute();
            $result=$stmt->setFetchMode(PDO::FETCH_ASSOC);
            $datos=array();
            $datos=$stmt->fetchAll();
            include __DIR__."/views/reportes/marcas.php";
            ob_start();
            $html2pdf = new Html2Pdf('P', 'A4', 'fr');
            $html2pdf->writeHTML($content);
            $html2pdf->output('marcas.pdf');
        } catch (Html2PdfException $e) {
            $html2pdf->clean();
        
            $formatter = new ExceptionFormatter($e);
            echo $formatter->getHtmlMessage();
        }
    }
}
?>