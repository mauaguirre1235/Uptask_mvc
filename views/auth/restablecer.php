<div class="contenedor restablecer">
 <?php include_once __DIR__ .'/../templates/nombre-sitio.php';?>
    <div class="contenedor-sm">
        <p class="descripcion-pagina">Coloca tu nuevo password</p>
        <form class="formulario" method="POST" action="/restablecer">
            <div class="campo">
                <label for="password">Password</label>
                <input 
                type="password"
                id="password"
                placeholder="Tu password"
                name="password"
                 />
            </div>

            <input type="submit" class="botton" value="Guardar password">
        </form>

        <div class="acciones">
            <a href="/">¿Ya tienes una cuenta? Iniciar Sesion </a>
            <a href="/crear">¿Aun no tienes una cuenta? obtener una</a>
            
        </div>
    </div> <!--.contenedor-sm-->
</div>