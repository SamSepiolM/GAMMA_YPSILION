$(document).ready(function(){
    $(".categorie").select2({
        placeholder: "Selecciona una categoria", //placeholder
        tags: true,
        tokenSeparators: ['/',',',';'," "] 
    });


});

function validacionCurso(){

  const formLogin = document.getElementById("RegistroCurso");
  formLogin.onsubmit = function (e) {
      e.preventDefault();
      const errors = [];

      var title=document.getElementById("titulo").value;
      var description=document.getElementById("description").value;
      var gradeCurse=document.getElementById("grade").value;
      var priceCurse=document.getElementById("precio").value;
      var catCurse=document.getElementById("categorie").options;

      var idCurso = 0;
      //console.log(catCurse);
      
      var categorie_selected = [];
        for (var option of document.getElementById("categorie").options)
        {
            if (option.selected) {
                categorie_selected.push(option.value);
            }
        }
        console.log(categorie_selected);

      var idUser = document.getElementById("idUser").value;

      if (title===''){
          errors.push(' - Favor de llenar el titulo\n');
      }
      if (description===''){
          errors.push(' - Favor de llenar la descripcion\n');
      }
      if (gradeCurse==='Selecciona el grado'){
          errors.push(' - Favor de seleccionar el grado\n');
      }

      if (priceCurse===''){
        errors.push(' - Favor de ingresar el precio del curso\n');
      }
      var ExpReg = /^\d*\.\d+$/;
      var validacion = ExpReg.test(priceCurse);
      if (validacion != true){
          errors.push(' - Formato de precio no valido\n');
      }

      
      if (catCurse === ''){
        errors.push(' - Favor de seleccionar una categoria\n');
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
        const curso = {
            Titulo_Curso: title.trim(),
            Descripcion_Curso: description.trim(),
            Grado_Curso: gradeCurse.trim(),
            Precio_Curso: priceCurse.trim(),
            //Categoria_Curso: catCurse.trim(),
            Categoria_Curso: categorie_selected,

            Creador_Curso: idUser.trim(),
            Estado_Curso: 1
            
        };
        xhr.open("POST", "/controllers/reg_Curso.php", true); // true en modo asicrono
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
                    idCurso = res.id;
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


      //confirm('Curso registrado exitosamente');
      setTimeout(function(){
        if(idCurso != 0){
            window.location.href = "/views/uploadCurse.php?idCurso=" + idCurso;
        }
        
      }, 1000); 
  }
}