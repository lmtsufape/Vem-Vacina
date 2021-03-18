<x-guest-layout>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    

    <div style="padding-bottom: 0rem;padding-top: 1rem;; margin-top: -15%; background-color: #fff;"> 
        <img src="img/cabecalho_1.png" alt="Orientação" width="100%"> 
        <div class="container">
            <img src="img/cabecalho_2.png" alt="Orientação" width="100%">
        </div>
    </div>
    <div class="container" style="margin-bottom: 1rem;background-color: #fff;">
        <div class="row justify-content-center">
            <!-- cadastro -->
            <div class="col-md-9 style_card_apresentacao">
                <div class="container" style="padding-top: 10px;;">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row" style="text-align: center;">
                                <div class="col-md-12" style="margin-top: 20px;margin-bottom: 10px;">
                                    <img src="img/logo_programa_1.png" alt="Orientação" width="300px"> 
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 style_titulo_campo">Solicitar a vacinação</div>
                        <div class="col-md-12"><hr class="style_linha_campo"></div>
                        <div class="col-md-12" style="font-size: 15px; margin-bottom: 15px;">Lorem Ipsum é simplesmente uma simulação de texto da indústria tipográfica e de impressos, e vem sendo utilizado desde o século XVI, quando um impressor desconhecido pegou uma bandeja de tipos e os embaralhou para fazer um livro de modelos de tipos. Lorem Ipsum sobreviveu não só a cinco séculos, como também ao salto para a editoração eletrônica, permanecendo essencialmente inalterado. </div>
                        <div class="col-md-12 style_titulo_campo" style="margin-bottom: 10px;">Informações pessoais</div>
                        <div class="col-md-12">
                            <form method="POST" action="{{ route('solicitacao.candidato.enviar') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="inputNome" class="style_titulo_input">NOME COMPLETO <span class="style_subtitulo_input">(obrigatório)</span> </label>
                                        <input type="text" class="form-control style_input @error('nome_completo') is-invalid @enderror" id="inputNome" placeholder="Digite seu nome completo" name="nome_completo" value="{{old('nome_completo')}}"> 
                                    
                                        @error('nome_completo')
                                            <div id="validationServer05Feedback" class="invalid-feedback">
                                                <strong>{{$message}}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputData" class="style_titulo_input">DATA DE NASCIMENTO <span class="style_subtitulo_input">(obrigatório)</span> </label>
                                        <input type="date" class="form-control style_input @error('data_de_nascimento') is-invalid @enderror" id="inputData" placeholder="dd/mm/aaaa" pattern="[0-9]{2}/[0-9]{2}/[0-9]{4}" name="data_de_nascimento" value="{{old('data_de_nascimento')}}">
                                    
                                        @error('data_de_nascimento')
                                            <div id="validationServer05Feedback" class="invalid-feedback">
                                                <strong>{{$message}}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputCPF" class="style_titulo_input">CPF <span class="style_subtitulo_input">(obrigatório)</span> </label>
                                        <input type="text" class="form-control style_input cpf @error('cpf') is-invalid @enderror" id="inputCPF" placeholder="Ex.: 000.000.000-00" name="cpf" value="{{old('cpf')}}">
                                    
                                        @error('cpf')
                                            <div id="validationServer05Feedback" class="invalid-feedback">
                                                <strong>{{$message}}</strong>
                                            </div>
                                        @enderror
                                    </div> 
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputCartaoSUS" class="style_titulo_input">NÚMERO DO CARTÃO SUS </label>
                                        <input type="text" class="form-control style_input sus @error('número_cartão_sus') is-invalid @enderror" id="inputCartaoSUS" placeholder="000 0000 0000 0000" name="número_cartão_sus" value="{{old('número_cartão_sus')}}">
                                    
                                        @error('número_cartão_sus')
                                            <div id="validationServer05Feedback" class="invalid-feedback">
                                                <strong>{{$message}}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputSexo" class="style_titulo_input">SEXO <span class="style_subtitulo_input">(obrigatório)</span> </label>
                                        <select id="inputSexo" class="form-control style_input @error('sexo') is-invalid @enderror" name="sexo">
                                            <option selected disabled>-- Selecione o sexo --</option>
                                            @foreach($sexos as $sexo)
                                                <option value="{{$sexo}}" @if (old('sexo') == $sexo) selected @endif>{{$sexo}}</option>
                                            @endforeach
                                        </select>

                                        @error('sexo')
                                            <div id="validationServer05Feedback" class="invalid-feedback">
                                                <strong>{{$message}}</strong>
                                            </div>
                                        @enderror
                                    </div> 
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="inputNomeMae" class="style_titulo_input">NOME COMPLETO DA MÃE <span class="style_subtitulo_input">(obrigatório)</span> </label>
                                        <input type="text" class="form-control style_input @error('nome_da_mãe') is-invalid @enderror" id="inputNomeMae" placeholder="Digite o nome completo da mãe" name="nome_da_mãe" value="{{old('nome_da_mãe')}}">
                                    
                                        @error('nome_da_mãe')
                                            <div id="validationServer05Feedback" class="invalid-feedback">
                                                <strong>{{$message}}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="foto_rg_frente" class="style_titulo_input">FOTO DA FRENTE DO RG <span class="style_subtitulo_input">(obrigatório)</span></label>
                                        <input id="foto_rg_frente" class="form-control style_input @error('foto_frente_rg') is-invalid @enderror" type="file" name="foto_frente_rg" required>
                                    
                                        @error('foto_frente_rg')
                                            <div id="validationServer05Feedback" class="invalid-feedback">
                                                <strong>{{$message}}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="foto_rg_tras" class="style_titulo_input">FOTO DO VERSO DO RG <span class="style_subtitulo_input">(obrigatório)</span></label>
                                        <input id="foto_rg_tras"  class="form-control style_input @error('foto_tras_rg') is-invalid @enderror" type="file" name="foto_tras_rg" required>
                                    
                                        @error('foto_tras_rg')
                                            <div id="validationServer05Feedback" class="invalid-feedback">
                                                <strong>{{$message}}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="style_titulo_campo" style="margin-bottom: -2px;">Outras informações</div>
                                    <div style="font-size: 15px; margin-bottom: 15px;">Lorem Ipsum é simplesmente uma simulação de texto da indústria tipográfica e de impressos, e vem sendo utilizado desde o século XVI.</div>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input @error('paciente_acamado') is-invalid @enderror" type="checkbox" id="defaultCheck1" name="paciente_acamado" @if(old('paciente_acamado')) checked @endif>
                                    <label class="form-check-label style_titulo_input" for="defaultCheck1">PACIENTE É ACAMADO </label>
                                
                                    @error('paciente_acamado')
                                        <div id="validationServer05Feedback" class="invalid-feedback">
                                            <strong>{{$message}}</strong>
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input @error('paciente_agente_de_saude') is-invalid @enderror" type="checkbox" id="defaultCheck2" onclick="funcaoVinculoComAEquipeDeSaudade()" name="paciente_agente_de_saude" @if(old('paciente_agente_de_saude')) checked @endif>
                                    <label class="form-check-label style_titulo_input" for="defaultCheck2">PACIENTE TEM VÍNCULO COM A EQUIPE DE SAÚDE DA FAMÍLIA (AGENTE DE SAÚDE)</label>
                                    
                                    @error('paciente_agente_de_saude')
                                        <div id="validationServer05Feedback" class="invalid-feedback">
                                            <strong>{{$message}}</strong>
                                        </div>
                                    @enderror
                                    
                                    <div class="form-group" style="@if(old('paciente_agente_de_saude')) display: block; @else display: none; @endif" id="id_div_nomeDaUnidade">
                                        <label for="inputNomeUnidade" class="style_titulo_input" style="font-weight: normal;">Qual o nome da sua unidade (caso tenha vínculo) </label>
                                        <input type="text" class="form-control @error('unidade_caso_agente_de_saude') is-invalid @enderror" id="inputNomeUnidade" placeholder="Digite o nome da sua unidade (caso tenha vínculo)" name="unidade_caso_agente_de_saude" value="{{old('unidade_caso_agente_de_saude')}}">
                                        
                                        @error('unidade_caso_agente_de_saude')
                                            <div id="validationServer05Feedback" class="invalid-feedback">
                                                <strong>{{$message}}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="style_titulo_campo" style="margin-top: 8px; margin-bottom: -2px;">Contato</div>
                                    <div style="font-size: 15px; margin-bottom: 15px;">Lorem Ipsum é simplesmente uma simulação de texto da indústria tipográfica e de impressos, e vem sendo utilizado desde o século XVI.</div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputTelefone" class="style_titulo_input">TELEFONE <span class="style_subtitulo_input">(obrigatório)</span></label>
                                        <input type="text" class="form-control style_input celular @error('telefone') is-invalid @enderror" id="inputTelefone" placeholder="Digite o número do seu telefone" name="telefone" value="{{old('telefone')}}">
                                    
                                        @error('telefone')
                                            <div id="validationServer05Feedback" class="invalid-feedback">
                                                <strong>{{$message}}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputCelular" class="style_titulo_input">WHATSAPP </label>
                                        <input type="text" class="form-control style_input celular @error('whatsapp') is-invalid @enderror" id="inputCelular" placeholder="Digite o número do seu whatsapp" name="whatsapp" value="{{old('whatsapp')}}">
                                    
                                        @error('whatsapp')
                                            <div id="validationServer05Feedback" class="invalid-feedback">
                                                <strong>{{$message}}</strong>
                                            </div>
                                        @enderror
                                    </div> 
                                </div>
                                {{-- <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail" class="style_titulo_input">E-MAIL</label>
                                        <input type="email" class="form-control style_input" id="inputEmail" placeholder="Digite o seu e-mail" name="email" value="{{old('email')}}">
                                    </div>
                                </div> --}}
                                <div class="form-group">
                                    <div class="style_titulo_campo" style="margin-top: 8px; margin-bottom: -2px;">Endereço</div>
                                    <div style="font-size: 15px; margin-bottom: 15px;">Lorem Ipsum é simplesmente uma simulação de texto da indústria tipográfica e de impressos, e vem sendo utilizado desde o século XVI.</div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputCidade" class="style_titulo_input">CIDADE <span class="style_subtitulo_input">(obrigatório)</span> </label>
                                        <input id="inputCidade" class="form-control style_input @error('cidade') is-invalid @enderror" name="cidade" value="{{old('cidade')}}"> 
                                    
                                        @error('cidade')
                                            <div id="validationServer05Feedback" class="invalid-feedback">
                                                <strong>{{$message}}</strong>
                                            </div>
                                        @enderror
                                    </div> 
                                    <div class="form-group col-md-6">
                                        <label for="inputBairro" class="style_titulo_input">BAIRRO <span class="style_subtitulo_input">(obrigatório)</span> </label>
                                        <input id="inputBairro" class="form-control style_input @error('bairro') is-invalid @enderror" name="bairro" value="{{old('bairro')}}">
                                    
                                        @error('bairro')
                                            <div id="validationServer05Feedback" class="invalid-feedback">
                                                <strong>{{$message}}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputrua" class="style_titulo_input">RUA <span class="style_subtitulo_input">(obrigatório)</span></label>
                                        <input type="text" class="form-control style_input @error('rua') is-invalid @enderror" id="inputrua" placeholder="Digite o nome da rua, avenida, travessa..." name="rua" value="{{old('rua')}}">
                                    
                                        @error('rua')
                                            <div id="validationServer05Feedback" class="invalid-feedback">
                                                <strong>{{$message}}</strong>
                                            </div>
                                        @enderror
                                    </div> 
                                    <div class="form-group col-md-6">
                                        <label for="inputNumeroResidencia" class="style_titulo_input">NÚMERO DA RESIDÊNCIA <span class="style_subtitulo_input">(obrigatório)</span></label>
                                        <input type="text" class="form-control style_input @error('número_residencial') is-invalid @enderror" id="inputNumeroResidencia" placeholder="Digite o nome da residência" name="número_residencial" value="{{old('número_residencial')}}">
                                    
                                        @error('número_residencial')
                                            <div id="validationServer05Feedback" class="invalid-feedback">
                                                <strong>{{$message}}</strong>
                                            </div>
                                        @enderror
                                    </div> 
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="inputComplemento" class="style_titulo_input">COMPLEMENTO </label>
                                        <textarea type="text" class="form-control style_input @error('complemento_endereco') is-invalid @enderror" id="inputComplemento" placeholder="" rows="3" name="complemento_endereco">{{old('complemento_endereco')}}</textarea>
                                    
                                        @error('complemento_endereco')
                                            <div id="validationServer05Feedback" class="invalid-feedback">
                                                <strong>{{$message}}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div><hr></div>
                                
                                <div class="col-md-12" style="margin-bottom: 30px;">
                                    <div class="row">
                                        <div class="col-md-6"></div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <!--<div class="col-md-6" style="padding:3px">
                                                    <button class="btn btn-light" style="width: 100%;margin: 0px;">Cancelar</button>
                                                </div>-->
                                                <div class="col-md-12" style="padding:3px">
                                                    <button class="btn btn-success" style="width: 100%;">Enviar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9"  style="text-align: center;line-height: 19px;font-size: 15px;margin-top: 1rem;margin-bottom: 2rem;"><a href="http://lmts.uag.ufrpe.br/" style="color: #909090;">Programa de vacinação criado pelo Laboratório Multidisciplinar de Tecnologias Sociais - LMTS com o apoio da Universidade Federal do Agreste de Pernambuco - UFAPE.</div>
        </div>
    </div>

    <!-- rodapé -->
    <div style="background-color:#BDC3C7; display: flex; flex-wrap: wrap; justify-content: center;padding-bottom:5rem">
        <div class="row" style="margin-top:1rem;text-align:center">
            <hr class="col-md-12" size = 7 style="background-color:#fff">
            <div class="col-md-4">
                <div class="row justify-content-center" style="text-align:center; margin-bottom:2rem;">
                    <div class="col-12" style="margin-bottom: 10px; color:#fff;">Desenvolvido por:</div>
                    <img src="img/logo_lmts_p_branco.png" alt="LMTS" width="200px"> 
                </div>
            </div>
            <div class="col-md-4">
                <div class="row justify-content-center" style="text-align:center; margin-bottom:2rem;">
                    <div class="col-12" style="color:#fff;">Apoio:</div>
                    <img src="img/logo_ufape_branco.png" alt="UFAPE" width="240px"> 
                </div>
            </div>
            <div class="col-md-4">
                <div class="row justify-content-center" style="text-align:center">
                    <div class="col-12" style="margin-bottom: 2rem; color:#fff;">Redes sociais:</div>
                    <img src="img/logo_facebook_branco.png" width="40px" height="40px" style="margin-left: 10px; margin-right: 10px;">
                    <img src="img/logo_instagram_branco.png" width="40px" height="40px" style="margin-left: 10px; margin-right: 10px;">
                    <img src="img/logo_twitter_branco.png" width="40px" height="40px" style="margin-left: 10px; margin-right: 10px;">
                </div>
            </div>
        </div>
    </div>
    <!--x rodapé x-->

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
                // Handle key press
                key = theEvent.keyCode || theEvent.which;
                key = String.fromCharCode(key);
            }
            var regex = /[0-9]|\./;
            if( !regex.test(key) ) {
                theEvent.returnValue = false;
                if(theEvent.preventDefault) theEvent.preventDefault();
                return;
            }
   
            // enquanto não tiver suficiente, deixa preencher
            if(input.value.length < 7) {
                theEvent.returnValue = true;
                return;
            }
   
            // caso já esteja preenchido, não adiciona mais numeros
            if(input.value.length === 8) {
                theEvent.returnValue = false;
                return;
            }
            
            // colocou o ultimo valor do cep
            theEvent.returnValue = true;
   
   
            // pega o valor do cep
            let cep = input.value + key;
   
   
            let url = "http://" + document.location.host + "/cep/" + cep;
            console.log(url);
            
            fetch(url).then((resposta) => {
                return resposta.json();
            }).then((json) => {
   
                if(json.resultado != 1) {
                    // todo: erro
                    return;
                }
   
                document.getElementById("cidade").value = json.cidade;
                document.getElementById("bairro").value = json.bairro;
                document.getElementById("rua").value = json.tipo_rua + " " + json.rua;
   
            });
        }

        function funcaoVinculoComAEquipeDeSaudade(){
            if(document.getElementById("id_div_nomeDaUnidade").style.display == "none"){
                document.getElementById("id_div_nomeDaUnidade").style.display = "block";
                document.getElementById("inputNomeUnidade").value = "";
                
            }else{
                document.getElementById("id_div_nomeDaUnidade").style.display = "none";
                document.getElementById("inputNomeUnidade").value = "";
                document.getElementById("inputNomeUnidade").placeholder = "Digite o nome da sua unidade (caso tenha vínculo)";
            }
        }
        
       </script>
</x-guest-layout>
