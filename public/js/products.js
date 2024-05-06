const firstImportModal = document.getElementById("first-import");

const btnAddProduct = document.getElementById("btn-add");
const btnFilter = document.getElementById("btn-filter");
const btnAddExcel = document.getElementById("btn-add-excel");

const filterModal = document.getElementById("filter");
const addModal = document.getElementById("add");
const addExcelModal = document.getElementById("add-excel");


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

btnAddExcel.addEventListener("click" , () => {
    showModal(addExcelModal);
})

// Control filter modal:

const agregarFiltroBtn = document.getElementById('agregarFiltroBtn');
const nuevoFiltroSelect = document.getElementById('nuevo_filtro');
const addFilterDiv = document.getElementById('add-filter');
const labelNuevoFiltro = document.getElementById('label-nuevo-filtro');

agregarFiltroBtn.addEventListener('click', function() {
    // Obtener el valor seleccionado en el select
    const nuevoFiltro = nuevoFiltroSelect.value;

    // Mostrar el campo correspondiente al nuevo filtro
    const campoFiltro = document.getElementById('div_' + nuevoFiltro + '_filter');
    campoFiltro.style.display = 'block';

    // Remover el nuevo filtro del select para evitar duplicados
    nuevoFiltroSelect.remove(nuevoFiltroSelect.selectedIndex);

    if(nuevoFiltroSelect.length < 1){
        addFilterDiv.style.display = 'none';
        labelNuevoFiltro.style.display = 'none';
    }
});



// Control no se puede añadir sin tener los campos obligatorios rellenos:

const alertMsgAdd = document.getElementById("alert-msg-add");
const addConfirmationBtn = document.getElementById("add-confirm-btn");

addConfirmationBtn.disabled = true;

const inputCodBarrasAdd = document.getElementById("codigo_barras_add");
const inputDisenioAdd = document.getElementById("disenio_asociado_add");
const inputEtiquetaAdd = document.getElementById("etiqueta_add");


// Control no se puede editar sin tener los campos obligatorios rellenos:

const alertMsgEdit = document.getElementById("alert-msg-edit");
const editConfirmationBtn = document.getElementById("edit-confirm-btn");

const inputCodBarrasEdit = document.getElementById("codigo_barras_edit");
const inputDisenioEdit = document.getElementById("disenio_asociado_edit");
const inputEtiquetasEdit = document.getElementById("etiqueta_edit");


// Función para verificar si ambos inputs están llenos
function checkInputs(input1, input2, input3 ,alertMsg, confirmationBtn) {
    if (input1.value.trim() !== '' && input2.value.trim() !== '' &&  input3.value.trim() !== '') {
        alertMsg.style.display = 'none'; // Oculta el mensaje de alerta
        confirmationBtn.disabled = false; // Habilita el botón
    } else {
        alertMsg.style.display = 'block'; // Muestra el mensaje de alerta
        confirmationBtn.disabled = true; // Deshabilita el botón
    }
}

// Añade event listeners a ambos inputs
inputCodBarrasAdd.addEventListener('input', function() {
    checkInputs(inputCodBarrasAdd, inputDisenioAdd, inputEtiquetaAdd,  alertMsgAdd, addConfirmationBtn);
});
inputDisenioAdd.addEventListener('input', function() {
    checkInputs(inputCodBarrasAdd, inputDisenioAdd, inputEtiquetaAdd, alertMsgAdd, addConfirmationBtn);
});
inputEtiquetaAdd.addEventListener('input' , function() {
    checkInputs(inputCodBarrasAdd, inputDisenioAdd, inputEtiquetaAdd, alertMsgAdd, addConfirmationBtn);
});



// Repite el mismo proceso para la sección de edición
inputCodBarrasEdit.addEventListener('input', function() {
    checkInputs(inputCodBarrasEdit, inputDisenioEdit,inputEtiquetasEdit, alertMsgEdit, editConfirmationBtn);
});
inputDisenioEdit.addEventListener('input', function() {
    checkInputs(inputCodBarrasEdit, inputDisenioEdit,inputEtiquetasEdit, alertMsgEdit, editConfirmationBtn);
});

inputEtiquetasEdit.addEventListener('input', function() {
    checkInputs(inputCodBarrasEdit, inputDisenioEdit,inputEtiquetasEdit, alertMsgEdit, editConfirmationBtn);
});




// BOTONES EDITAR:

const editModal = document.getElementById("edit");

const botonesEditar = document.querySelectorAll('.btn-editar');

botonesEditar.forEach(function(boton) {
    boton.addEventListener('click', function() {
      const fila = this.closest('tr');
      const etiqueta = fila.querySelector('td:nth-child(1)').textContent;
      const codigoBarras = fila.querySelector('td:nth-child(2)').textContent;
      const codigoProducto = fila.querySelector('td:nth-child(3)').textContent;
      const nombreCorto = fila.querySelector('td:nth-child(4)').textContent;
      const nombreArticulo = fila.querySelector('td:nth-child(5)').textContent;
      const disenoId = fila.querySelector('td:nth-child(6)').textContent;
      const precioInicial = fila.querySelector('td:nth-child(7)').textContent != 0 ? fila.querySelector('td:nth-child(7)').textContent : "";
      const precioVenta = fila.querySelector('td:nth-child(8)').textContent != 0 ? fila.querySelector('td:nth-child(8)').textContent : "";
      const familia = fila.querySelector('td:nth-child(9)').textContent;
      const infoExtra = fila.querySelector('td:nth-child(10)').textContent;

      const inputHiddenAnteriorCodBarras = document.getElementById("anterior-cod-barras");
      inputHiddenAnteriorCodBarras.value = codigoBarras;
        
      // Llenar los campos del modal de edición con los datos del producto
      document.getElementById('etiqueta_edit').value = etiqueta;
      document.getElementById('codigo_barras_edit').value = codigoBarras;
      document.getElementById('codigo_producto_edit').value = codigoProducto;
      document.getElementById('nombre_corto_edit').value = nombreCorto;
      document.getElementById('nombre_articulo_edit').value = nombreArticulo;
      document.getElementById('disenio_asociado_edit').value = disenoId;
      document.getElementById('precio_inicial_edit').value = precioInicial;
      document.getElementById('precio_venta_edit').value = precioVenta;
      document.getElementById('familia_edit').value = familia;
      document.getElementById('info_extra_edit').value = infoExtra;
  
      // Mostrar el modal de edición
      showModal(editModal);
    });
  });

  

// Modal de confirmación de eliminación de un producto:

const deleteModal = document.getElementById('delete');

const btnEliminar = document.querySelectorAll('.btn-eliminar');

const btnConfirmDelete = document.getElementById("confirmationDelete");
const btnCancel = document.getElementById("cancel");
const closeDeleteConfirmation = document.getElementById("closeDeleteConfirmation");

const inputCodBarrasHidden = document.getElementById("input-cod-barras-hidden");
const inputEtiquetaHidden = document.getElementById("input-etiqueta-hidden");

btnEliminar.forEach(btn => {
    btn.addEventListener('click', function() {
        const codigoBarras = this.dataset.codigoBarras;
        const nombreArticulo = this.dataset.nombreArticulo;
        const etiqueta = this.dataset.etiqueta;
        const spanCodBarras = document.getElementById("cod-barras");
        const spanEtiqueta =document.getElementById("etiqueta");
        const spanNombreArt = document.getElementById("nombre-articulo");
        spanCodBarras.textContent = ` ${codigoBarras}`;
        spanNombreArt.textContent = `${nombreArticulo}`;
        spanEtiqueta.textContent = `${etiqueta}`;
        inputCodBarrasHidden.value = codigoBarras;
        inputEtiquetaHidden.value = etiqueta;
        showModal(deleteModal);
    });
});

btnConfirmDelete.addEventListener("click", ()=> {
    closeModal(modal);
})


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



// Función para el boton de seleccionar archivo:

'use strict';

;( function ( document, window, index )
{
	var inputs = document.querySelectorAll( '.inputfile' );
	Array.prototype.forEach.call( inputs, function( input )
	{
		var label	 = input.nextElementSibling,
			labelVal = label.innerHTML;

		input.addEventListener( 'change', function( e )
		{
			var fileName = '';
			if( this.files && this.files.length > 1 )
				fileName = ( this.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{count}', this.files.length );
			else
				fileName = e.target.value.split( '\\' ).pop();

			if( fileName )
				label.querySelector( 'span' ).innerHTML = fileName;
			else
				label.innerHTML = labelVal;
		});
	});
}( document, window, 0 ));


// Función para loader cuando esté cargando el archivo:

// Función para mostrar un mensaje de carga
function mostrarMensajeCarga(formulario, mensaje) {
    setTimeout(() => {
        formulario.innerHTML = "<div class='loading-modal'><div class='loading-spinner'></div><p>" + mensaje + "</p></div>";
    }, 1000);
}

// Obtener todos los formularios con la clase 'loading-form'
const forms = document.querySelectorAll(".excel-form");

// Iterar sobre cada formulario y agregar el evento
forms.forEach(formulario => {
    formulario.addEventListener("submit", () => {
        mostrarMensajeCarga(formulario, "Cargando productos... Por favor, no cierre esta ventana.");
    });
});
