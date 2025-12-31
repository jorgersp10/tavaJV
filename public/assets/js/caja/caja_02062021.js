const btnBuscar_Inmueble = document.getElementById('buscar_inmueble');
const btnCalcular_cuotas = document.getElementById('calcular_cuotas');
const llenarTabla = document.getElementById('clientes_inmuebles');
const llenarTablaCuotas = document.getElementById('cuotas_inmuebles');
const cantidad_cuotas = document.getElementById('cantidad_cuotas');

btnBuscar_Inmueble.addEventListener("click", () =>{
    renderInmuebles();
});

cantidad_cuotas.addEventListener("change", () =>{
    calcularPago();
});


btnCalcular_cuotas.addEventListener("click", () =>{
    //renderCantidadCuotas();
    //renderCuotas();

});

async function renderInmuebles() 
{
    while(llenarTabla.firstChild){
        llenarTabla.removeChild(llenarTabla.firstChild);
    }
    let inmuebles = await getInmuebles();
        console.log(inmuebles.length);
        if (inmuebles.length>0){
        inmuebles.forEach(inmueble => {
            //let divPagar='div-'+inmueble.id;
            const row = document.createElement('tr')
            row.innerHTML = `                       
                <td>${inmueble.descripcion}</td>
                <td>${inmueble.moneda}</td>
                <td>${inmueble.precio}</td>        
                <td>${inmueble.fec_vto}</td> 
                <td>
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#pagarRegistro" data-id_inmueble='${inmueble.id}' data-descripcion='${inmueble.descripcion}'>
                        <i class="fa fa-times fa-1x"></i> Pagar
                    </button>
                </td> 
            `;
            llenarTabla.appendChild(row)

            });
        }else
        {let htmlSegment = `
        <h2>"                     Sin inmuebles"</h2>`;
        html += htmlSegment;

        }

}
    
async function getInmuebles() 
{
    var cli_id=document.getElementById("idcliente").value;
    
    let url = 'obtenerInmuebles/'+cli_id;
    try 
    {
        let res = await fetch(url);
        return await res.json();
    } catch (error) {
        console.log(error);
    }
};


async function renderCantidadCuotas() 
{
    for (let i = cantidad_cuotas.options.length; i >= 0; i--) {
        cantidad_cuotas.remove(i);
    }
    let cuotas = await getCuotas();

    if (cuotas.length>0){
        let primerValor = 0;
        let yaIngreso = 'NO';
        cuotas.forEach(cuota => {
                 
                const option = document.createElement('option');
                option.value = cuota.cuota_nro;
                if (yaIngreso==='NO'){
                    primerValor = cuota.cuota_nro;
                    console.log(primerValor);
                    yaIngreso = 'SI';
                }
                
                option.text = 'Pagar '+cuota.cuota_nro+' cuota';
                
                cantidad_cuotas.appendChild(option);
              
        });
        console.log('Primer Valor '+primerValor)
        renderCuotas(primerValor);
}
    };
    


async function renderCuotas(cc) 
{

    while(llenarTablaCuotas.firstChild){
        llenarTablaCuotas.removeChild(llenarTablaCuotas.firstChild);
    }
    let cuotas = await getCuotas();
    if (cuotas.length>0){

        cuotas.forEach(cuota => {
            if (cuota.cuota_nro<=cc){

                    console.log('Paso '+cuota.cuota_nro );
                    console.log('Agregando '+cc+'-'+cuota.cuota_nro );
                    const row = document.createElement('tr')
                    row.innerHTML = `                       
                        <td>${cuota.cuota_nro}</td>
                        <td>${cuota.fec_vto}</td>
                        <td>${cuota.total_cuota}</td>        
                    `;

                        llenarTablaCuotas.appendChild(row)
   
                }
             })

    }else
    {let htmlSegment = `
    <h2>"                     Sin inmuebles"</h2>`;
    html += htmlSegment;

    }

}

async function getCuotas() 
{
    var inm_id=document.getElementById("id_inmueble").value;
    
    let url = 'obtenerCuotas/'+inm_id;
    try 
    {
        let res = await fetch(url);
        return await res.json();
    } catch (error) {
        console.log(error);
    }
};

function calcularPago(){
    const indice = cantidad_cuotas.selectedIndex;
    if(indice === -1) return; // Esto es cuando no hay elementos
    const opcionSeleccionada = cantidad_cuotas.options[indice];
    renderCuotas(opcionSeleccionada.value);

}

$('#pagarRegistro').on('show.bs.modal', function (event) {
        
    /*el button.data es lo que está en el button de editar*/
    var button = $(event.relatedTarget)
    
    var id_inmueble_modal = button.data('id_inmueble')
    var descripcion = button.data('descripcion')

    var modal = $(this)
    // modal.find('.modal-title').text('New message to ' + recipient)
    /*los # son los id que se encuentran en el formulario*/
    modal.find('.modal-body #id_inmueble').val(id_inmueble_modal);
    modal.find('.modal-body #descripcion').val(descripcion);
    renderCantidadCuotas();
})