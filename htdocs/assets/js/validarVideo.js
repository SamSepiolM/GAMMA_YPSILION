function validacionVideo(){

    const formLogin = document.getElementById("Registro");
    formLogin.onsubmit = function (e) {
        e.preventDefault();
        const errors = [];
        var titleVideo=document.getElementById("title").value;
        var description=document.getElementById("description").value;
        var courseVideo=document.getElementById("curse").value;
        var Gratis=document.getElementById("gratis").value;

        if (titleVideo===''){
            errors.push(' - Favor de llenar el titulo\n');
        }
        if (description===''){
            errors.push(' - Favor de llenar la descripcion\n');
        }
        if (courseVideo==='Mis cursos'){
            errors.push(' - Favor de elegir un curso\n');
        }


        let finalError = '';
        if (errors.length !== 0) {
            let finalError = '';
            errors.forEach(error => finalError += error);
            alert(finalError);
            e.preventDefault();
            return;
        }

        let xhr = new XMLHttpRequest();
        const curso = {
            TituloCapitulo: titleVideo.trim(),
            Descripcion: description.trim(),
            Gratis:Gratis.trim(),
            

            Curso: courseVideo.trim()
        };
        xhr.open("POST", "/controllers/reg_Capitulo.php", true); // true en modo asicrono
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
                    idCapitulo = res.id;
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
        xhr.send(JSON.stringify(curso));

        //aconfirm('Usuario registrado exitosamente');


        //confirm('Video registrado exitosamente');
        setTimeout(function(){
            window.location.href = "/views/uploadVideo.php?IdCapitulo=" + idCapitulo;
        }, 1000); 
    }
}