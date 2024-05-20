<?php 
	include(__DIR__.'/admin/producto.class.php');
	$web=new Producto;
?>


			<?php include('header.php');?>
			
					<!-- Banner -->
					<section id="banner">
							<header>
								<h2>Tu proyecto, nuestra pasión.</h2>
								<p>Herramientas de calidad para resultados impecables.</p>
							</header>
						</section>

					<!-- Intro -->
						<section id="intro" class="container">
							<div class="row">
								<div class="col-4 col-12-medium">
									<section class="first">
										<i class="icon solid featured fa-cog"></i>
										<header>
											<h2>Ipsum consequat</h2>
										</header>
										<p>Nisl amet dolor sit ipsum veroeros sed blandit consequat veroeros et magna tempus.</p>
									</section>
								</div>
								<div class="col-4 col-12-medium">
									<section class="middle">
										<i class="icon solid featured alt fa-bolt"></i>
										<header>
											<h2>Magna etiam dolor</h2>
										</header>
										<p>Nisl amet dolor sit ipsum veroeros sed blandit consequat veroeros et magna tempus.</p>
									</section>
								</div>
								<div class="col-4 col-12-medium">
									<section class="last">
										<i class="icon solid featured alt2 fa-star"></i>
										<header>
											<h2>Tempus adipiscing</h2>
										</header>
										<p>Nisl amet dolor sit ipsum veroeros sed blandit consequat veroeros et magna tempus.</p>
									</section>
								</div>
							</div>
							<footer>
								<ul class="actions">
									<li><a href="#" class="button large">Get Started</a></li>
									<li><a href="#" class="button alt large">Learn More</a></li>
								</ul>
							</footer>
						</section>
					</section>
			<!-- Main -->
				<section id="main">
					<div class="container">
						<div class="row">
							<div class="col-12">

								<!-- Portfolio -->
									<section>
										<header class="major">
											<h2>Productos</h2>
										</header>
										<?php
											$datos=$web->getALL();
											
										?>
										<div class="row">
											<?php foreach($datos as $dato):?>
											<div class="col-4 col-6-medium col-12-small">
												<section class="box">
													<a href="#" class="image featured"><img src="uploads/productos/<?php echo $dato['fotografia'] ?>" alt="" /></a>
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
											</div>
											<?php endforeach;?>
										</div>
									</section>

							</div>
							<div class="col-12">

								<!-- Blog -->
									<section>
										<header class="major">
											<h2>The Blog</h2>
										</header>
										<div class="row">
											<div class="col-6 col-12-small">
												<section class="box">
													<a href="#" class="image featured"><img src="images/pic08.jpg" alt="" /></a>
													<header>
														<h3>Magna tempus consequat</h3>
														<p>Posted 45 minutes ago</p>
													</header>
													<p>Lorem ipsum dolor sit amet sit veroeros sed et blandit consequat sed veroeros lorem et blandit adipiscing feugiat phasellus tempus hendrerit, tortor vitae mattis tempor, sapien sem feugiat sapien, id suscipit magna felis nec elit. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos lorem ipsum dolor sit amet.</p>
													<footer>
														<ul class="actions">
															<li><a href="#" class="button icon solid fa-file-alt">Continue Reading</a></li>
															<li><a href="#" class="button alt icon solid fa-comment">33 comments</a></li>
														</ul>
													</footer>
												</section>
											</div>
											<div class="col-6 col-12-small">
												<section class="box">
													<a href="#" class="image featured"><img src="images/pic09.jpg" alt="" /></a>
													<header>
														<h3>Aptent veroeros aliquam</h3>
														<p>Posted 45 minutes ago</p>
													</header>
													<p>Lorem ipsum dolor sit amet sit veroeros sed et blandit consequat sed veroeros lorem et blandit adipiscing feugiat phasellus tempus hendrerit, tortor vitae mattis tempor, sapien sem feugiat sapien, id suscipit magna felis nec elit. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos lorem ipsum dolor sit amet.</p>
													<footer>
														<ul class="actions">
															<li><a href="#" class="button icon solid fa-file-alt">Continue Reading</a></li>
															<li><a href="#" class="button alt icon solid fa-comment">33 comments</a></li>
														</ul>
													</footer>
												</section>
											</div>
										</div>
									</section>

							</div>
						</div>
					</div>
				</section>

			<?php include 'footer.php'; ?>

		</div>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.dropotron.min.js"></script>
			<script src="assets/js/browser.min.js"></script>
			<script src="assets/js/breakpoints.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>

	</body>
</html>