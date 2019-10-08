/** Archivo: select-triple.js */

var selectMarca = document.querySelector('#kfp-fm-select-marca');
var selectModelo = document.querySelector('#kfp-fm-select-modelo');
var selectVariante = document.querySelector('#kfp-fm-select-variante');
var optionsModelo = selectModelo.querySelectorAll('option');
var optionsVariante = selectVariante.querySelectorAll('option');
console.log(optionsModelo);
//filtraOpcionesModelo(selectMarca.value);
//filtraOpcionesVariante(selectModelo.value)
// Escucha eventos input
document.addEventListener('input', function (event) {
	if (event.target.id === 'kfp-fm-select-marca') {
        filtraOpcionesModelo(event.target.value);
    }
    if (event.target.id === 'kfp-fm-select-modelo') {
        filtraOpcionesVariante(event.target.value);
    }
    return;
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
// Elimina los options del tercer select y lo rellena con las options filtradas
function filtraOpcionesVariante(selectValue) {
    selectVariante.innerHTML = '';
    for(var i = 0; i < optionsVariante.length; i++) {
        if(optionsVariante[i].dataset.modelo === selectValue) {
        selectVariante.appendChild(optionsVariante[i]);
        }
    }
    if (0 === selectVariante.childElementCount) {
        selectVariante.parentElement.remove();
    }
  }