<!DOCTYPE HTML>
<!--
	Dopetrope by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>Ferreteria par Luislao</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="../assets/css/main.css" />
	</head>
	<body class="homepage is-preload">
		<div id="page-wrapper">
                <!-- Header -->
				<section id="header">

					<!-- Logo -->
						<h1><a href="../index.php">Ferreteria</a></h1>

					<!-- Nav -->
						<nav id="nav">
							<ul>
								<li class="current"><a href="../index.php">Inicio</a></li>
								<li>
									<a href="#">Catalogos</a>
									<ul>
										<li><a href="producto.php">Productos</a></li>
										<li><a href="tienda.php">Tiendas</a></li>
										<li><a href="marca.php">Marcas</a></li>
										
									</ul>
								</li>
								<li><a href="carrito.php">Carrito</a></li>
								<li><a href="login.php">Iniciar sesion</a></li>
								<li><a href="../register.php">Registrarme</a></li>
							</ul>
						</nav>

				</section>
                <?php
                session_start();
                // echo "<pre>";
                // print_r($_SESSION);
                ?>
                <section id="main">
                <div class="col-4 col-6-medium col-12-small">
                <?php
                $productos = $_SESSION['cart'];
                include(__DIR__.'/producto.class.php');
	            $web=new Producto;
                $total=0;
                foreach ($productos as $id_producto=>$cantidad):
                    $dato=$web->getOne($id_producto);
                    // print_r($dato);
                    $subtotal=$dato['precio']*$cantidad;
                    $total+=$subtotal;
                    ?>
                    <section class="box">
                        <a href="#" class="image featured"><img style="width:100px" src="../uploads/productos/<?php echo $dato['fotografia'] ?>" alt="" /></a>
                        <header>
                            <h3><?php echo $dato['producto']; ?></h3>
                        </header>
                        <footer>
                            <ul class="actions">
                                <li><a href="#" class="button alt">Find out more</a></li>
                            </ul>
                            <form action="admin/caradd.php" method="get">
                                <input type="number" name="cantidad" min="1" >
                                <input type="hidden" name="id_producto" value="<?php echo $dato['id_producto']; ?>">
                                <input type="submit" value="agregar" >
                            </form>
                        </footer>
                    </section>
                <?php endforeach;?>
                    <h1>Total: <?php echo $total; $_SESSION['total']=$total; ?></h1> 
                    </div>
                    <a href="../checkout.php">Pagar</a>
                </section>
<?php include '../footer.php';?>