(function () {
    // boton para mostrar el modar de agregar tarea
    const nuevaTareaBtn = document.querySelector('#agregar-tarea');
    nuevaTareaBtn.addEventListener('click', mostrarFomulario);

    function mostrarFomulario() {
        const modal = document.createElement('DIV');
        modal.classList.add('modal');
        modal.innerHTML = `
        <form class="formulario nueva-tarea">
                <legend>Añade una nueva tarea</legend>
                <div class="campo">
                    <label>Tarea</label>
                    <input 
                    type="text"
                    name="tarea"
                    placeholder="Añadir Tarea al Proyecto Actual"
                    id="tarea" />
                </div>
                <div class="opciones">
                    <input type="submit" class="submit-nueva-tarea" value="Añadir Tarea" />
                    <button type="button" class="cerrar-modal">Cancelar</button>
                </div>
            </form>
     `;

        setTimeout(() => {
            const formulario = document.querySelector('.formulario');
            formulario.classList.add('animar');
        }, 0);


        modal.addEventListener('click', function (e) {
            e.preventDefault();

            if (e.target.classList.contains('cerrar-modal')) {
                const formulario = document.querySelector('.formulario');
                formulario.classList.add('cerrar');
                setTimeout(() => {
                    modal.remove();
                }, 500);

            } 
            if(e.target.classList.contains('submit-nueva-tarea')){
                submitFormularioNuevaTare();

            
            }
        })

        document.querySelector('body').appendChild(modal);
    }

    function submitFormularioNuevaTare(){
        const tarea = document.querySelector('#tarea').value.trim();

        if(tarea === ''){
            // mostrar una alerta de error

            return;
        } else {
            console.log('si hay algo');
        }
    }


})();