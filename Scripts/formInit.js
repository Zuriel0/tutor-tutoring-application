const exampleEl = document.getElementById('popoverButton');
const formulario = document.querySelector('#regInit'),
semestre = formulario.querySelector('#semestre'),
abstrac = formulario.querySelector('#abstrac'),
materias = formulario.querySelector('#multipleselect');
var semestre_def = 'Selecciona tu opcion';

function send (paramentros) {
  $.ajax({
    data: paramentros,
    url: './../include/form.php',
    type: 'POST',

    beforesend: function(){
      $('#ID_Mostrar_info').html("Mensaje antes de enviar");
    },

    success: function(mensaje_mostrar){
      $('#ID_Mostrar_info').html(mensaje_mostrar);
    }
  });
}

if(semestre.value != semestre_def && abstrac.value != ''){
  const popover = new bootstrap.Popover(exampleEl, {
    toggle: '',
    title: '',
    content: ''
  });
}else{
  const popover = new bootstrap.Popover(exampleEl, {
    toggle: 'popover',
    title: 'Advertencia',
    content: 'Complete todas las casillas'
  });
}

formulario.addEventListener('submit',(e) =>{
  if(semestre.value != semestre_def && abstrac.value != ''){
    paramentros= {
      'semestre' : semestre.value ,
     
      'abstrac' : abstrac.value
    }
    send(paramentros);
  }else{
    
    e.preventDefault();
  }
});