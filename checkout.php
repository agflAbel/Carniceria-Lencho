<?php
include __DIR__.'/admin/sistema.class.php';

if (isset($_SESSION['validado'])) {
    if($_SESSION['validado']){
        include __DIR__.'/header.php';?>
        <form action="invoice.php" method="POST">
            <div data-mdb-input-init class="form-outline mb-4">
                <input name="numero" type="text" id="form1Example1" class="form-control" />
                <label class="form-label" for="form1Example1">Numero de la tarjeta</label>
            </div>
            <div data-mdb-input-init class="form-outline mb-4">
                <input name="nombre" type="text" id="form1Example1" class="form-control" />
                <label class="form-label" for="form1Example1">Nombre de la tarjeta</label>
            </div>
            <div data-mdb-input-init class="form-outline mb-4">
                <input name="fecha" type="text" id="form1Example1" class="form-control" />
                <label class="form-label" for="form1Example1">Fecha Expiracion</label>
            </div>
            <div data-mdb-input-init class="form-outline mb-4">
                <input name="cvv" type="number" id="form1Example1" class="form-control" />
                <label class="form-label" for="form1Example1">CVV</label>
            </div>
            <div>
            <div class="container">
                <div class="row">
                    <div class="col-md-5">
                        <h1>Total: <?php echo $_SESSION['total']; ?></h1>
                    </div>
                    </div class="col-md-5">
                        <a href="productos.php" class="btn btn-danger" href="">Cancelar y regresar</a>
                    <div>
                    </div class="col-md-5">
                        <input class="btn btn-danger" type="submit" name="invoice" value="Confirmar Pago">
                    <div>
                </div>
            </div>
        </form>
        </div>
        
        <?php
    }else{
        header("Location: login.php");
    }
}else{
    header("Location: login.php");
}
?>