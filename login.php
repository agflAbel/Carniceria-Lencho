<?php include('header.php');?>

<section style="width:500px;margin-left:30%;">
                <form action="login.perfil.php" method="POST">
                    <h2>Inicia Sesion</h2>
                    <input type="email" name="email" placeholder="Correo electr&oacute;nico"><br/>
                    <input type="password" name="contrasena" placeholder="Contrase&ntilde;a"><br/>
                    <button type="submit">Entrar</button>
                    <button type="reset">Limpiar</button>

                    <p>Aun no tienes cuenta ?</p>
                    <p>
                        <a href="register.html">Registrate</a>
                    </p>
                </form>
</section>
<?php include 'footer.php';?>