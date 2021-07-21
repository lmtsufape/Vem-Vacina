<x-guest-layout>
    <body style="background-color: #FBFBFB;">
        <div style="padding-bottom: 0rem;padding-top: 1rem;; margin-top: -15%;">
            <img src="{{asset('/img/cabecalho_1.png')}}" alt="Orientação" width="100%">
            <div class="container">
                <a href="{{route('index')}}">
                    <img src="{{asset('/img/cabecalho_2.png')}}" alt="Orientação" width="100%">
                </a>
            </div>
        </div>
        @auth
            <div class="container">
                <div class="row justify-content-center">
                    <!-- pessoas vacinadas -->
                    <div class="style_card_menor">
                        <div class="card_menor">
                            <div class="card-header style_card_menor_titulo" style=" border-top-left-radius: 12px;border-top-right-radius: 12px;">DOSES APLICADAS</div>
                            <div class="container" style="padding-top: 10px;;">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-12 style_card_menor_conteudo">{{$quantPessoasPriDose + $quantPessoasSegDose}}</div>
                                            <div class="col-md-12 style_card_menor_legenda">TOTAL</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- primeira dose -->
                    <div class="style_card_menor">
                        <div class="card_menor">
                            <div class="card-header style_card_menor_titulo" style=" border-top-left-radius: 12px;border-top-right-radius: 12px;">1º DOSE</div>
                            <div class="container" style="padding-top: 10px;;">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-12 style_card_menor_conteudo">{{$quantPessoasPriDose}}</div>
                                            <div class="col-md-12 style_card_menor_legenda">TOTAL DE PESSOAS VACINADAS</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- segunda dose -->
                    <div class="style_card_menor">
                        <div class="card_menor">
                            <div class="card-header style_card_menor_titulo" style=" border-top-left-radius: 12px;border-top-right-radius: 12px;">2º DOSE</div>
                            <div class="container" style="padding-top: 10px;;">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-12 style_card_menor_conteudo">{{$quantPessoasSegDose}}</div>
                                            <div class="col-md-12 style_card_menor_legenda">TOTAL DE PESSOAS VACINADAS</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- dose unica -->
                    <div class="style_card_menor">
                        <div class="card_menor">
                            <div class="card-header style_card_menor_titulo" style=" border-top-left-radius: 12px;border-top-right-radius: 12px;">DOSE ÚNICA</div>
                            <div class="container" style="padding-top: 10px;;">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-12 style_card_menor_conteudo">{{$quantPessoasDoseUnica}}</div>
                                            <div class="col-md-12 style_card_menor_legenda">TOTAL DE PESSOAS VACINADAS</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- pessoas cadastradas -->
                    <div class="style_card_menor">
                        <div class="card_menor">
                            <div class="card-header style_card_menor_titulo" style=" border-top-left-radius: 12px;border-top-right-radius: 12px;">PESSOAS CADASTRADAS</div>
                            <div class="container" style="padding-top: 10px;;">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-12 style_card_menor_conteudo">{{$quantPessoasCadastradas}}</div>
                                            <div class="col-md-12 style_card_menor_legenda">TOTAL</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    {{-- <!-- imunizacao -->
                    <div class="style_card_menor">
                        <div class="card_menor">
                            <div class="card-header style_card_menor_titulo" style=" border-top-left-radius: 12px;border-top-right-radius: 12px;">IMUNIZAÇÃO *</div>
                            <div class="container" style="padding-top: 10px;;">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-12 style_card_menor_conteudo">{{number_format($porcentagemVacinada, '2', ',', ' ')}}%</div>
                                            <div class="col-md-12 style_card_menor_legenda">POPULAÇÃO VACINADA (%)</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="text-align: center; margin-top: 10px;">
                            <a style="color: #01487E; font-weight: bold; cursor: pointer" data-toggle="modal" data-target="#imunizacao">Clique aqui para saber mais</a>
                        </div>
                    </div> --}}
                </div>
            </div>


            {{-- <div class="container">
                <div class="row justify-content-center">
                    <!-- pessoas vacinadas -->
                    <div class="card_media2">
                        <div class="card_menor2">
                            <div class="card-header style_card_menor_titulo" style=" border-top-left-radius: 12px;border-top-right-radius: 12px;">GARANHUNS/PE</div>
                            <div class="container" style="padding-top: 10px;;">
                                <div style="margin-left:-15px;margin-right:-15px">
                                    <a href="https://www.google.com/maps/place/Garanhuns+-+PE/@-8.9365336,-36.6418746,11z/data=!3m1!4b1!4m5!3m4!1s0x7070ce9b301ca65:0x8e6141e4b9b7632d!8m2!3d-8.8828551!4d-36.4969127"  target='_blank' style="font-size:12px;color:#909090">
                                        <div class="col-md-12" style="margin-top:5px;">
                                            <img src="{{asset('img/mapa_garanhuns.png')}}" alt="LMTS" width="100%">
                                        </div>
                                        <div class="col-md-12" style="text-align:center;">
                                            Clique na imagem para acessar o Google Maps
                                        </div>
                                    </a>
                                </div>
                                <div class="row">
                                    <div class="col-md-12" style="margin-top:10px; margin-bottom: -20px;">
                                        <p style="font-weight: 700; color: #01487E;">POPULAÇÃO: <span style="font-weight: 500; color: #FF545A;">140.570 hab *</span></p>
                                    </div>
                                    <div class="col-md-12">
                                        <p style="font-weight: 700;color: #01487E;">Nº TOTAL DE VACINADOS: <span style="font-weight: 500;color: #FF545A;">{{$quantPessoasPriDose + $quantPessoasSegDose}}</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="margin-top: 10px;"><a style="color: #01487E; font-weight: 500;"><samp style="color: #FF545A;">*</samp> Fonte: estatística IBGE/2020</a></div>
                    </div>

                    <!-- os 5 bairros mais vacinados -->
                    <div class="card_media2">
                        <div class="card_menor2">
                            <div class="card-header style_card_menor_titulo" style=" border-top-left-radius: 12px;border-top-right-radius: 12px;">OS 5 BAIRROS MAIS VACINADOS</div>
                            <div class="container" style="padding-top: 10px; padding-bottom: 5px;">
                                <div style="position: relative;
                                height: 255px;
                                overflow: auto;">
                                    <table class="table ">
                                        <thead>
                                        <tr style=" color: #204788; font-weight: bold;">
                                            <th scope="col">#</th>
                                            <th scope="col">BAIRRO</th>
                                            <th scope="col" style="text-align: center;">VACINADOS</th>
                                        </tr>
                                        </thead>
                                        <tbody style=" color: #204788;">
                                            @php
                                                $posicao = 1;
                                            @endphp
                                            @foreach ($quantVacinadosPorBairro as $i => $bairroVacinados)
                                                @if($posicao < 6)
                                                    <tr>
                                                        <th scope="row" style="color: #FF545A;">{{$posicao++}}º</th>
                                                        <td>{{$bairroVacinados['bairro']}}</td>
                                                        <td style="text-align: center;">{{$bairroVacinados['quantidade']}}</td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container">
                <div class="row justify-content-center">
                    <!-- vacinados por idade -->
                    <div class="card_media2">
                        <div class="card_menor2">
                            <div class="card-header style_card_menor_titulo" style=" border-top-left-radius: 12px;border-top-right-radius: 12px;">VACINADOS POR IDADE (%)</div>
                            <div class="container" style="padding-top: 10px;;">
                                <div style="position: relative;
                                height: 255px;
                                overflow: auto;">
                                    <table class="table ">
                                        <thead style="text-align: center;">
                                        <tr style=" color: #204788; font-weight: bold;">
                                            <th scope="col">IDADE</th>
                                            <th scope="col" style="text-align: center;">VACINADOS (%)</th>
                                        </tr>
                                        </thead>
                                        <tbody style=" color: #204788; text-align: center;">
                                            @foreach ($quantVacinadosPorIdade as $vacinadosDaIdade)
                                                <tr>
                                                    <td>{{$vacinadosDaIdade['idade']}}</td>
                                                    <td style="text-align: center;">{{number_format($vacinadosDaIdade['porcentagem'], '2', ',', ' ')}}%</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- doses aplicadas por sexo -->
                    <div class="card_media2">
                        <div class="card_menor2">
                            <div class="card-header style_card_menor_titulo" style=" border-top-left-radius: 12px;border-top-right-radius: 12px;">DOSES APLICADAS POR SEXO</div>
                            <div class="container" style="padding-top: 10px; padding-bottom: 5px;">
                                <div style="position: relative;
                                height: 249px;
                                overflow: auto;">

                                <!-- grafico -->
                                <div style="margin-top: 1rem;">
                                    <canvas id="graficoSexo"></canvas>
                                </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    
                </div>
            </div> --}}

            <div class="container" style="text-align: center; margin-top:2rem; margin-bottom: 4rem;">
                <p style="color: #204788; font-weight: bold;">Última atualização dos dados: {{date('d/m/Y \à\s  H:i\h', strtotime($ultimaAtt))}}</p>
            </div>
        @endauth

        @guest
            <a href="{{route('index')}}">
                <div class="d-flex align-items-center flex-column" style="height: 29rem;">
                    <div class="p-2 mt-4 bd-highlight text-warning">
                        <i class="fas fa-exclamation-triangle fa-8x"></i>
                    </div>
                    <div class="p-2 bd-highlight text-black">
                        <h3>
                            Seção de informações em Manutenção
                        </h3>
                    </div>
                    
                </div>
            </a>
        @endguest
        

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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.js"></script>
    </body>

    {{-- <!-- Modal -->
    <div class="modal fade" id="imunizacao" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 12px;">
            <div class="modal-header" style="background-color: #FF545A; color: #fff; border-top-left-radius: 12px; border-top-right-radius: 12px; ">
            <h5 class="modal-title" id="exampleModalLabel">IMUNIZAÇÃO</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <div class="container" style="padding-top: 10px;;">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12 style_card_menor_conteudo" style="font-size: 70px;">{{number_format($porcentagemVacinada, '2', ',', ' ')}}%</div>
                                <div class="col-md-12 style_card_menor_legenda">POPULAÇÃO VACINADA</div>
                                <div class="col-md-12 style_card_menor_legenda" style="text-align: justify; margin-top: -0.3rem;">O percentual é calculado por uma regra de três simples, utilizando o número da população total estimada pelo IBGE/2020, cruzado com a informação das pessoas vacinadas cadastradas no vem vacina.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal" style="padding-left: 5rem; padding-right: 5rem;">Fechar</button>
            </div>
        </div>
        </div>
    </div> --}}

    <!-- Modal checar agendamento -->
    <div class="modal fade" id="modalChecarAgendamento" tabindex="-1" aria-labelledby="modalChecarAgendamentoLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="border-radius: 12px;">
            <div class="modal-header" style="background-color: #FF545A; color: #fff; border-top-left-radius: 12px; border-top-right-radius: 12px; ">
                <h5 class="modal-title" id="modalChecarAgendamentoLabel">CONSULTAR AGENDAMENTO</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <form id="consultar_agendamento" action="{{route('agendamento.consultar')}}" method="POST">
                    @csrf
                    <div class="container">
                        <input type="hidden" name="consulta" value="1">
                        <div class="row">
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
                                {{-- <label for="dose" class="style_titulo_input">QUAL A DOSE? <span class="style_subtitulo_input">*(obrigatório)</span></label>
                                <select id="dose" class="form-control style_input @error('dose') is-invalid @enderror" name="dose" required>
                                    <option selected disabled>-- Selecione a dose --</option>
                                    <option @if(old('dose') == $doses[0]) selected @endif value="{{$doses[0]}}">{{$doses[0]}}</option>
                                    <option @if(old('dose') == $doses[1]) selected @endif value="{{$doses[1]}}">{{$doses[1]}}</option>
                                </select>

                                @error('dose')
                                <div id="validationServer05Feedback" class="invalid-feedback">
                                    <strong>{{$message}}</strong>
                                </div>
                                @enderror --}}
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
                            <div class="col-md-6">

                            </div>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-success" style="width: 100%;" form="consultar_agendamento">Consultar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        </div>
    </div>
    <!-- Fim modal checar agendamento -->
    @if (old('consulta') != null)
        <script>
            $(document).ready(function() {
                $("#modalChecarAgendamento").modal('show');
            });
        </script>
    @endif
    <script>
        /* let graficoImunizados = document.getElementById("graficoImunizados").getContext("2d");

        let chart = new Chart(graficoImunizados, {
                type:"line",
                data:{
                labels:['22/03', '23/03', '24/03', '25/03', '26/03', '27/03', '28/03', '29/03', '30/03', '31/03', '01/04'],

                datasets:[{
                    label:"Imunizados",
                    data:[175, 150, 125, 100, 50, 25, 0, 25, 75, 110, 55],
                    backgroundColor:'#C9EAFF',
                    borderColor:'#1492E6',
                }]
            }
        }); */
        

        
    </script>
</x-guest-layout>
