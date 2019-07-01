var selectMarca = document.querySelector('#kfp-fm-select-marca');
var selectModelo = document.querySelector('#kfp-fm-select-modelo');
var optionsModelo = selectModelo.querySelectorAll('option');

giveSelection(selectMarca.value);

document.addEventListener('input', function (event) {
	if (event.target.id !== 'kfp-fm-select-marca') return;
    giveSelection(event.target.value);
}, false);

function giveSelection(selectValue) {
  selectModelo.innerHTML = '';
  for(var i = 0; i < optionsModelo.length; i++) {
    if(optionsModelo[i].dataset.marca === selectValue) {
      selectModelo.appendChild(optionsModelo[i]);
    }
  }
}