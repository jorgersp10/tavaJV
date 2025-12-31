
const csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;
//SUCURSAL Y CAJERO
var suc_v=document.getElementById('sucursal');
var _cajero_v=document.getElementById("_cajero");


//LOTEAMIENTO Y CLIENTE
var urba_v=document.getElementById('urba');
var _cliente_v=document.getElementById("_cliente");

//MUEBLE Y CLIENTE
var mueble_v=document.getElementById('mueble');

//ACUERDO Y CLIENTE
var acuerdo_v=document.getElementById('acuerdo');

//SUCURSAL Y CAJERO
suc_v.addEventListener("change", () =>{
    let suc_val=suc_v.value
    getCajeros(suc_val)
    .then ((lista)=>{

        while(_cajero_v.firstChild){
            _cajero_v.removeChild(_cajero_v.firstChild);
        }
        console.log(lista);
        var option = document.createElement('option');
        option.value=0;
        option.text="TODOS";
        _cajero_v.appendChild(option);
        for(let i in lista.lista){
            var option = document.createElement('option');
            console.log(i);
            option.value=lista.lista[i].id;
            option.text=lista.lista[i].name;
            console.log(option);
            _cajero_v.appendChild(option);
        }
        
    })
 
});

//Acuerdo Y CLIENTE
urba_v.addEventListener("change", () =>{
    let urba_val=urba_v.value
    console.log(urba_val);
    console.log(_muestra_v);

    getClientesUrba(urba_val)
    .then ((lista)=>{

        while(_cliente_v.firstChild){
            _cliente_v.removeChild(_cliente_v.firstChild);
        }
        var option = document.createElement('option');
        option.value=0;
        option.text="TODOS";
        _cliente_v.appendChild(option);
        for(let i in lista.lista){
            var option = document.createElement('option');
            option.value=lista.lista[i].id;
            option.text=lista.lista[i].nombre+" - "+lista.lista[i].num_documento;
            _cliente_v.appendChild(option);
        }
        
    })
 
});

//MUEBLE Y CLIENTE
mueble_v.addEventListener("change", () =>{
    let mueble_val=mueble_v.value
    getClientesMue(mueble_val)
    .then ((lista)=>{

        while(_cliente_v.firstChild){
            _cliente_v.removeChild(_cliente_v.firstChild);
        }
        var option = document.createElement('option');
        option.value=0;
        option.text="TODOS";
        _cliente_v.appendChild(option);
        for(let i in lista.lista){
            var option = document.createElement('option');
            option.value=lista.lista[i].id;
            option.text=lista.lista[i].nombre+" - "+lista.lista[i].num_documento;
            _cliente_v.appendChild(option);
        }
        
    })
 
});

//ACUERDO Y CLIENTE
acuerdo_v.addEventListener("change", () =>{
    let acuerdo_val=acuerdo_v.value
    getClientesAcu(acuerdo_val)
    .then ((lista)=>{

        while(_cliente_v.firstChild){
            _cliente_v.removeChild(_cliente_v.firstChild);
        }
        var option = document.createElement('option');
        option.value=0;
        option.text="TODOS";
        _cliente_v.appendChild(option);
        for(let i in lista.lista){
            var option = document.createElement('option');
            option.value=lista.lista[i].id;
            option.text=lista.lista[i].nombre+" - "+lista.lista[i].num_documento;
            _cliente_v.appendChild(option);
        }
        
    })
 
});

async function getCajeros(suc_val) 
{
        try 
        {
            let url = 'cajeros/'+suc_val;
            let res = await fetch(url);
            return await res.json();
        } catch (error) {
            console.log(error);
        }
};

async function getClientesUrba(urba_val) 
{
        try 
        {
            let url = 'clientes/'+urba_val;      
            let res = await fetch(url);

            return await res.json();
        } catch (error) {
            console.log(error);
        }
};

async function getClientesMue(mueble_val) 
{
        try 
        {
            let url = 'clientesMue/'+mueble_val; 
            let res = await fetch(url);
            return await res.json();
        } catch (error) {
            console.log(error);
        }
};

async function getClientesAcu(acuerdo_val) 
{
        try 
        {
            let url = 'clientesAcu/'+acuerdo_val;       
            let res = await fetch(url);
            return await res.json();
        } catch (error) {
            console.log(error);
        }
};


