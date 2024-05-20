<h1>Ingresa tus datos</h1>
<form class="align-items-center" method="POST" enctype="multipart/form-data" action="process.php">
  <div class="mb-3">
    <label for="marca" class="form-label">Nombre</label>
    <input type="text" name="nombre" required id="txtNombre" class="form-control" value="">
  </div>
  <div class="mb-3">
    <label for="marca" class="form-label">Primer Apellido</label>
    <input type="text" name="primer_apellido" id="txtPrimerApellido" class="form-control" value="">
  </div>
  <div class="mb-3">
    <label for="marca" class="form-label">Segundo Apellido</label>
    <input type="text" name="segundo_apellido" id="txtSegundoApellido" class="form-control" value="">
  </div>
  <div class="mb-3">
    <label for="marca" class="form-label">RFC</label>
    <input type="text" name="rfc" id="txtRfc" class="form-control" value="">
  </div>
  <div class="mb-3">
    <label for="rol" class="form-label">Rol</label>
    <select class="form-control" name="rol" id="">
      <?php foreach($roles as $rol):?>
        <option value="<?php echo $rol['id_rol']?>"><?php echo $rol['rol']?></option>
      <?php endforeach;?>
    </select>
  </div>
  <div class="mb-3">
    <label for="correo" class="form-label">Correo</label>
    <input type="text" name="correo" id="txtCorreo" class="form-control" value="">
  </div>
  <div class="mb-3">
    <label for="contra" class="form-label">Contraseña</label>
    <input type="password" name="contrasena" id="txtContra" class="form-control" value="">
  </div>
  <input type="submit" class="btn btn-primary" name="save" value="Guardar"/>
</form>