function buscarCursos(_idUsuario, _submit){
    $.ajax({
    data: {"id": _idUsuario, "submit" : _submit},
    type: "POST",
    url:   '/API/Cursos/api_Cursos_Home.php'
    
}).done(function(response){
    let respuesta=JSON.parse(response);
    let tableBody = document.getElementById("Cusrso12");

    tableBody.innerHTML = "";

    if(respuesta.Resultados.length>0){
        respuesta.Resultados.forEach(element => {
            let row = document.createElement("tr");

            row.innerHTML = `
            <article class="cursos episodios">
                <div class="h-thumb">
                    <figure><img src="https://st.depositphotos.com/1155723/1389/i/600/depositphotos_13899376-stock-photo-a-stack-of-books-on.jpg"></figure>
                </div>
                <header class="c-header">
                    <span class="num-episodios"> ${element.Titulo_Curso}</span>
                    <br><h2 class="c-title">${element.Titulo_Curso}</h2>
                </header>
                <a href="/views/chapterList.php" class="lnk-blk fa-play-circle">
                <span aria-hidden="true" hidden="">Ver ahora</span></a>
            </article>`;

            tableBody.appendChild(row);

        });
        
    }
    else{
        console.log("No se encontro usuario con este ID");
    }
    
    
}).fail(function(textEstado){
    console.log(_idUsuario)
    console.log("La solicitud regreso con un error " + textEstado);
    
});
}

$(document).ready(function(){
        let idUsuario = document.getElementById("idUsuario").value;
        let submit = document.getElementById("submit").value;
        
        buscarCursos(idUsuario, submit);

    $(".buscaUsuario").submit(function(event){
        event.preventDefault();
        
    });

});

