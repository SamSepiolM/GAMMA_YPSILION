function sendMessage(){
    console.log("hola mundo2");
    const formLogin = document.getElementById("typing-area");
    formLogin.onsubmit = function (e) {
        e.preventDefault();

        const errors = [];
        var mensaje=document.getElementById("message").value;

        if (mensaje===''){
            errors.push(' - Favor de escribir un mensaje\n');
        }

        var emisor=document.getElementById("emisor_id").value;
        var receptor=document.getElementById("receptor_id").value;

        let finalError = '';
        if (errors.length !== 0) {
            let finalError = '';
            errors.forEach(error => finalError += error);
            alert(finalError);
            //e.preventDefault();
            return;
        }

    console.log(receptor);

        let xhr = new XMLHttpRequest();
        const mensajes = {
            Emisor: emisor.trim(),
            Receptor: receptor.trim(),
            Mensaje: mensaje.trim()
        };

        xhr.open("POST", "/controllers/reg_msj.php", true); // true en modo asicrono
        xhr.onreadystatechange = function () {
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
        xhr.send(JSON.stringify(mensajes));

        //aconfirm('Usuario registrado exitosamente');


      //confirm('Curso registrado exitosamente');
      setTimeout(function(){
         window.location.href = "/views/ChatEstudiante.php?receptor_id=" + receptor;
      }, 1000); 
    }
}