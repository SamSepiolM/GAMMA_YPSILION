function validacion(){

    const formLogin = document.getElementById("Register");
    formLogin.onsubmit = function (e) {
        e.preventDefault();

        const errors = [];

        var NombreEditar=document.getElementById("NombreEditar").value;
        var ApellidoPEditar=document.getElementById("ApellidoPEditar").value;
        var ApellidoMEditar=document.getElementById("ApellidoMEditar").value;
        var UserEditar=document.getElementById("userEditar").value;
        var CorreoEditar=document.getElementById("CorreoEditar").value;
        var ContrasenaEditar=document.getElementById("ContrasenaEditar").value;
        var IdUsuario=document.getElementById("idUsuario").value;
        var RolUsuario=document.getElementById("rol").value;
        var GeneroUser = document.getElementById("Genero").value;
        var FechaNacimientoUser = document.getElementById("fechaNacimiento").value;
        //const ImagenUser = document.getElementById("imagen").files[0].name;;
        //console.log(ImagenUser);


        if (NombreEditar===''){
            errors.push(' - Favor de llenar el nombre\n');
        }
        var ExpRegN= /^([^0-9]*)^[a-zA-Z ]{2,20}$/;
        var validacionN= ExpRegN.test(NombreEditar);
        if (validacionN!=true){
            errors.push(' - El nombre no puede llevar caracteres especiales\n');
        }

        if (ApellidoPEditar==='' || ApellidoMEditar===''){
            errors.push(' - Favor de llenar los apellidos\n');
        }
        var ExpRegA= /^([^0-9]*)+[a-zA-Z]{2,30}$/;
        var validacionA= ExpRegA.test(ApellidoPEditar);
        var validacionB= ExpRegA.test(ApellidoMEditar);
        if (validacionA!=true || validacionB!=true){
            errors.push(' - Los apellidos no pueden llevar caracteres especiales\n');
        }

        if (UserEditar===''){
            errors.push(' - Favor de llenar el nombre de usuario\n');
        }

        var ExpReg= /[a-zA-Z0-9._-]\@(hotmail|outlook|gmail|yahoo)\.(com|es)/;
        var validacion= ExpReg.test(CorreoEditar);
        if (validacion!=true){
            errors.push(' - Formato de correo no valido\n');
        }

        var ExpRegC= /(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[a-zA-Z!#$%&?"])[a-zA-Z0-9!#$%&?]{8,12}/;
        var validacionC= ExpRegC.test(ContrasenaEditar);
        if (validacionC!=true){
            errors.push(' - Formato de contraseña no valido debe de tener minimo 8 caracteres, una mayuscula, minuscula, un numero y un caracter especial\n');
        }
        let finalError = '';
        if (errors.length !== 0) {
            let finalError = '';
            errors.forEach(error => finalError += error);
            alert(finalError);
            //e.preventDefault();
            return;
        }


        let xhr = new XMLHttpRequest();
        const user = {
            Nombre_Usuario: NombreEditar.trim(),
            Apellido_Paterno_Usuario: ApellidoPEditar.trim(),
            Apellido_Materno_Usuario: ApellidoMEditar.trim(),
            Correo_Usuario: CorreoEditar.trim(),
            Contrasenia_Usuario: ContrasenaEditar.trim(),
            Username: UserEditar.trim(),
            //Foto_Perfil: ImagenUser.trim(),
            Estado_Usuario: 1,
            Rol_User: RolUsuario.trim(),
            Genero: parseInt(GeneroUser.trim()),
            Fecha_Nacimiento: FechaNacimientoUser.trim(),
            idUsuario: IdUsuario.trim()
            
        };
        xhr.open("POST", "/controllers/editUser.php", true); // true en modo asicrono
        xhr.onreadystatechange = function () {
            //Termina peticion 200 = OK
            try {
                if(xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200)  {
                    let res = JSON.parse(xhr.response);
                    if(res.success != true){
                        return;
                    }
                    // Sucess ...
                    alert(res.msg);
                    switch (user.Rol_User){
                    case '1':
                        window.location.replace("/views/studentProfile.php");
                        break;
                    case '2':
                        window.location.replace("/views/teacherProfile.php");
                        break;
                    case '3':
                        window.location.replace("/views/adminProfile.php");
                        break;

                    default:
                        
                        break;
                    }
                    //window.location.replace("/");
                }
            } catch(error) {
                // Se imprime el error del servidor
                console.error(xhr.response);
                alert(xhr.response);
            }
            
        }
        //Enviarlo en formato JSON
        xhr.send(JSON.stringify(user));

        //confirm('Usuario editado exitosamente');

    }
}




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
        $("#userEditar").val(usuario.Username);
        $("#NombreEditar").val(usuario.Nombre_Usuario);
        $("#ApellidoPEditar").val(usuario.Apellido_Paterno_Usuario);
        $("#ApellidoMEditar").val(usuario.Apellido_Materno_Usuario);
        $("#CorreoEditar").val(usuario.Correo_Usuario);
        $("#ContrasenaEditar").val(usuario.Contrasenia_Usuario);
        $("#Imagen").val();
        $("#Genero").val(usuario.Genero);
        $("#fechaNacimiento").val(usuario.Fecha_Nacimiento);
        //$("#Imagen").val(usuario.Correo_Usuario);
    }
    else{
        console.log("No se encontro usuario con este ID");

        $("#userEditar").val();
        $("#NombreEditar").val();
        $("#ApellidoPEditar").val();
        $("#ApellidoMEditar").val();
        $("#CorreoEditar").val();
        $("#ContrasenaEditar").val();
        $("#Imagen").val();
        $("#Genero").val();
        $("#fechaNacimiento").val();
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


    var todayDate = new Date().toISOString().slice(0, 10);
    
    document.getElementById("fechaNacimiento").max = todayDate;
});