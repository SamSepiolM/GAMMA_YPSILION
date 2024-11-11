function validacion(){

    const form = document.getElementById("EditarUsuario");
    form.onsubmit = function (e) {
        e.preventDefault();
        const errors = [];

        var correoAdmin = document.getElementById("Correo").value;

        var ExpReg= /[a-zA-Z0-9._-]\@(hotmail|outlook|gmail|yahoo)\.(com|es)/;
        var validacion= ExpReg.test(correoAdmin);
        if (validacion!=true){
            errors.push(' - Formato de correo no valido\n');
        }

        var userAdmin = document.getElementById("Usuario").value;

        if (userAdmin === ''){
            errors.push(' - Favor de llenar el nombre de usuario\n');
        }

        var contraseniaAdmin=document.getElementById("Contrasenia").value;
        var ExpRegC= /(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[a-zA-Z!#$%&?"])[a-zA-Z0-9!#$%&?]{8,12}/;
        var validacionC= ExpRegC.test(contraseniaAdmin);
        if (validacionC!=true){
            errors.push(' - Formato de contraseña no valido debe de tener minimo 8 caracteres, una mayuscula, minuscula, un numero y un caracter especial\n');
        }
  
        let finalError = '';
        if (errors.length !== 0) {
            let finalError = '';
            errors.forEach(error => finalError += error);
            alert(finalError);
            e.preventDefault();
            return;
        }
        confirm('Usuario actualizado exitosamente');
        setTimeout(function(){
            window.location.href = "/views/adminProfile.php";
        }, 1000); 
    }
  }


  function validacionAdministrador(){

    const form = document.getElementById("RegistrarUsuario");
    form.onsubmit = function (e) {
        e.preventDefault();
        const errors = [];

          
        var nomAdmin = document.getElementById("NombreAdmin").value;
        var patAdmin = document.getElementById("PaternoAdmin").value;
        var matAdmin = document.getElementById("MaternoAdmin").value;
        var correoAdmin = document.getElementById("CorreoAdmin").value;
        var userAdmin = document.getElementById("UsuarioAdmin").value;
        var contraseniaAdmin=document.getElementById("ContraseniaAdmin").value;
        var fechaAdmin=document.getElementById("FechaAdmin").value;
        var imagenAdmin=document.getElementById("imagenAdmin").value;


        var ExpRegN= /^([^0-9]*)^[a-zA-Z ]{2,20}$/;
        var validacionN= ExpRegN.test(nomAdmin);
        if (validacionN!=true){
            errors.push(' - El nombre no puede llevar caracteres especiales\n');
        }


        if (patAdmin==='' || matAdmin===''){
            errors.push(' - Favor de llenar los apellidos\n');
        }
        var ExpRegA= /^([^0-9]*)+[a-zA-Z]{2,30}$/;
        var validacionA= ExpRegA.test(patAdmin);
        var validacionB= ExpRegA.test(matAdmin);
        if (validacionA!=true || validacionB!=true){
            errors.push(' - Los apellidos no pueden llevar caracteres especiales\n');
        }
  

        var ExpReg= /[a-zA-Z0-9._-]\@(hotmail|outlook|gmail|yahoo)\.(com|es)/;
        var validacion= ExpReg.test(correoAdmin);
        if (validacion!=true){
            errors.push(' - Formato de correo no valido\n');
        }

       

        if (userAdmin === ''){
            errors.push(' - Favor de llenar el nombre de usuario\n');
        }

   
        var ExpRegC= /(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[a-zA-Z!#$%&?"])[a-zA-Z0-9!#$%&?]{8,12}/;
        var validacionC= ExpRegC.test(contraseniaAdmin);
        if (validacionC!=true){
            errors.push(' - Formato de contraseña no valido debe de tener minimo 8 caracteres, una mayuscula, minuscula, un numero y un caracter especial\n');
        }
  
        let finalError = '';
        if (errors.length !== 0) {
            let finalError = '';
            errors.forEach(error => finalError += error);
            alert(finalError);
            e.preventDefault();
            return;
        }
        confirm('Administrador registrado exitosamente');
        setTimeout(function(){
            window.location.href = "/views/adminProfile.php";
        }, 1000); 
    }
  }
