/** Archivo: select-enlazado.js */

var selectMarca = document.querySelector('#kfp-fm-select-marca');
var selectModelo = document.querySelector('#kfp-fm-select-modelo');
var optionsModelo = selectModelo.querySelectorAll('option');

filtraOpcionesModelo(selectMarca.value);

document.addEventListener('input', function (event) {
	if (event.target.id !== 'kfp-fm-select-marca') return;
    filtraOpcionesModelo(event.target.value);
}, false);

// Elimina los options del segundo select y lo rellena con las options filtradas
function filtraOpcionesModelo(selectValue) {
  selectModelo.innerHTML = '';
  for(var i = 0; i < optionsModelo.length; i++) {
    if(optionsModelo[i].dataset.marca === selectValue) {
      selectModelo.appendChild(optionsModelo[i]);
    }
  }
}