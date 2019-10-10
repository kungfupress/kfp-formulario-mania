/** Archivo: select-triple.js */

var selectMarca = document.querySelector('#kfp-fman-select-marca');
var selectModelo = document.querySelector('#kfp-fman-select-modelo');
var selectVariante = document.querySelector('#kfp-fman-select-variante');
var optionsModelo = selectModelo.querySelectorAll('option');
var optionsVariante = selectVariante.querySelectorAll('option');
// Escucha eventos input y filtra dos concretos
document.addEventListener('input', function (event) {
    if (event.target.id === 'kfp-fman-select-marca') {
        filtraOpcionesModelo(event.target.value);
    }
    if (event.target.id === 'kfp-fman-select-modelo') {
        filtraOpcionesVariante(event.target.value);
    }
    return;
}, false);
// Elimina los options del segundo select y lo rellena con las options filtradas
function filtraOpcionesModelo(selectValue) {
    selectModelo.innerHTML = '';
    var defaultOption = optionsModelo[0];
    for (var i = 0; i < optionsModelo.length; i++) {
        if (optionsModelo[i].dataset.marca === selectValue) {
            selectModelo.append(optionsModelo[i]);
        }
    }
    selectModelo.append(defaultOption);
}
// Elimina los options del tercer select y lo rellena con las options filtradas
function filtraOpcionesVariante(selectValue) {
    selectVariante.innerHTML = '';
    var defaultOption = "";
    selectVariante.append(defaultOption);
    for (var i = 0; i < optionsVariante.length; i++) {
        if (optionsVariante[i].dataset.modelo === selectValue) {
            selectVariante.append(optionsVariante[i]);
        }
    }
    if (0 === selectVariante.childElementCount) {
        var defaultOption = optionsVariante[0];
        selectVariante.append(defaultOption);
    }
}