<?php
include(__DIR__.'/admin/producto.class.php');
$web=new Producto;
print_r($web->getAll());
?>