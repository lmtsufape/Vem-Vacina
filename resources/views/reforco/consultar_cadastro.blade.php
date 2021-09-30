<x-guest-layout>
    

    <div style="padding-bottom: 0rem;padding-top: 1rem; margin-top: -15%; background-color: #fff;">
        <img src="{{asset('img/cabecalho_1.png')}}" alt="Orientação" width="100%">
        <div class="container">
            <img src="{{asset('img/cabecalho_2.png')}}" alt="Orientação" width="100%">
        </div>
    </div>
    <div class="container" style="margin-bottom: 1rem;background-color: #fff;">
        <div class="row justify-content-center">
            <!-- cadastro -->
            <div class="col-md-9 style_card_apresentacao">
                <div class="container" style="padding-top: 10px;">
                    <form action="{{ route('reforco.verificar') }}" method="get">
                        {{-- @csrf --}}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row" style="text-align: center;">
                                    <div class="col-md-12" style="margin-top: 20px;margin-bottom: 10px;">
                                        <img src="{{asset('img/logo_vem_vacina.png')}}" alt="Orientação" width="300px">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 style_titulo_campo">Solicitar Vacinação da Dose de Reforço</div>
                            <div class="col-md-12"><hr class="style_linha_campo"></div>
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12">
                                        @if (session('status'))
                                            <div class="alert alert-danger">
                                                {{ session('status') }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        <label for="inputCPF" class="style_titulo_input">CPF <span class="style_titulo_campo">*</span><span class="style_subtitulo_input"> (obrigatório)</span> </label>
                                        <input type="text" class="form-control style_input cpf @error('cpf') is-invalid @enderror" id="inputCPF" placeholder="Ex.: 000.000.000-00" name="cpf" value="{{old('cpf')}}">
        
                                        @error('cpf')
                                        <div id="validationServer05Feedback" class="invalid-feedback">
                                            <strong>{{$message}}</strong>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        
                                        <label for="inputData" class="style_titulo_input">DATA DE NASCIMENTO <span class="style_titulo_campo">*</span><span class="style_subtitulo_input"> (obrigatório)</span> </label>
                                        <input type="date" class="form-control style_input @error('data_de_nascimento') is-invalid @enderror" id="inputData" placeholder="dd/mm/aaaa" pattern="[0-9]{2}/[0-9]{2}/[0-9]{4}" name="data_de_nascimento" value="{{old('data_de_nascimento')}}">
        
                                        @error('data_de_nascimento')
                                        <div id="validationServer05Feedback" class="invalid-feedback">
                                            <strong>{{$message}}</strong>
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-12">
        
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <button type="submit" class="btn btn-success" style="width: 100%;" >Consultar Cadastro</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <!-- rodapé -->
    <div style="background-color:#313561; display: flex; flex-wrap: wrap;">
        <div class="container">
            <div class="row">
              <div class="col-sm">
                <div class="row justify-content-center" style="text-align:center; margin-bottom:1rem;margin-top: 1.5rem;">
                    <div class="col-12" style="margin-bottom: 45px; color:#fff;font-weight: 600;font-family: Arial, Helvetica, sans-serif;"><img src="{{asset('img/logo_rede_sociais.png')}}" alt="LMTS" width="20px"> Redes Sociais</div>
                    <a href="https://www.facebook.com/PrefeituradeGaranhuns/" target="_blank"><img src="{{asset('img/facebook.png')}}" alt="LMTS" width="55px"> </a>
                    <a href="https://twitter.com/garanhunspref" target="_blank"><img src="{{asset('img/twitter.png')}}" alt="LMTS" width="55px"> </a>
                    <a href="https://www.instagram.com/prefgaranhuns/" target="_blank"><img src="{{asset('img/instagram.png')}}" alt="LMTS" width="55px"> </a>
                    <a href="https://www.youtube.com/channel/UCHNqCIPyK42cjWUgO85C7Yg" target="_blank"><img src="{{asset('img/youtube.png')}}" alt="LMTS" width="43px" height="43x" style="margin-top: 4.5px;margin-left: 4px;"></a>
                </div>
              </div>
              <div class="col-sm">
                <div class="form-group justify-content-center" style="text-align:center; margin-bottom:1rem;margin-top: 1.5rem;">
                    <div style="color:#fff;font-weight: 600;font-family: Arial, Helvetica, sans-serif;"><img src="{{asset('img/logo_fale_conosco.png')}}" alt="LMTS" width="15px"> Fale Conosco</div>
                    <div style="color:#fff; font-size: 30px; font-weight: 600; font-family: Arial, Helvetica, sans-serif; margin-top:20px">(87) 3762-1252</div>
                    <div style="color:#fff; font-size: 18px; font-weight: 100; font-family: Arial, Helvetica, sans-serif; margin-top:6px">agendamentovacinacovidgus@gmail.com</div>

                </div>
              </div>
              <div class="col-sm">
                <div class="form-group justify-content-center" style="text-align:center; margin-bottom:1rem;margin-top: 1.5rem;">
                    <div style="color:#fff;font-weight: 600;font-family: Arial, Helvetica, sans-serif;">Desenvolvido por:</div>
                    <div class="btn-group">
                        <div style="margin-top: 21px;margin-right: 15px;"><a href="http://ufape.edu.br/" target="_blank"><img src="{{asset('img/logo_ufape.png')}}" alt="LMTS" width="165px"> </a></div>
                        <div style="margin-top: 35px;"><a href="http://lmts.uag.ufrpe.br/" target="_blank"><img src="{{asset('img/logo_lmts.png')}}" alt="LMTS" width="140px"> </a></div>
                    </div>
                </div>
              </div>
              <div class="col-sm-12" style="text-align: center; margin-bottom: 2rem;margin-top: 1rem;">
                <a href="https://garanhuns.pe.gov.br/mapa-do-site/" target="_blank" style="margin-left: 15px;margin-right: 15px; color: #fff;text-decoration:none; ">MAPA DO SITE</a>
                <a href="https://garanhuns.pe.gov.br/teclas-de-acessibilidade/" target="_blank" style="margin-left: 15px;margin-right: 15px; color: #fff;text-decoration:none; ">TECLAS DE ACESSIBILIDADE</a>
                <a href="https://garanhuns.pe.gov.br/telefones-uteis/" target="_blank" style="margin-left: 15px;margin-right: 15px; color: #fff;text-decoration:none; ">TELEFONES ÚTEIS</a>

              </div>
            </div>
          </div>
    </div>

    <!--x rodapé x-->
    @if ( old('público') != null)
        <script>
            $(document).ready(function() {
                var radio = document.getElementById('publico_{{old('público')}}');
                postoPara(radio, radio.value);
            });
        </script>
    @endif
    @if (env('ATIVAR_FILA', false) == true)
    <script>
        $(document).ready(function() {
            $('input:radio[name=público]').change(
                function() {
                    var inputs = document.getElementsByName('público');
                    for (var i = 0; i < inputs.length; i++) {
                        //  console.log(this);
                        // console.log(this.value);
                        if (document.getElementById("divPublico_"+inputs[i].value)) {
                            var div = document.getElementById("divPublico_"+inputs[i].value);
                            var select = document.getElementById("publico_opcao_"+inputs[i].value);

                            if(div.style.display == "none" && inputs[i].value == this.value){
                                div.style.display = "block";
                                select.value = "";
                            }else{
                                div.style.display = "none";
                                select.value = "";
                            }
                        }

                        if (document.getElementById("divOutrasInformacoes_"+inputs[i].value)) {
                            var div = document.getElementById("divOutrasInformacoes_"+inputs[i].value);

                            if (div.style.display == "none" && inputs[i].value == this.value) {
                                div.style.display = "block";
                            } else {
                                div.style.display = "none";
                            }
                        }

                    }
                    //descomentar quando desativar a fila
                    // postoPara(this, this.value);
                }
            )
        });
    </script>
    @else
    <script>
        $(document).ready(function() {
            $('input:radio[name=público]').change(
                function() {
                    var inputs = document.getElementsByName('público');
                    for (var i = 0; i < inputs.length; i++) {
                        //  console.log(this);
                        // console.log(this.value);
                        if (document.getElementById("divPublico_"+inputs[i].value)) {
                            var div = document.getElementById("divPublico_"+inputs[i].value);
                            var select = document.getElementById("publico_opcao_"+inputs[i].value);

                            if(div.style.display == "none" && inputs[i].value == this.value){
                                div.style.display = "block";
                                select.value = "";
                            }else{
                                div.style.display = "none";
                                select.value = "";
                            }
                        }

                        if (document.getElementById("divOutrasInformacoes_"+inputs[i].value)) {
                            var div = document.getElementById("divOutrasInformacoes_"+inputs[i].value);

                            if (div.style.display == "none" && inputs[i].value == this.value) {
                                div.style.display = "block";
                            } else {
                                div.style.display = "none";
                            }
                        }

                    }
                    //descomentar quando desativar a fila
                    postoPara(this, this.value);
                }
            )
        });
    </script>
    @endif

    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function() {
          'use strict';
          window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
              form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                  event.preventDefault();
                  event.stopPropagation();
                }
                form.classList.add('was-validated');
              }, false);
            });
          }, false);
        })();
    </script>


    <script>
        const buttonSend = document.getElementById('buttonSend');
        const formSolicitar = document.getElementById('formSolicitar');
        if(buttonSend){
            buttonSend.addEventListener('click', (e)=>{
                e.target.innerText = "Aguarde...";
                e.target.setAttribute("disabled", "disabled");

                formSolicitar.submit()
            })
        }



    </script>


    <script>
     function checkbox_visibilidade(div_alvo, checkbox) {
         if(checkbox.checked) {
             div_alvo.style.display = "block";
         } else {
             div_alvo.style.display = "none";
         }
     }


     function buscar_CEP(input, evt) {
         let theEvent = evt || window.event;

         if(evt.keyCode == 8) {
             theEvent.returnValue = true;
             return;
         }

         let key = "";
         if (theEvent.type === 'paste') {
         } else {
             /* Handle key press */
             key = theEvent.keyCode || theEvent.which;
             key = String.fromCharCode(key);
         }
         var regex = /[0-9]|\./;
         if( !regex.test(key) ) {
             theEvent.returnValue = false;
             if(theEvent.preventDefault) theEvent.preventDefault();
             return;
         }

         /* enquanto não tiver suficiente, deixa preencher */
         if(input.value.length < 7) {
             theEvent.returnValue = true;
             return;
         }

         /* caso já esteja preenchido, não adiciona mais numeros */
         if(input.value.length === 8) {
             theEvent.returnValue = false;
             return;
         }

         /* colocou o ultimo valor do cep */
         theEvent.returnValue = true;


         /* pega o valor do cep */
         let cep = input.value + key;

         requisitar_preenchimento_cep(cep);

     }


     function requisitar_preenchimento_cep(cep) {

         if(!cep) {return;}

         cep = cep.match(/\d+/g, '').join("");

         if(cep.length != 8) {return;}

         let url = window.location.toString().replace("solicitar", "cep/" + cep);
         /* console.log(url); */

         fetch(url).then((resposta) => {
             return resposta.json();
         }).then((json) => {

             if(json.resultado != 1) {
                 /* todo: erro */
                 return;
             }

            /*  document.getElementById("inputCidade").value = json.cidade; */
             /* document.getElementById("inputBairro").value = json.bairro; */
             document.getElementById("inputrua").value = json.tipo_logradouro + " " + json.logradouro;

         });
     }

     function funcaoVinculoComAEquipeDeSaudade(input){
        if(document.getElementById("id_div_nomeDaUnidade").style.display == "none"){
            document.getElementById("id_div_nomeDaUnidade").style.display = "block";
            document.getElementById("inputNomeUnidade").value = "";
        }else{
            document.getElementById("id_div_nomeDaUnidade").style.display = "none";
            document.getElementById("inputNomeUnidade").value = "";
            document.getElementById("inputNomeUnidade").placeholder = "Digite o nome da sua unidade (caso tenha vínculo)";


        }
        postoPara(input);
     }

    /* function funcaoMostrarOpcoes(input, id) {
        var div = document.getElementById("divPublico_"+id);
        var select = document.getElementById("publico_opcao_"+id);
        alert(div);
        if(div.style.display == "none" && div != null){
            div.style.display = "block";
            select.value = "";
        }else{
            div.style.display = "none";
            select.value = "";
        }
        postoPara(input, id);
     } */




     function selecionar_posto(posto_selecionado) {
         let id_posto = posto_selecionado.value;
         let div_seletor_horararios = document.getElementById("seletor_horario");
         div_seletor_horararios.innerHTML = "Buscando horários disponíveis...";
         let url = window.location.toString().replace("solicitar", "horarios/" + id_posto);
        //  console.log(url);

         /* Mágia de programação funcional */
         fetch(url).then((dados) => {
             if(dados.status != 200) {
                 div_seletor_horararios.innerHTML = "Ocorreu um erro, tente novamente mais tarde";
             } else {
                 return dados.body;
             }
         }).then(rb => {
             const reader = rb.getReader();
             return new ReadableStream({
                 start(controller) {
                     function push() {
                         reader.read().then( ({done, value}) => {
                             if (done) {
                                 controller.close();
                                 return;
                             }
                             controller.enqueue(value);
                             push();
                         })
                     }
                     push();
                 }
             });
         }).then(stream => {
             return new Response(stream, { headers: { "Content-Type": "text/html" } }).text();
         }).then(result => {
             div_seletor_horararios.innerHTML = result;
         });

     }



     function selecionar_dia_vacinacao(select_dia) {
         Array.from(document.getElementsByClassName("seletor_horario_dia_div")).forEach((div) => {
             div.style.display = "none";
             let select_horarios = div.children[0].children[0].children[1];
             select_horarios.name = "";
             select_horarios.required = false;
         });

         if(!select_dia.value) {return;}
         let div = document.getElementById("seletor_horario_dia_" + select_dia.value);
         let select_horarios = div.children[0].children[0].children[1];
         div.style.display = "block";
         select_horarios.name = "horario_vacinacao";
         select_horarios.id = "horario_vacinacao";
         select_horarios.required = true;
     }

    function postoPara(input, id) {

            valor = input.checked;
            var btnForm = document.getElementById('buttonSend');
            var divLocal = document.getElementById("div_local");
            var loading = document.getElementById("loading");
            divLocal.style.display = "none";
            loading.style.display = "block";
            btnForm.disabled = true;

            $.ajax({
                url: "{{route('postos')}}",
                method: 'get',
                type: 'get',
                data: {
                    publico_id: function () {
                        if (valor) {
                            return id;
                        } else {
                            return 0;
                        }
                    }
                },
                statusCode: {
                    404: function() {
                        alert("Nenhum posto encontrado");
                        btnForm.disabled = false;
                    },
                    500: function() {
                        btnForm.disabled = false;
                    }
                },

                success: function(data){
                    //  console.log( data)
                    if(data.length <= 0 && data != null){
                        console.log('posto');
                        const buttonSend = document.getElementById('buttonSend');
                        buttonSend.innerText = "Enviar para fila de Espera";
                        divLocal.style.display = "none";
                        const input = '<input id="input_fila" type="hidden" name="fila" value="true">';
                        $("#formSolicitar").append(input);
                        document.getElementById("alerta_vacinas").style.display = "block";
                        loading.style.display = "none";
                        /* alert('Não existe vacinas para esse público, se continuar o preenchimento você irá para a fila de espera') */
                    }else{
                        document.getElementById("alerta_vacinas").style.display = "none";
                        if(document.getElementById("input_fila") != null){
                            document.getElementById("input_fila").remove();
                        }
                        buttonSend.innerText = "Enviar";
                        document.getElementById("div_local").style.display = "block";
                        loading.style.display = "none";
                    }
                    if (data != null && typeof data != 'string') {

                        var option = '<option selected disabled>-- Selecione o posto --</option>';
                        if (data.length > 0) {
                            $.each(data, function(i, obj) {
                                option += '<option value="' + obj.id + '">' + obj.nome + '</option>';
                            })
                        }

                        document.getElementById("posto_vacinacao").innerHTML = option;
                    }

                    btnForm.disabled = false;
                }
            })



    }
    </script>


</x-guest-layout>

