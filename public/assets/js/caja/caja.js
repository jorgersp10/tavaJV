const btnBuscar_Inmueble = document.getElementById('buscar_inmueble');
const btnCalcular_cuotas = document.getElementById('calcular_cuotas');
const llenarTabla = document.getElementById('clientes_inmuebles');
const llenarTablaCuotas = document.getElementById('cuotas_inmuebles');

const id_cuota_modal = document.getElementById('id_cuota');

const total_apag = document.getElementById('total_apag');
const total_pagadof = document.getElementById('total_pagadof');
const total_pagadoch = document.getElementById('total_pagadoch');
const total_pagadotd = document.getElementById('total_pagadotd');
const total_pagadotc = document.getElementById('total_pagadotc');
const total_vuelto = document.getElementById('total_vuelto');
const titulo_pago = document.getElementById('titulo_pago');
const form_pago=document.getElementById('form_pago');

const cuotas_apag = document.getElementById('cuotas_apag');


btnBuscar_Inmueble.addEventListener("click", () =>{
    renderInmuebles();
});

cuotas_apag.addEventListener("change", () =>{
    calcularPago();
});

total_pagadof.addEventListener("change", () =>{
    var modal = $('#pagarRegistro');
    let vuelto=total_pagadof.value-total_apag.value;
    if (vuelto>0)
         modal.find('.modal-body #total_vuelto').val(vuelto);
        else
        modal.find('.modal-body #total_vuelto').val(0);
    endif
});

total_pagadoch.addEventListener("change", () =>{
    var modal = $('#pagarRegistro');
    
    if (total_pagadoch.value>total_apag.value)
         modal.find('.modal-body #total_pagadoch').val(total_apag.value);
        else
        modal.find('.modal-body #total_pagadoch').val(total_pagadoch.value);

});
//*********** Obetener inmuebles y mostrar en pantalla de caja  ******************/
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
async function renderInmuebles() 
{
    while(llenarTabla.firstChild){
        llenarTabla.removeChild(llenarTabla.firstChild);
    }
    //separador de miles
    var formatNumber = {
        separador: ".", // separador para los miles
        sepDecimal: ',', // separador para los decimales
        formatear:function (num){
        num +='';
        var splitStr = num.split('.');
        var splitLeft = splitStr[0];
        //var splitRight = splitStr.length > 1 ? this.sepDecimal + splitStr[1] : '';
        var regx = /(\d+)(\d{3})/;
        while (regx.test(splitLeft)) {
        splitLeft = splitLeft.replace(regx, '$1' + this.separador + '$2');
        }
        return this.simbol + splitLeft;
        },
        new:function(num, simbol){
        this.simbol = simbol ||'';
        return this.formatear(num);
        }
    }
    let productos = await getInmuebles();
         console.log(productos.length);
        if (productos.length>0){
            productos.forEach(cuota => {
            //let divPagar='div-'+inmueble.id;
            let cuotaF = formatNumber.new(cuota.precio_inm);
            const row = document.createElement('tr')
            row.innerHTML = `                       
                <td>${cuota.factura}</td>
                <td> Gs. ${cuotaF}</td>                  
                <td>${cuota.fec_vto}</td> 
                <td>
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" 
                    data-bs-target="#pagarRegistro" 
                    data-id_cuota='${cuota.id}'
                    data-producto='${cuota.factura_id}'>
                        <i class="fa fa-times fa-1x"></i> Cobrar
                    </button>
                </td> 
            `;
            llenarTabla.appendChild(row)

            });
        }else{
            const row = document.createElement('tr')
            row.innerHTML = `   
        <h4>"Sin Deudas"</h4>`;
        llenarTabla.appendChild(row)
        }
}
//**********************************************************************/




//*********** Obetener cuotas y mostrar en pantalla  ******************/
async function getCuotas(cliente_v) 
{
    let url = "";
    
    if (cliente_v!=0){
        url = 'obtenerCuotas/'+cliente_v;
    }
    
    try 
    {
        let res = await fetch(url);
        return await res.json();
    } catch (error) {
        console.log(error);
    }
};

async function renderCuotas(cc) 
{
    while(llenarTablaCuotas.firstChild){
        llenarTablaCuotas.removeChild(llenarTablaCuotas.firstChild);
    }

    let cuotas = await getCuotas(id_cuota_modal.value);
 
    let cuotas_can=1;
    let cuotas_pen=0;
    let cuotas_ven=1;
    let total_a_pagar=0;
     //separador de miles
     var formatNumber = {
        separador: ".", // separador para los miles
        sepDecimal: ',', // separador para los decimales
        formatear:function (num){
        num +='';
        var splitStr = num.split('.');
        var splitLeft = splitStr[0];
        //var splitRight = splitStr.length > 1 ? this.sepDecimal + splitStr[1] : '';
        var regx = /(\d+)(\d{3})/;
        while (regx.test(splitLeft)) {
        splitLeft = splitLeft.replace(regx, '$1' + this.separador + '$2');
        }
        return this.simbol + splitLeft;
        },
        new:function(num, simbol){
        this.simbol = simbol ||'';
        return this.formatear(num);
        }
    }
    if (cuotas.length>0){

        cuotas.forEach(cuota => {
            if (cuotas_can<=cc){
                    let totalcuotaF = formatNumber.new(cuota.total_cuota);
                    let total_cF = formatNumber.new(cuota.total_c);
                    const row = document.createElement('tr')

                    row.innerHTML = `                       
                        <td>${cuota.cuota_nro}</td>
                        <td>${cuota.fec_vto}</td>
                        <td>${totalcuotaF}</td>    
                        <td>${cuota.mora}</td>  
                        <td>${cuota.punitorio}</td> 
                        <td>${cuota.iva}</td> 
                        <td>${total_cF}</td>    
                    `;
                        llenarTablaCuotas.appendChild(row);
                        total_a_pagar=total_a_pagar+cuota.total_c;
                        
                        cuotas_can++;
                }
                if (cuota.estado_cuota==='P'){
                    cuotas_pen++;
                }

             })
             mostrar(cuotas_pen,cuotas_ven,total_a_pagar)

           
    }else
    {let htmlSegment = `
    <h2>"                     Sin inmuebles"</h2>`;
    html += htmlSegment;
    }
}
//**********************************************************************/

function calcularPago(){
    renderCuotas(cuotas_apag.value);
    
}


function mostrar(cuotas_pen,cuotas_ven,total_a_pagar) {

    var formatNumber = {
        separador: ".", // separador para los miles
        sepDecimal: ',', // separador para los decimales
        formatear: function (num) {
            num += '';
            var splitStr = num.split('.');
            var splitLeft = splitStr[0];
            //var splitRight = splitStr.length > 1 ? this.sepDecimal + splitStr[1] : '';
            var regx = /(\d+)(\d{3})/;
            while (regx.test(splitLeft)) {
                splitLeft = splitLeft.replace(regx, '$1' + this.separador + '$2');
            }
            return this.simbol + splitLeft;
        },
        new: function (num, simbol) {
            this.simbol = simbol || '';
            return this.formatear(num);
        }
    }

    var modal = $('#pagarRegistro');
    modal.find('.modal-body #cuotas_max').val(cuotas_pen);
    modal.find('.modal-body #cuotas_ven').val(cuotas_ven);
    modal.find('.modal-body #total_apag').val(formatNumber.new(total_a_pagar));
    modal.find('.modal-body #total_pagadof').val(formatNumber.new(total_a_pagar));
    modal.find('.modal-body #total_pagadoch').val(0);
    modal.find('.modal-body #nro_cheque').val(0);
    modal.find('.modal-body #total_pagadotd').val(0);
    modal.find('.modal-body #total_pagadotc').val(0);
    modal.find('.modal-body #total_vuelto').val(0);

    if (id_cuota_modal.value!=0){
        titulo_pago.innerHTML="Cobrar Factura";
    }
   
}

$('#pagarRegistro').on('show.bs.modal', function (event) {
        
    /*el button.data es lo que está en el button de editar*/
    var button = $(event.relatedTarget)
    
    var id_cuota_modal = button.data('id_cuota')
    var producto = button.data('producto')
    var cap = 1;

    var modal = $(this)
    // modal.find('.modal-title').text('New message to ' + recipient)
    /*los # son los id que se encuentran en el formulario*/
    modal.find('.modal-body #id_cuota').val(id_cuota_modal);
    modal.find('.modal-body #producto').val(producto);
    modal.find('.modal-body #cuotas_apag').val(cap);

    if (id_cuota_modal.value!=0){
        titulo_pago.innerHTML="Pagar Prestamos";
    }
   
    
    renderCuotas(cuotas_apag.value,id_cuota_modal.value);
})


$("#boton_guardar").on("click",function(event){
    event.preventDefault();
    var fecha_pago = document.getElementById("fec_pag").value;
    console.log(fecha_pago);
    if (fecha_pago == "") {
        Swal.fire({
            type: 'error',
            title: 'Cuidado',
            text: 'Favor ingrese fecha de pago!'
        })

    } else{
        swal.fire({
            title: '¿Seguro que desea realizar el pago?',
            type: 'success',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: '¡Si, Pagar!'
        }).then((result) => {
            if (result.value) {
                document.getElementById("form_pago").submit();
            }
        });
    }
        
    
});

