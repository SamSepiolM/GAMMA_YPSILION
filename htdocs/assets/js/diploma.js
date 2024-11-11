
function imprimirElemento(elemento) {
  var ventana = window.open('', 'PRINT', 'height=800,width=1200');
  ventana.document.write('<html><head><title>' + document.title + '</title>');
  ventana.document.write('<link rel="stylesheet" href="/assets/css/diplomaStyle.css">'); //Aquí agregué la hoja de estilos
  ventana.document.write('</head>');
  ventana.document.write(elemento.innerHTML);
  ventana.document.write('</html>');
  ventana.document.close();
  ventana.focus();
  ventana.onload = function() {
    ventana.print();
    ventana.close();
  };
  return true;
}


document.querySelector("#btnImprimir").addEventListener("click", function() {
  var div = document.querySelector("#cuerpo");
  imprimirElemento(div);
});