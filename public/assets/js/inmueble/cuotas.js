///////////// Traemos las variables del formulario //////////////////
    const cuotas_arr_i = document.getElementById('cuotas_arr');
    const monto = document.getElementById('precio_inm');
    const entrega = document.getElementById('entrega');
    const tiempo = document.getElementById('tiempo');
    const interes = document.getElementById('interes');
    const refuerzo = document.getElementById('refuerzo');
    const can_ref = document.getElementById('can_ref');
    //const interes = document.getElementById('interes');
    const btnCalcular = document.getElementById('btnCalcular');
    const btnCalcularSI = document.getElementById('btnCalcularSI');
    const llenarTabla = document.getElementById('cuotero');
    const valor_ref = document.getElementById('refuerzo');
    //
    const valor_cuota = document.getElementById('cuo_imp');
    const valor_iva = document.getElementById('iva_imp');
    const valor_int = document.getElementById('int_imp');
    const valor_tot= document.getElementById('tot_imp');
    const valor_des= document.getElementById('des_imp');
    const tokens_form= document.getElementsByName("_token");
    var token_form=tokens_form[0].value;
///////////// -------------------------------/////////////////
var locality = 'es-ES';

///////// Evitamos el submit Cuando presionamos el Calcular con IVA /////////////
    btnCalcular.addEventListener("submit", e =>{
        e.preventDefault();
    });
    btnCalcular.addEventListener("click", () =>{
        //e.preventDefault();
        let tipoCalculo='CON_IVA';
        calcularCuota(monto.value, interes.value, tiempo.value, entrega.value, tipoCalculo);
    });
///////////////// -------------------------------///////////////////////////////

///////// Evitamos el submit Cuando presionamos el Calcular sin IVA /////////////
    btnCalcularSI.addEventListener("submit", e =>{
        e.preventDefault();
    });

    btnCalcularSI.addEventListener("click", () =>{
        //e.preventDefault();
        let tipoCalculo='SIN_IVA';
        calcularCuota(monto.value, interes.value, tiempo.value, entrega.value, tipoCalculo);
    });
///////////////// -------------------------------///////////////////////////////

//////////////////////// Calculamos la cuota /////////////////////////////
function calcularCuota(monto, interes, tiempo, entrega, tipoCalculo){

    /// Si hay entrega el monto a calcular es el monto menos lo que se entrega
    monto=monto-entrega;

    /// interes es igual a interes mensual se verifica que no sea 0 
    if (interes>0){
        interes=interes/12;
    }

    /// Aca calcularemos el iva del total de los intereses
    if (tipoCalculo=='CON_IVA')
    {
        if (interes>0){
            let montoi=monto;
            let montoia=monto;            
            let pagoInteresi=0, pagoIvai=0,pagoCapitali = 0, cuotai, contador = 0;
            let totalInteresi=0,totalIvai=0, totalPagoi=0,entregadoi=0,entro1=0;
            /// Vamos a calcular cuotas hasta que el monto del prestamo sea mayor al 
            /// desembolso
            while (monto>=entregadoi)
            {
                totalInteresi=0
                totalIvai=0
                totalPagoi=0
                entregadoi=0

                cuotai = montoi * (Math.pow(1+interes/100, tiempo)*interes/100)/(Math.pow(1+interes/100, tiempo)-1);
                cuotai = cuotai.toFixed();
                cuotai = (cuotai/1000).toFixed(); 
                cuotai = (Math.round(cuotai)*1000)+0; 

                for(let i = 1; i <= tiempo; i++) 
                {
                    pagoInteresi = parseFloat(montoi*(interes/100));
                    pagoCapitali = cuotai - pagoInteresi;
                    pagoIvai = pagoInteresi*0.1;
                    montoi = parseFloat(montoi-pagoCapitali);
                    if (i==tiempo){
                        if (montoi!=0){
                            pagoCapitali=pagoCapitali+montoi;
                            cuotai=cuotai+montoi;
                        }
                    }
                    totalInteresi= totalInteresi+(pagoInteresi);
                    totalPagoi=totalPagoi+pagoCapitali;
                    totalIvai=totalIvai+pagoIvai;
                }


                entregadoi=totalPagoi-totalIvai;
            
                contador++;
                if (entro1==0)
                {
                    montoia=montoia+totalIvai;
                    entro1=1;
                }
                    else
                {
                    montoia=montoia+1000;
                }
                montoi=montoia;
            }
            monto=montoi;

        }
    
        /////////////////////////////////////////////////////////////////////
      
    }
    
    while(llenarTabla.firstChild){
        llenarTabla.removeChild(llenarTabla.firstChild);
    }

    let fechas = [];
    let cuotas_arr = [];
    let fechaActual = Date.now();
    let mes_actual = moment(fechaActual);
    mes_actual.add(1, 'month'); 
    
    let pagoInteres=0, pagoCapital = 0, cuota = 0,totalIva=0, totalInteres=0, totalCapital=0, entregado=0;
    if (interes>0){
        cuota = monto * (Math.pow(1+interes/100, tiempo)*interes/100)/(Math.pow(1+interes/100, tiempo)-1);

         cuota = cuota.toFixed()
         cuota = (cuota/1000).toFixed();
         cuota = (Math.round(cuota)*1000); 
         //cuota = (Math.round(cuota)*1000)+0; 
  
    }else{
        
        cuota= monto/tiempo;
    }
    //// Calculamos cuota si hay refuerzos
    if (refuerzo.value>0){
        let cuotasum=0;
        cuotasum=cuota*tiempo;
        cuotasum=cuotasum-(refuerzo.value*can_ref.value)
        cuotasum=cuotasum/tiempo;


    }
    cuo_imp.value=cuota;
   
    for(let i = 1; i <= tiempo; i++) {
        if (interes>0){
            pagoInteres = parseFloat(monto*(interes/100));
        }else
        {
            pagoInteres = 0;
        }
        pagoCapital = cuota - pagoInteres;
        if (tipoCalculo=="CON_IVA"){
            pagoIva = pagoInteres*0.1;
        }else{
            pagoIva = 0;
        }
        
        monto = parseFloat(monto-pagoCapital);
        if (i==tiempo){
            if (monto!=0){
                pagoCapital=pagoCapital+monto;
                cuota=cuota+monto;
            }
        }
        totalInteres= totalInteres+(pagoInteres);
        totalIva= totalIva+(pagoIva);
        totalCapital= totalCapital+(pagoCapital);
        
        //Formato fechas
        fechas[i] = mes_actual.format('DD-MM-YYYY');
        mes_actual.add(1, 'month');

        const row = document.createElement('tr')
        row.dataset.id=i
        if (tipoCalculo=="CON_IVA"){
            entregado=totalCapital-totalIva;
        }else
        {
            entregado=totalCapital;
        }
        

        cap=pagoCapital.toLocaleString(locality,{minimumFractionDigits: 2 })
        int=pagoInteres.toLocaleString(locality,{minimumFractionDigits: 2 })
        iva=pagoIva.toLocaleString(locality,{minimumFractionDigits: 2 })
        cuo=cuota.toLocaleString(locality,{minimumFractionDigits: 2 })
        mon=monto.toLocaleString(locality,{minimumFractionDigits: 2 })
        row.innerHTML = `
            <td data-field="id">${i}</td>
            <td data-field="fecha_ven">${fechas[i]}</td>
            <td data-field="capital">${cap}</td>
            <td data-field="interes">${int}</td>
            <td data-field="interes">${iva}</td>
            <td data-field="cuota">${cuo}</td>
            <td data-field="saldo">${mon}</td>
            <td style="width: 100px">
                <a class="btn btn-outline-secondary btn-sm edit" title="Edit">
                    <i class="fas fa-pencil-alt"></i>
                </a>
            </td>
        `;
        fec_vto=fechas[i];
        llenarTabla.appendChild(row)
        cuotas_arr[i]={
            fec_vto,
            cap,
            int,
            iva
        };
        //cuotas_arr_i.value=cuotas_arr;
    }

    ////
    
    cuotas_arr_i.value=JSON.stringify(cuotas_arr);
    ////
    valor_iva.value=totalIva;
    valor_int.value=totalInteres;
    valor_tot.value=totalCapital+totalInteres;
    valor_des.value=totalCapital-totalIva;
    
    row = document.createElement('tr')

        //row.style="cursor:pointer";
        row.innerHTML = `
            <td data-field="id">Total</td>
            <td data-field="fecha_ven"></td>
            <td data-field="capital">${totalCapital}</td>
            <td data-field="interes">${totalInteres}</td>
            <td data-field="interes">${totalIva}</td>
            <td data-field="cuota">0</td>
            <td data-field="saldo">${entregado}</td>
            <td style="width: 100px">
                <a class="btn btn-outline-secondary btn-sm edit" title="Edit">
                    <i class="fas fa-pencil-alt"></i>
                </a>
            </td>
        `;
        llenarTabla.appendChild(row)
}
