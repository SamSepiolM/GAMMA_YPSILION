

function ComprarCurso(idCurso, formaPago){

  const formLogin = document.getElementById("RegistroCurso");
  formLogin.onsubmit = function (e) {
      e.preventDefault();
      const errors = [];

      var idUser = document.getElementById("idUser").value;
      var PrecioPagado = document.getElementById("PrecioCurso").value;

      let finalError = '';
      if (errors.length !== 0) {
          let finalError = '';
          errors.forEach(error => finalError += error);
          alert(finalError);
          //e.preventDefault();
          return;
      }

      let xhr = new XMLHttpRequest();
        const curso = {
            idCurso: idCurso,
            idUser: idUser.trim(),
            PrecioPagado: PrecioPagado.trim(),
            FormaPago: formaPago,
        };
        xhr.open("POST", "/controllers/reg_CursoComprado.php", true); // true en modo asicrono
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


      //confirm('Curso comprado exitosamente');
      setTimeout(function(){
          window.location.href = "/views/home.php";
      }, 1000); 
  }
}

function ComprarCursoPaypal(idCurso, formaPago){

    const formLogin = document.getElementById("RegistroCurso");

        //e.preventDefault();
        const errors = [];
  
        var idUser = document.getElementById("idUser").value;
        var PrecioPagado = document.getElementById("PrecioCurso").value;
  
        let finalError = '';
        if (errors.length !== 0) {
            let finalError = '';
            errors.forEach(error => finalError += error);
            alert(finalError);
            //e.preventDefault();
            return;
        }
  
        let xhr = new XMLHttpRequest();
          const curso = {
              idCurso: idCurso,
              idUser: idUser.trim(),
              PrecioPagado: PrecioPagado.trim(),
              FormaPago: formaPago,
          };
          xhr.open("POST", "/controllers/reg_CursoComprado.php", true); // true en modo asicrono
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
  
  
        //confirm('Curso comprado exitosamente');
        setTimeout(function(){
            window.location.href = "/views/home.php";
        }, 1000); 
    
  }



function CalificarCurso(idCurso, Calificacion){

    const formLogin = document.getElementById("RegistroCurso");
    formLogin.onsubmit = function (e) {
        e.preventDefault();
        const errors = [];
  
        var idUser = document.getElementById("idUser").value;
  
        let finalError = '';
        if (errors.length !== 0) {
            let finalError = '';
            errors.forEach(error => finalError += error);
            alert(finalError);
            //e.preventDefault();
            return;
        }
  
        let xhr = new XMLHttpRequest();
          const curso = {
              idCurso: idCurso,
              idUser: idUser.trim(),
              Calificacion: Calificacion,
          };
          xhr.open("POST", "/controllers/calificar_Curso.php", true); // true en modo asicrono
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
  
  
        //confirm('Curso comprado exitosamente');
        setTimeout(function(){
            //window.location.href = "/views/home.php";
        }, 1000); 
    }
  }


  function ComentarCurso(idCurso){

    const formLogin = document.getElementById("RegComentario");
    formLogin.onsubmit = function (e) {
        e.preventDefault();
        const errors = [];
  
        var idUser = document.getElementById("idUser").value;
        var Comentario = document.getElementById("comentario").value;
  
        let finalError = '';
        if (errors.length !== 0) {
            let finalError = '';
            errors.forEach(error => finalError += error);
            alert(finalError);
            //e.preventDefault();
            return;
        }
  
        let xhr = new XMLHttpRequest();
          const curso = {
              idCurso: idCurso,
              idUser: idUser.trim(),
              Nombre_calificacion: " ",
              Comentario: Comentario.trim(),
          };
          xhr.open("POST", "/controllers/reg_ComentarioCurso.php", true); // true en modo asicrono
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
  
  
        //confirm('Curso comprado exitosamente');
        setTimeout(function(){
            //window.location.href = "/views/home.php";
        }, 1000); 
    }
  }


  function MensajesCurso(receptor_id){

    const formLogin = document.getElementById("RegistroCurso");
    formLogin.onsubmit = function (e) {
        e.preventDefault();
        const errors = [];
  
        let finalError = '';
        if (errors.length !== 0) {
            let finalError = '';
            errors.forEach(error => finalError += error);
            alert(finalError);
            //e.preventDefault();
            return;
        }
  
        //confirm('Curso comprado exitosamente');
        setTimeout(function(){
            window.location.href = "/views/ChatEstudiante.php?receptor_id=" + receptor_id;
        }, 1000); 
    }
  }