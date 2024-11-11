let _categoria = 0;
let _fecha = 0;
let _top = 0;

function buscarCursos(_nombre, _categoria, _fecha, _top){
    $.ajax({
    data: {"nombre": _nombre, "categoria": _categoria, "fecha": _fecha, "top": _top},
    type: "POST",
    url:   '/views/ejemplo_ajax_proceso.php',
    
}).done(function(response){
    let tableBody = document.getElementById("Cusrso12");
    console.log(tableBody);
    tableBody.innerHTML = "";
    $("#Cusrso12").html(response);
    console.log(response);
    
}).fail(function(jqXHR, textEstado){
    console.log(_nombre + " " + _categoria+ " " + _fecha + " " + _top)
    console.log("La solicitud regreso con un error " + textEstado);
});
}

$(document).ready(function(){
    let rol = document.getElementById("rol").value;

    switch(rol){
    
    case '1': 
        document.getElementById("referencia").href = "/views/studentProfile.php";
        break;

    case '2': 
        document.getElementById("referencia").href = "/views/teacherProfile.php";
        break;

    case '3': 
        document.getElementById("referencia").href = "/views/adminProfile.php";
        break;
    }


    $(".searcc-bar").submit(function(event){
        event.preventDefault();
        
        let nombreCurso = document.getElementById("nombreCurso").value;

        buscarCursos(nombreCurso, _categoria, _fecha, _top);
       
    });

});


const dropdowns = document.querySelectorAll('.dropdown');

dropdowns.forEach(dropdown => {
    const select = dropdown.querySelector('.select')
    const caret = dropdown.querySelector('.caret')
    const menu = dropdown.querySelector('.menu')
    const optionsCategoria = dropdown.querySelectorAll('#categoria li')
    const optionsFecha = dropdown.querySelectorAll('#fecha li')
    const optionsTop = dropdown.querySelectorAll('#top li')
    const selected = dropdown.querySelector('.selected')

    select.addEventListener('click', () => {
        select.classList.toggle('select-clicked');
        caret.classList.toggle('caret-rotate');
        menu.classList.toggle('menu-open');
    });

    optionsCategoria.forEach(option => {
        option.addEventListener('click', () => {
            selected.innerText = option.innerText;
            select.classList.remove('select-clicked');
            caret.classList.remove('caret-rotate');
            menu.classList.remove('menu-open');

            optionsCategoria.forEach(option =>{ 
                option.classList.remove('active');
            });
            _categoria = option.value;
            option.classList.add('active');
        });
    });

    optionsFecha.forEach(option => {
        option.addEventListener('click', () => {
            selected.innerText = option.innerText;
            select.classList.remove('select-clicked');
            caret.classList.remove('caret-rotate');
            menu.classList.remove('menu-open');

            optionsFecha.forEach(option =>{ 
                option.classList.remove('active');
            });
            _fecha = option.value;
            option.classList.add('active');
        });
    });

    optionsTop.forEach(option => {
        option.addEventListener('click', () => {
            selected.innerText = option.innerText;
            select.classList.remove('select-clicked');
            caret.classList.remove('caret-rotate');
            menu.classList.remove('menu-open');

            optionsTop.forEach(option =>{ 
                option.classList.remove('active');
            });
            _top = option.value;
            option.classList.add('active');
        });
    });
});


