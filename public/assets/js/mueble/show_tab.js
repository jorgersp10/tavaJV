const targets  = document.querySelectorAll('[data-target]')
const contents = document.querySelectorAll('[data-content]')
const tokens_form= document.getElementsByName("_token");
var token_form=tokens_form[0].value;


targets.forEach(target =>{
    target.addEventListener('click', () => {
        contents.forEach(c =>{
            c.classList.remove('active')
        })
        const t = document.querySelector(target.dataset.target)
        t.classList.add('active')
        console.log(t)


        if (t.id=="men_ven") {
            $('#idcliente').select2({
                placeholder:'Busca por Nombre, CI o Telefono'
            });

                    var CSRF_TOKEN = token_form;
                    $(document).ready(function(){
                        $('#idcliente').select2({
                            ajax:{
                                url:"../getClientesVen",
                                type: 'post',
                                dataType: 'json',
                                delay: 200,
                                data: function(params){
                                    return{
                                        _token: CSRF_TOKEN,
                                        search:params.term
                                    }
                                },
                                processResults: function(response){
                                    return{
                                        results: response
                                    }
                                },
                                cache: true
                            }
                        });
                    });

        }

    })
})

