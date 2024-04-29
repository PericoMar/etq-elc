const btnAddProduct = document.getElementById("btn-add");
const btnFilter = document.getElementById("btn-filter");

const filterModal = document.getElementById("filter");
const addModal = document.getElementById("add");


function showModal(modal) {
    modal.style.display = "block";
}

// Función para cerrar el modal
function closeModal(modal) {
    modal.style.display = "none";
}

// Botones para enseñar el modal:

btnFilter.addEventListener("click", function () {
    showModal(filterModal);

});

btnAddProduct.addEventListener("click", () => {
    showModal(addModal);
});


// Control no se puede añadir sin tener los campos obligatorios rellenos:

const alertMsg = document.getElementById("alert-msg");
const addConfirmationBtn = document.getElementById("add-confirm-btn");
const editConfirmationBtn = document.getElementById("edit-confirm-btn");

addConfirmationBtn.disabled = true;

const inputNombreAdd = document.getElementById("nombre_add");
const inputPwdAdd = document.getElementById("pwd_add");
const checkboxes = document.querySelectorAll('.checkbox');


// Función para verificar si ambos inputs están llenos
function checkInputs() {
    
    let checkboxChecked = false;
    checkboxes.forEach(function(checkbox) {
        if (checkbox.checked) {
            checkboxChecked = true;
        }
    });

    if (inputNombreAdd.value.trim() !== '' && inputPwdAdd.value.trim() !== '' && checkboxChecked) {
        alertMsg.style.display = 'none'; // Oculta el mensaje de alerta
        addConfirmationBtn.disabled = false; // Habilita el botón

    } else {
        alertMsg.style.display = 'block'; // Muestra el mensaje de alerta
        addConfirmationBtn.disabled = true; // Deshabilita el botón
    }
}


function checkInputCheckboxes(){
    let checkboxChecked = false;
    checkboxesEdit.forEach(function(checkbox) {
        if (checkbox.checked) {
            checkboxChecked = true;
        }
    });

    if(checkboxChecked){
        editConfirmationBtn.disabled = false;
    } else {
        editConfirmationBtn.disabled = true;
    }
}

// Añade event listeners a ambos inputs
checkboxes.forEach(function(checkbox){
    checkbox.addEventListener("input", checkInputs);
});
inputNombreAdd.addEventListener('input', checkInputs);
inputPwdAdd.addEventListener('input', checkInputs);


// BOTONES EDITAR:

const editModal = document.getElementById("edit");

const botonesEditar = document.querySelectorAll('.btn-editar');

botonesEditar.forEach(function(boton) {
    boton.addEventListener('click', function() {
        var nombreUsuario = this.closest('tr').querySelector('td:nth-child(1)').innerText.trim(); // Obtener el nombre de usuario
        var rolUsuario = this.closest('tr').querySelector('td:nth-child(2)').innerText.trim(); // Obtener el rol de usuario
        var tiendasUsuario = Array.from(this.closest('tr').querySelectorAll('ul.tiendas-usuario li')).map(li => li.innerText.trim()); // Obtener las tiendas del usuario

        // Actualizar el nombre de usuario en el formulario de edición
        document.querySelector('.nombre-usuario-edit').innerText = nombreUsuario;
        document.getElementById("nombre_usuario_edit").value = nombreUsuario;

        // Actualizar el rol de usuario en el formulario de edición
        document.querySelectorAll('input[name="rol"]').forEach(function(input) {
            if (input.value === rolUsuario) {
                input.checked = true;
            } else {
                input.checked = false;
            }
        });

        // Actualizar las tiendas de usuario en el formulario de edición
        var tiendasCheckbox = document.querySelectorAll('.checkboxes-edit input.checkbox-edit');
        tiendasCheckbox.forEach(function(checkbox) {
            checkbox.checked = tiendasUsuario.includes(checkbox.value);
        });
        showModal(editModal);
    });
  });

  const checkboxesEdit = document.querySelectorAll('.checkbox-edit');

  checkboxesEdit.forEach(function(checkbox){
    checkbox.addEventListener("input", checkInputCheckboxes);
});



// Modal de confirmación de eliminación de un producto:

const deleteModal = document.getElementById('delete');

const btnsEliminar = document.querySelectorAll('.btn-eliminar');

const btnConfirmDelete = document.getElementById("confirmationDelete");
const btnCancel = document.getElementById("cancel");
const closeDeleteConfirmation = document.getElementById("closeDeleteConfirmation");
const inputNombreUserHidden = document.getElementById("input-nombre-user-hidden");

btnsEliminar.forEach(btn => {
    btn.addEventListener('click', function() {
        const nombreUsuario = this.dataset.nombreUsuario;
        const rolUsuario = this.dataset.rolUsuario;
        const spanNombreUsuario = document.getElementById("nombre-usuario");
        const spanRol = document.getElementById("rol-usuario");
        spanNombreUsuario.textContent = ` ${nombreUsuario}`;
        spanRol.textContent = `${rolUsuario}`;
        inputNombreUserHidden.value = nombreUsuario;
        showModal(deleteModal);
    });
});

btnConfirmDelete.addEventListener("click", ()=> {
    closeModal(modal);
})


// BOTONES PARA CERRAR EL MODAL:

const btnsClose = document.querySelectorAll(".close");

const btnsCancelar = document.querySelectorAll(".btn-cancel");

btnsCancelar.forEach( function(btn) {
    btn.addEventListener("click" , () => {
        closeModal(document.getElementById(btn.getAttribute('data-modal')));
    })
});

btnsClose.forEach( function(btn) {
    btn.addEventListener("click" , () => {
        closeModal(document.getElementById(btn.getAttribute('data-modal')));
    })
})
