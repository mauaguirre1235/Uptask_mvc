<div class="contenedor olvide">
 <?php include_once __DIR__ .'/../templates/nombre-sitio.php';?>
    <div class="contenedor-sm">
        <p class="descripcion-pagina">Recupera tu Acceso UpTask</p>
        <form class="formulario" method="POST" action="/olvide">
            <div class="campo">
                <label for="email">Email</label>
                <input 
                type="email"
                id="email"
                placeholder="Tu Email"
                name="email"
                 />
            </div>

            <input type="submit" class="botton" value="Enviar Instrucciones">
        </form>

        <div class="acciones">
            <a href="/">¿Ya tienes una cuenta? Iniciar Sesion </a>
            <a href="/crear">¿Aun no tienes una cuenta? obtener una</a>
            
        </div>
    </div> <!--.contenedor-sm-->
</div>