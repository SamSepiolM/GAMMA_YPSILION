function validacionRegistro(){

    const formLogin = document.getElementById("RegistroUsuario");
    formLogin.onsubmit = function (e) {
        e.preventDefault();
        const errors = [];
    
        const RegUsuario = document.getElementById("RegUsuario").value;
        const RegNombre = document.getElementById("RegNombre").value;
        const RegApellido = document.getElementById("RegApellido").value;
        const RegApellidoM = document.getElementById("RegApellidoM").value;
        const RolUser = document.getElementById("Rol").value;
        const GeneroUser = document.getElementById("Genero").value;
        const FechaNacimientoUser = document.getElementById("fechaNacimiento").value;

        var idUser = 0;
        //const ImagenUser = document.getElementById("imagen").value;
        //console.log(ImagenUser);
        if (RegUsuario === ''){
            errors.push(' - Favor de llenar el nombre de usuario\n');
        }
        if (RegNombre === ''){
            errors.push(' - Favor de llenar su nombre real\n');
        }
        
        var ExpRegN= /^([^0-9]*)^[a-zA-Z ]{2,20}$/;
        var validacionN= ExpRegN.test(RegNombre);
        if (validacionN!=true){
            errors.push(' - El nombre no puede llevar caracteres especiales\n');
        }
        
        if (RegApellido === '' || RegApellidoM === ''){
            errors.push(' - Favor de llenar sus apellidos\n');
        }
    
        var ExpRegA= /^([^0-9]*)^[a-zA-Z ]{2,30}$/;
        var validacionA= ExpRegA.test(RegApellido);
        var validacionB= ExpRegA.test(RegApellidoM);
        if (validacionA!=true || validacionB!=true){
            errors.push(' - Los apellidos no pueden llevar caracteres especiales\n');
        }
    
        const RegCorreo=document.getElementById("RegCorreo").value;
    
        var ExpReg = /[a-zA-Z0-9._-]\@(hotmail|outlook|gmail|yahoo)\.(com|es)/;
        var validacion = ExpReg.test(RegCorreo);
        if (validacion != true){
            errors.push(' - Formato de correo no valido\n');
        }
        const RegContrasena=document.getElementById("RegContrasena").value;
    
        var ExpRegC= /(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[a-zA-Z!#$%&?"])[a-zA-Z0-9!#$%&?]{8,16}/;
        var validacionC= ExpRegC.test(RegContrasena);
        if (validacionC != true){
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
            Nombre_Usuario: RegNombre.trim(),
            Apellido_Paterno_Usuario: RegApellido.trim(),
            Apellido_Materno_Usuario: RegApellidoM.trim(),
            Correo_Usuario: RegCorreo.trim(),
            Contrasenia_Usuario: RegContrasena.trim(),
            Username: RegUsuario.trim(),
            //Foto_Perfil: ImagenUser.trim(),
            Rol_User: parseInt(RolUser.trim()),
            Estado_Usuario: 1,
            Genero: parseInt(GeneroUser.trim()),
            Fecha_Nacimiento: FechaNacimientoUser.trim()
            //idUsuario: 13
            
        };
        xhr.open("POST", "/controllers/signup.php", true); // true en modo asicrono
        xhr.onreadystatechange = function () {
            //Termina peticion 200 = OK
            try {
                if(xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200)  {
                    let res = JSON.parse(xhr.response);
                    if(res.success != true){
                        alert(res.msg);
                        console.log(res);
                        return;
                    }
                    // Sucess ...
                    alert(res.msg);
                    idUser = res.id;
                    console.log(res);
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

        //aconfirm('Usuario registrado exitosamente');
        console.log(idUser);
        setTimeout(function(){
            if(idUser != 0){
                window.location.href = "/views/login-signup.php?idUsuario=" + idUser;
            }
            
          }, 1000); 
        
    }
}

//Ejemplo de contraseña MyDream12_@
function validacionLogin(){
    const errors = [];
    var LogUsuario=document.getElementById("LogUsuario").value;
    var LogContrasena=document.getElementById("LogContrasena").value;

    if (LogUsuario===''){
        errors.push(' - Favor de llenar el nombre de usuario\n');
    }
    if (LogContrasena===''){
        errors.push(' - Favor de llenar la contraseña\n');
    }
    let finalError = '';

    if (errors.length !== 0) {
        let finalError = '';
        errors.forEach(error => finalError += error);
        alert(finalError);
        //e.preventDefault();
        return;
    }

    const formLogin = document.getElementById("LoginUsuario");
    formLogin.onsubmit = function (e) {
        e.preventDefault();
        console.log("Hola");

        console.log(LogUsuario + " , " + LogContrasena);


        let xhr = new XMLHttpRequest();
        const user = {
            username: LogUsuario.trim(),
            password: LogContrasena.trim()
        };
        xhr.open("POST", "/controllers/login.php", true); // true en modo asicrono
        xhr.onreadystatechange = function () {
            //Termina peticion 200 = OK
            try {
                if(xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200)  {
                    console.log(xhr.response);
                    let res = JSON.parse(xhr.response);
                    
                    if(res.success != true) {
                        alert(res.msg);
                        return;
                    }
                    // Sucess ...
                    alert(res.msg);
                    window.location.replace("/");
                }
            } catch(error) {
                // Se imprime el error del servidor
                console.error(xhr.response);
            }
            
        }
        //Enviarlo en formato JSON
        xhr.send(JSON.stringify(user));


        //confirm('Usuario logueado exitosamente');

        /*setTimeout(function(){
            window.location.href = "/views/home.php";
        }, 1000);*/
    }
}

$(document).ready(function(){
    var todayDate = new Date().toISOString().slice(0, 10);
    
    document.getElementById("fechaNacimiento").max = todayDate;
    //console.log(as);
});