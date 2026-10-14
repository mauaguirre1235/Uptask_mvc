<div class="contenedor crear">
    <h1 class="uptask">UpTask</h1>
    <p class="tagline">Crea y Administras tus proyectos</p>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Inciar Sesion</p>
        <form class="formulario" method="POST" action="/">
            <div class="campo">
                <label for="email">Email</label>
                <input 
                type="email"
                id="email"
                placeholder="Tu Email"
                name="email"
                 />
            </div>

              <div class="campo">
                <label for="password">Password</label>
                <input 
                type="password"
                id="password"
                placeholder="Tu password"
                name="password"
                 />
            </div>

            <input type="submit" class="botton" value="Iniciar Sesion">
        </form>

        <div class="acciones">
            <a href="/crear">¿Aun no tienes una cuenta? obtener una</a>
            <a href="/olvide">¿Olvidaste tu Password?</a>
        </div>
    </div> <!--.contenedor-sm-->
</div>