function CreateCat(){

    const createC = document.getElementById("RegistroCategoria");

  
    createC.onsubmit = function (e) {
        e.preventDefault();
        const errors = [];

       
    
        const RegistroCat = document.getElementById("RegCat").value;
        const RegistroCatCon = document.getElementById("RegCatCon").value;
        const RegistroCatDes = document.getElementById("RegCatDes").value;
        var Creador_categoria = document.getElementById("idUser").value;
 
        if (RegistroCat === ''){
            errors.push(' - Favor de llenar el nombre de categoria\n');
        }
        if (RegistroCatDes === ''){
            errors.push(' - Favor de llenar la descripcion de categoria\n');
        }
        if (RegistroCatCon === ''){
            errors.push(' - Favor de confirmar la categoria\n');
        }
        if (RegistroCat != RegistroCatCon){
            errors.push(' - Las categorias ingresadas no coinciden\n');
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
            Nombre_categoria: RegistroCat.trim(),
            Descripcion_categoria: RegistroCatDes.trim(),
            Creador_categoria: Creador_categoria.trim(),
        };
        xhr.open("POST", "/controllers/reg_Categoria.php", true); // true en modo asicrono
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

function UpgradeCat(){

    const upgradeC = document.getElementById("EdicionCategoria");

  
    upgradeC.onsubmit = function (e) {
        e.preventDefault();
        const errors = [];

        const IdEditarCat = document.getElementById("UpgCatId").value;
        const EditarCat = document.getElementById("UpgCat").value;
        const EditarCatCon = document.getElementById("UpgCatCon").value;
        const EditarCatDes = document.getElementById("UpgCatDes").value;
 
        console.log(IdEditarCat);
        if (IdEditarCat === ''){
            errors.push(' - Favor de llenar la de categoria\n');
        }
        
        if (EditarCat === ''){
            errors.push(' - Favor de llenar el nombre de categoria\n');
        }
        if (EditarCatDes === ''){
            errors.push(' - Favor de llenar la descripcion de categoria\n');
        }
        if (EditarCatCon === ''){
            errors.push(' - Favor de confirmar la categoria\n');
        }
        if (EditarCat != EditarCatCon){
            errors.push(' - Las categorias ingresadas no coinciden\n');
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
            Nombre_categoria: EditarCat.trim(),
            Descripcion_categoria: EditarCatDes.trim(),
            idCategoria: IdEditarCat.trim(),
        };
        xhr.open("POST", "/controllers/edit_Categoria.php", true); // true en modo asicrono
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

//

function DeleteCat(){

    const deleteC = document.getElementById("EliminarCategoria");
  
    deleteC.onsubmit = function (e) {
        e.preventDefault();
        const errors = [];

        const IdEliminarCat = document.getElementById("DelCatId").value;
        
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
            Nombre_categoria: ' 0',
            idCategoria: IdEliminarCat.trim(),
            EstadoCategoria: 0,
        };
        xhr.open("POST", "/controllers/delete_Categoria.php", true); // true en modo asicrono
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

// 