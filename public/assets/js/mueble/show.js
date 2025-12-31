$(function() {
    //var lot_id=document.getElementById("loteamiento_id_hidden").value;
    //document.getElementById("loteamiento_id").value = lot_id;

    var mon_id=document.getElementById("moneda_id_hidden").value;
    document.getElementById("moneda").value = mon_id;

    const addImagen=document.getElementById("addImagen")
    const tokens_form= document.getElementsByName("_token");
    var token_form=tokens_form[0].value;
    renderImages();
    addImagen.addEventListener("submit", e =>{
        e.preventDefault();
        putImages();
    });


    async function getImages() 
    {
        // var inm_id=document.getElementById("id_inmueble_hidden").value;
        // let url = '/imagen/'+inm_id;
        // try 
        // {
        //     let res = await fetch(url);
        //     return await res.json();
        // } catch (error) {
        //     console.log(error);
        // }
    };

    async function renderImages() 
    {
        // let images = await getImages();
        // let html = '';
        // images.forEach(image => {
        //     let urlImagen='http:\\storage/img/inmuebles/'+image.imagen;
        //     let imagenBorrar='borrarImagen-'+image.id;
        //     let divBorrar='div-'+image.id;
        //     let htmlSegment = `
        //                         <div id="${divBorrar}" class="button-borrar">
        //                         <img src="${urlImagen}" id="imagen-${image.id}" alt="" class="galeria-img">
                                
        //                         <button type="button"  id="${imagenBorrar}" class="button-borrar">Borrar</button>
        //                         </div>
        //                     `;

        //     html += htmlSegment;
        //     });
           

        // let container = document.querySelector('.contenedor-galeria');
        // container.innerHTML = html;
        
        // const buttonsb = document.querySelectorAll('button.button-borrar')
        // buttonsb.forEach(b =>{
        //     b.addEventListener("click", () => {
        //         var idim = b.id.replace("borrarImagen-", "");
        //         document.getElementById('div-'+idim).className = 'eliminado'
        //         var idim = b.id.replace("borrarImagen-", "");
        //         //let url = 'http://127.0.0.1:8000/imagen/'+idim;
        //         let url = '../inmueble/imagen/'+idim;
        //         console.log(url)
  
        //             $.ajax(
        //             {
        //                 url: url,
        //                 type: 'POST',
        //                 dataType: "JSON",
        //                 data: {
        //                     "id": idim,
        //                     "_method": 'POST',
        //                     "_token": token_form,
        //                 },
        //                 success: function ()
        //                 {
        //                     console.log("it Work");
        //                 },
        //                 error: function (e)
        //                 {
        //                     console.log(e);
        //                 }
                        
        //             });
        //     })
        // })
    };

    async function putImages() 
    {
        ///////// Sacando las variables de la pagina ////////
        var inm_id=document.getElementById("id_inmueble_hidden").value;
        const formData = new FormData();
        
        const imagen_agregar =document.getElementById("imagen_agregar");

        formData.append('_token',token_form);
        formData.append('id_inmueble',inm_id);
        formData.append('imagen',imagen_agregar.files[0]);

        let url = '/imagen';
   
        $.ajax({
            method: "POST",
            processData: false,  // tell jQuery not to process the data
            contentType: false,  
            url: url,
            data: formData,
            success: function (response) {
                console.log(response);
                renderImages();
            },
            error : function (error){
                console.log(error);
            }
        });
    }
})
