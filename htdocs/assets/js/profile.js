function buscarUsuarios(_idUsuario, _submit){
    $.ajax({
    data: {"id": _idUsuario, "submit" : _submit},
    type: "POST",
    url:   '/API/api.php'
    
}).done(function(response){
    let respuesta=JSON.parse(response);

    if(respuesta.Resultados.length>0){
        usuario=respuesta.Resultados[0];
        console.log(usuario);
        $("#NickName").html(usuario.Username);
        $("#Nombre").html(usuario.Nombre_Usuario + " " + usuario.Apellido_Paterno_Usuario + " " + usuario.Apellido_Materno_Usuario);
        $("#Fecha").html("Fecha de Nacimiento " + usuario.Fecha_Nacimiento);
        $("#Descripcion").html("Correo de usuario: " + usuario.Correo_Usuario + " Con Pass: " + usuario.Contrasenia_Usuario);
        $("#Descripcion2").html("Rol de usuario: " + usuario.Rol_User + " Genero de usuario: " + usuario.Genero);
    }
    else{
        console.log("No se encontro usuario con este ID");

        $("#NickName").html("(Nombre de usuario)");
        $("#Nombre").html("Nombre");
        $("#Fecha").html("Fecha de Nacimiento ");
        $("#Descripcion").html("Descripcion");
        $("#Descripcion2").html("Ejemplo de descripcion");
    }
    
    
}).fail(function(textEstado){
    console.log(_idUsuario)
    console.log("La solicitud regreso con un error " + textEstado);
    
});
}

$(document).ready(function(){
        let idUsuario = document.getElementById("idUsuario").value;
        let submit = document.getElementById("submit").value;
        
        buscarUsuarios(idUsuario, submit);

    $(".buscaUsuario").submit(function(event){
        event.preventDefault();
        
    });

});
