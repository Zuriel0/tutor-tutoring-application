const formulario = document.getElementById('formulario');
const inputs = document.querySelectorAll('#formulario input');




formulario.addEventListener('submit', (e) => {
	
	
	if(fname.value != "" || names.value != "" || formFile.value != "" || escuela.value !="Selecciona tu escuela" ){
		//formulario.reset();

	} else {
		e.preventDefault();
		
	}
});