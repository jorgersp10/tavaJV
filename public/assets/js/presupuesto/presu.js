var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
var cliente_id = document.getElementById("cliente_id").value
const llenarTablaCuotas = document.getElementById('detalles');
var cont = 0;
total = 0;
subtotal = [];
totalVista = 0;
subtotalVista = [];

    async function renderdetalle() 
    {
        let presu_det = await getDetalles();

        if (presu_det.length>0)
        {
            presu_det.forEach(od => 
                {
                    presupuesto_id = od.id;
                    producto_id = od.producto_id;
                    productoNombre = od.producto.substring(0,40);
                    ArtCode = od.ArtCode;
                    cantidad = od.cantidad;
                    precio = od.precio;
            
                    iva = 11;
        
                    if (producto_id != "" && cantidad != "" && cantidad > 0 && precio != "")
                    {
                        console.log(precio);
                        precioFinal = precio.replaceAll(".", ",");
                        precioFinal = Number(precio);
                        console.log(precioFinal);
                        subtotal[cont] = Math.round(cantidad * precioFinal);
                        
                        total = total + subtotal[cont];                    
                        //funcion para agregar separador de miles
                        var formatNumber = {
                            separador: ".", // separador para los miles
                            sepDecimal: ',', // separador para los decimales
                            formatear: function(num) {
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
                            new: function(num, simbol) {
                                this.simbol = simbol || '';
                                return this.formatear(num);
                            }
                    }
                    
                    precio = formatNumber.new(precioFinal);
                    //totales para la vista
                    subtotalVista[cont] = formatNumber.new(subtotal[cont]);
                    totalVista = formatNumber.new(total);                    

                    var fila = '<tr class="selected" id="fila' + cont +
                        '"><td><button type="button" class="btn btn-danger btn-sm" onclick="eliminar(' + cont +
                        ');"><i class="fa fa-times fa-2x"></i></button></td> <td><input type="hidden" name="producto_id[]" value="' +
                        producto_id + '">' +ArtCode+ ' - '+ productoNombre +
                        '</td> <td><input readonly style="width:100px" type="text" id="precio[]" name="precio[]"  value="' + precio +
                        '"> </td> <td><input readonly type="number" style="width:60px" name="cantidad[]" value="' + cantidad + '"> </td> <td>Gs. ' +
                        subtotalVista[cont] + ' </td></tr>';
                    }
                    cont++;
                    limpiar();
                    totales();

                    evaluar();
                    $('#detalles').append(fila);

               
            })           
        }
    }

    async function getDetalles() 
    {
        var presu_id = document.getElementById("presuhidden_id").value;
        
        let url = '../obtenerPresupuesto/' + presu_id;
        try 
        {
            let res = await fetch(url);
            return await res.json();
        } catch (error) {
            console.log(error);
        }
    };

    window.onload =  renderdetalle();

function limpiar() {

    $("#cantidad").val("");
    $("#precio").val("");
    

}

function totales() {
    console.log("llama limp");
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

    $("#total_html").html("Gs. " + formatNumber.new(total));
    
    //total_iva=total*iva/100;
    total_iva = Math.round(total / iva);
    total_pagar = total;
    $("#total").html("Gs. " + total);
    $("#total_iva_html").html("Gs. " + formatNumber.new(total_iva));
    $("#total_pagar_html").html("Gs. " + formatNumber.new(total_pagar));
    $("#total_pagar").val(total_pagar);
    $("#total_iva").val(total_iva);
    $("#total").val(total_pagar);

}



function evaluar() {

    if (total > 0) {

        $("#guardar").show();

    } else {

        $("#guardar").hide();
    }
}

function eliminar(index) {

    total = total - subtotal[index];
    //total_iva= total*11/100;
    total_iva = Math.round(total / iva);
    total_pagar_html = total;

    $("#total_html").html("Gs." + total);
    $("#total_iva_html").html("Gs." + total_iva);
    $("#total_pagar_html").html("Gs." + total_pagar_html);
    $("#total_pagar").val(total_pagar_html);
    $("#total_iva").val(total_iva);

    $("#fila" + index).remove();
    evaluar();
}
       

   