<h1 class="nombre-pagina">crear cuenta</h1>
<p class="descripcion-pagina">Llena el siguiente para crear una cuenta</p>

<?php 
    include_once __DIR__ . '/../templates/alertas.php';
?>

<form action="" class="formulario" method="POST" action="/crear-cuenta">
    <div class="campo">
        <label for="nombre">Nombre</label>
        <input type="text" id="nombre" placeholder="Tu nombre" name="nombre" value="<?php echo s($usuario->nombre) ?>" required />
    </div>

    <div class="campo">
        <label for="apellido">Apellido</label>
        <input type="text" id="apellido" placeholder="Tu Apellido" name="apellido" value="<?php echo s($usuario->apellido) ?>" required />
    </div>

    <div class="campo">
        <label for="telefono">Telefono</label>
        <input type="tel" id="telefono" placeholder="Tu telefono" name="telefono" value="<?php echo s($usuario->telefono) ?>" required />
    </div>

    <div class="campo">
        <label for="email">Email</label>
        <input type="email" id="email" placeholder="Tu E-mail" name="email" value="<?php echo s($usuario->email) ?>" required />
    </div>

    <div class="campo">
        <label for="password">Password</label>
        <input minlength="6" type="password" id="password" placeholder="Tu password" name="password" required />
    </div>

    <input type="submit" value="Crear cuenta" class="boton">
</form>

<div class="acciones">
    <a href="/">Ya tienes una cuenta? </a>
    <a href="/olvide">Olvidaste tu password</a>
</div>