(function () { //Function IIFE
    
    const formSignup = document.getElementById("formSignup");
    formSignup.onsubmit = function (e) {
        //Quitar submit
        e.preventDefault();
        const iNames = document.getElementById("names");
        const iLastNames = document.getElementById("lastnames");
        const iUsername = document.getElementById("username");
        const iEmail  =document.getElementById("email");
        const iPassword = document.getElementById("password");

        let errors = [];
        if(!iNames.value || !iNames.value.trim()) {
            errors.push({ msg: "Campo nombre está vacío." });
        }
        if(!iLastNames.value || !iLastNames.value.trim()) {
            errors.push({ msg: "Campo apellidos está vacío." });
        }
        if(!iUsername.value || !iUsername.value.trim()) {
            errors.push({ msg: "Campo nombre de usuario está vacío." });
        }
        // No se valida email porque ya ese esta valdiando desde el formulario
        if(!iPassword.value || !iPassword.value.trim()) {
            errors.push({ msg: "Campo contraseña está vacío." });
        }

        if(errors.length) {
            alert(JSON.stringify(errors));
            return;
        }
        let xhr = new XMLHttpRequest();
        const user = {
            names:  iNames.value.trim(),
            lastnames: iLastNames.value.trim(),
            username: iUsername.value.trim(),
            email: iEmail.value.trim(),
            password: iPassword.value.trim()
        };
        xhr.open("POST", "/controllers/signup.php", true); // true en modo asicrono
        xhr.onreadystatechange = function () {
            //Termina peticion 200 = OK
            try {
                if(xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200)  {
                    let res = JSON.parse(xhr.response);
                    if(res.success != true)
                        return;
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
    }
})();