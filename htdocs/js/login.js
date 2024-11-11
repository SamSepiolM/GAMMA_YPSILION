(function () { //Function IIFE
    
    const formLogin = document.getElementById("formLogin");
    formLogin.onsubmit = function (e) {
        //Quitar submit
        e.preventDefault();
        const iUsername = document.getElementById("username");
        const iPassword = document.getElementById("password");

        let errors = [];
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
            username: iUsername.value.trim(),
            password: iPassword.value.trim()
        };
        xhr.open("POST", "/controllers/login.php", true); // true en modo asicrono
        xhr.onreadystatechange = function () {
            //Termina peticion 200 = OK
            try {
                if(xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200)  {
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
    }
})();