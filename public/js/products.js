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
      const codigoBarras = fila.querySelector('td:nth-child(1)').textContent;
      const codigoProducto = fila.querySelector('td:nth-child(2)').textContent;
      const nombreCorto = fila.querySelector('td:nth-child(3)').textContent;
      const nombreArticulo = fila.querySelector('td:nth-child(4)').textContent;
      const disenoId = fila.querySelector('td:nth-child(5)').textContent;
      const precioInicial = fila.querySelector('td:nth-child(6)').textContent != 0 ? fila.querySelector('td:nth-child(6)').textContent : "";
      const precioVenta = fila.querySelector('td:nth-child(7)').textContent != 0 ? fila.querySelector('td:nth-child(7)').textContent : "";
      const infoExtra = fila.querySelector('td:nth-child(8)').textContent;

      const inputHiddenAnteriorCodBarras = document.getElementById("anterior-cod-barras");
      inputHiddenAnteriorCodBarras.value = codigoBarras;
        
      // Llenar los campos del modal de edición con los datos del producto
      document.getElementById('codigo_barras_edit').value = codigoBarras;
      document.getElementById('codigo_producto_edit').value = codigoProducto;
      document.getElementById('nombre_corto_edit').value = nombreCorto;
      document.getElementById('nombre_articulo_edit').value = nombreArticulo;
      document.getElementById('disenio_asociado_edit').value = disenoId;
      document.getElementById('precio_inicial_edit').value = precioInicial;
      document.getElementById('precio_venta_edit').value = precioVenta;
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

btnEliminar.forEach(btn => {
    btn.addEventListener('click', function() {
        const codigoBarras = this.dataset.codigoBarras;
        const nombreArticulo = this.dataset.nombreArticulo;
        const spanCodBarras = document.getElementById("cod-barras");
        const spanNombreArt = document.getElementById("nombre-articulo");
        spanCodBarras.textContent = ` ${codigoBarras}`;
        spanNombreArt.textContent = `${nombreArticulo}`;
        inputCodBarrasHidden.value = codigoBarras;
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

const excelForm = document.getElementById("excel-form");

excelForm.addEventListener("submit" , () => {
    setTimeout( () => {
        excelForm.innerHTML = "<div class='loading-modal'><div class='loading-spinner'></div><p>Cargando productos... Por favor, no cierre esta ventana.</p></div>";
    } , 1000)
    
})