//cojo elemento del boton
const button = document.getElementById('download-button');

function generatePDF() {
// renderizo

var opt = {
  margin:       50, //top, left, buttom, right
  html2canvas:  { scale: 2, letterRendering: true, scrollY: 0},
  jsPDF:        { unit: 'pt', format: 'a4', orientation: 'p'}
  };
const element = document.getElementById('invoice');

// Choose the element and save the PDF for your user.
//guardo
  html2pdf().set(opt).from(element).save();

}
button.addEventListener('click', generatePDF); //genero pdf al pulsar boton
