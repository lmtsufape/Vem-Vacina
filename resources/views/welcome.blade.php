<x-guest-layout>
    <body style="background-color: #FBFBFB;">
        <div style="padding-bottom: 0rem;padding-top: 1rem;; margin-top: -15%;">
            <img src="{{asset('/img/cabecalho_1.png')}}" alt="Orientação" width="100%">
            <div class="container">
                <img src="{{asset('/img/cabecalho_2.png')}}" alt="Orientação" width="100%">
            </div>
        </div>
        <div class="container" style="margin-bottom: 1rem;;">
            <div class="row justify-content-center">
                <!-- covid-19 programa de vacinacao -->
                <div class="col-md-9 style_card_apresentacao">
                    <div class="container" style="padding-top: 10px;;">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row" style="text-align: center;">
                                    <div class="col-md-12" style="margin-top: 20px;margin-bottom: 10px;">
                                        <img src="{{asset('/img/logo_vem_vacina.png')}}" alt="Orientação" width="40%">
                                    </div>
                                    <div class="col-md-12 style_card_apresentacao_subtitulo">A plataforma “Vem Vacina Garanhuns” é a ferramenta oficial da Secretaria de Saúde de Garanhuns, desenvolvida em parceria com a Universidade Federal do Agreste de Pernambuco, para cadastro e agendamento da vacinação contra a Covid-19.</div>
                                </div>
                            </div>
                            <div class="col-md-12" style="margin-bottom: 32px;">
                                <div class="row ">
                                    <div class="col-md-12 style_card_apresentacao_solicitar_vacina text-center">SOLICITAR MINHA DOSE DE REFORÇO</div>
                                    <div class="col-md-12 style_card_apresentacao_solicitar_vacina_subtitulo" style="text-align: justify;">Clique para solicitar e agendar sua vacinação, ou realizar cadastro na fila de espera (é necessário aguardar aprovação da solicitação pela Secretaria de Saúde).</div>
                                    @auth
                                        <a href="{{route('reforco.index')}}" class="btn btn-info style_card_apresentacao_botao" style="color:white;">SOLICITAR MINHA PRIMEIRA DOSE DE REFORÇO </a>
                                        <a href="{{route('reforco2.index')}}" class="btn btn-secondary style_card_apresentacao_botao" style="color:white;">SOLICITAR MINHA SEGUNDA DOSE DE REFORÇO </a>

                                    @else
                                        <a href="{{route('reforco.index')}}" class="btn btn-info style_card_apresentacao_botao" style="color:white; @if($config->botao_solicitar_agendamento) pointer-events: none; background-color: rgb(107, 224, 107); border-color: rgb(107, 224, 107); @endif" >@if($config->botao_solicitar_agendamento)VAGAS ESGOTADAS! AGUARDE NOVA REMESSA @else SOLICITAR MINHA <b style="color: black">PRIMEIRA</b> DOSE DE REFORÇO @endif</a>
                                        <a href="{{route('reforco2.index')}}" class="btn btn-secondary style_card_apresentacao_botao" style="color:white; @if($config->botao_solicitar_agendamento) pointer-events: none; background-color: rgb(107, 224, 107); border-color: rgb(107, 224, 107); @endif" >@if($config->botao_solicitar_agendamento)VAGAS ESGOTADAS! AGUARDE NOVA REMESSA @else SOLICITAR MINHA <b style="color: black">SEGUNDA</b> DOSE DE REFORÇO @endif</a>
                                    @endauth
                                </div>
                            </div>
                            <div class="col-md-6" style="margin-bottom: 32px;">
                                <div class="row">
                                    <div class="col-md-12 style_card_apresentacao_solicitar_vacina">CONSULTAR AGENDAMENTO</div>
                                    <div class="col-md-12 style_card_apresentacao_solicitar_vacina_subtitulo" style="text-align: justify; padding-bottom: 19px;">Clique para saber se o seu agendamento já foi aprovado ou encontra-se na fila de espera.</div>
                                    <a type="button" class="btn btn-primary style_card_apresentacao_botao" style="color: white;margin-top:1.8rem;"data-toggle="modal" data-target="#modalChecarAgendamento">CONSULTAR</a>
                                </div>
                            </div>
                            <div class="col-md-6" style="margin-bottom: 32px;">
                                <div class="row">
                                    <div class="col-md-12 style_card_apresentacao_solicitar_vacina">SOLICITAR A VACINAÇÃO</div>
                                    <div class="col-md-12 style_card_apresentacao_solicitar_vacina_subtitulo" style="text-align: justify;">Clique para solicitar e agendar sua vacinação de 1ª e 2ª dose, ou realizar cadastro na fila de espera (é necessário aguardar aprovação da solicitação pela Secretaria de Saúde).</div>
                                    @auth
                                        <a href="{{route('solicitacao.candidato')}}" class="btn btn-success style_card_apresentacao_botao" style="color:white;">QUERO SOLICITAR MINHA VACINA </a>
                                    @else
                                        <a href="{{route('solicitacao.candidato')}}" class="btn btn-success style_card_apresentacao_botao" style="color:white; @if($config->botao_solicitar_agendamento) pointer-events: none; background-color: rgb(107, 224, 107); border-color: rgb(107, 224, 107); @endif" >@if($config->botao_solicitar_agendamento)VAGAS ESGOTADAS! AGUARDE NOVA REMESSA @else QUERO SOLICITAR MINHA VACINA @endif</a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--pessoas com comorbidades -->
        <div class="container mb-4">
            <div class="row justify-content-center">
                <div class="card_media2" style="margin-top: 1rem;">
                    <div class="card_menor3">
                        <div class="card-header style_card_menor_titulo" style=" border-top-left-radius: 12px; border-top-right-radius: 12px; ">INFORMAÇÕES E FORMULÁRIOS PARA VACINAÇÃO CONTRA A COVID-19</div>
                        <div class="container" style="padding-top: 15px; padding-bottom: 14px;">
                            <section class="accordion-section clearfix mt-3" aria-label="Question Accordions">
                                <div class="container">
                                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                        <div class="panel panel-default">
                                            <div class="panel-heading p-3 mb-3" role="tab" id="heading0"  style="border-radius: 8px;">
                                                <h3 class="panel-title">
                                                    <a class="collapsed" role="button" title="" data-toggle="collapse" data-parent="#accordion" href="#anexos6" aria-expanded="true" aria-controls="anexos6">
                                                        NOTA TÉCNICA SIDI 3 - 2022 PARA VACINAÇÃO DE CRIANÇAS DE 5 A 11 ANOS
                                                    </a>
                                                </h3>
                                            </div>
                                            <div id="anexos6" class="panel-collapse collapse show" role="tabpanel" aria-labelledby="heading0">
                                                <div class="panel-body px-3 mb-4">
                                                    <p style="text-align: justify">
                                                    </p>
                                                    <a href="{{route('baixar.anexo', ['name'=> 'NOTA_TECNICA_SIDI_3-2022.pdf'])}}"  class="btn btn-success "  target="_blank" style="color:white;">Baixar Nota Técnica</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel panel-default">
                                            <div class="panel-heading p-3 mb-3" role="tab" id="heading0"  style="border-radius: 8px;">
                                                <h3 class="panel-title">
                                                <a class="collapsed" role="button" title="" data-toggle="collapse" data-parent="#accordion" href="#anexos5" aria-expanded="true" aria-controls="anexos5">
                                                    DOSE DE REFORÇO - Nota Técnica SIDI 23
                                                </a>
                                                </h3>
                                            </div>
                                            <div id="anexos5" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading0">
                                                <div class="panel-body px-3 mb-4">
                                                <p style="text-align: justify">
                                                    Nota Técnica do Governo do Estado de Pernambuco com orientações referentes a aplicação das doses de reforço para a população de idosos acima de 60 anos (que tenham completado o esquema vacinal há seis meses), e imunossuprimidos (com o esquema vacinal completo há 28 dias ou mais).
                                                </p>
                                                <a href="{{route('baixar.anexo', ['name'=> 'anexo4.pdf'])}}"  class="btn btn-success "  target="_blank" style="color:white;">Baixar Nota Técnica</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel panel-default">
                                            <div class="panel-heading p-3 mb-3" role="tab" id="heading0"  style="border-radius: 8px;">
                                                <h3 class="panel-title">
                                                <a class="collapsed" role="button" title="" data-toggle="collapse" data-parent="#accordion" href="#anexos4" aria-expanded="true" aria-controls="anexos4">
                                                    Quem são os idosos que podem tomar a dose de reforço?
                                                </a>
                                                </h3>
                                            </div>
                                            <div id="anexos4" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading0">
                                                <div class="panel-body px-3 mb-4">
                                                <p style="text-align: justify">
                                                    Os IDOSOS COM 60 ANOS OU MAIS que tenham completado o esquema vacinal há seis meses ou mais, independentemente do imunizante aplicado anteriormente.
                                                </p>
                                            </div>
                                        </div>
                                        <div class="panel panel-default">
                                            <div class="panel-heading p-3 mb-3" role="tab" id="heading0"  style="border-radius: 8px;">
                                                <h3 class="panel-title">
                                                <a class="collapsed" role="button" title="" data-toggle="collapse" data-parent="#accordion" href="#anexos3" aria-expanded="true" aria-controls="anexos3">
                                                    Quem são os imunossuprimidos que podem tomar a dose de reforço?
                                                </a>
                                                </h3>
                                            </div>
                                            <div id="anexos3" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading0">
                                                <div class="panel-body px-3 mb-4">
                                                <p style="text-align: justify">
                                                    Os IMUNOSSUPRIMIDOS, que tenham completado o esquema vacinal há 28 dias ou mais.
                                                </p>
                                                <p style="text-align: justify">
                                                    São considerados imunossuprimidos as pessoas com quadro de:
                                                </p>
                                                <p style="text-align: justify">
                                                    <ul>
                                                        <li>Imunodeficiência primária grave</li>
                                                        <li>Quimioterapia para câncer</li>
                                                        <li>Transplantados de órgão sólido ou de células tronco hematopoiéticas (TCTH) uso de drogas imunossupressoras.</li>
                                                        <li>Pessoas vivendo com HIV/AIDS. </li>
                                                        <li>Uso de corticóides em doses ≥20 mg/dia de prednisona, ou equivalente, por ≥14 dias.</li>
                                                        <li>Uso de drogas modificadoras da resposta imune (De acordo com Nota Técnica SIDI 23).</li>
                                                        <li>Auto inflamatórias, doenças intestinais inflamatórias. </li>
                                                        <li>Pacientes em hemodiálise.</li>
                                                        <li>Pacientes com doenças imunomediadas inflamatórias crônicas.</li>
                                                    </ul>
                                                </p>
                                                <p>DOCUMENTAÇÃO NECESSÁRIA:</p>
                                                <p>
                                                    <ul>
                                                        <li>Documento oficial com foto</li>
                                                        <li>CPF</li>
                                                        <li>Cartão do SUS</li>
                                                        <li>Cartão de vacina constando a 2ª dose ou dose única</li>
                                                        <li>Comprovante de residência constando o nome da pessoa a ser vacinada</li>
                                                        <li>Laudo médico ou receita de medicamentos imunossupressores</li>
                                                    </ul>
                                                </p>

                                            </div>
                                        </div>
                                        <div class="panel panel-default">
                                            <div class="panel-heading p-3 mb-3" role="tab" id="heading0"  style="border-radius: 8px;">
                                                <h3 class="panel-title">
                                                <a class="collapsed" role="button" title="" data-toggle="collapse" data-parent="#accordion" href="#anexos2" aria-expanded="true" aria-controls="anexos2">
                                                    Formulário para adolescentes de 12 a 17 anos com comorbidades
                                                </a>
                                                </h3>
                                            </div>
                                            <div id="anexos2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading0">
                                                <div class="panel-body px-3 mb-4">
                                                <p style="text-align: justify">
                                                    A comprovação das comorbidades deve ser feita no ato da vacinação. Para isso, a Secretaria de Saúde produziu um modelo de atestado, onde o profissional de saúde poderá indicar a doença preexistente do paciente. É obrigatório o carimbo, matrícula e/ou registro do conselho de classe do profissional.
                                                </p>
                                                <a href="{{route('baixar.anexo', ['name'=> 'anexo3.pdf'])}}"  class="btn btn-success "  target="_blank" style="color:white;">Baixar Formulário </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel panel-default">
                                            <div class="panel-heading p-3 mb-3" role="tab" id="heading0"  style="border-radius: 8px;">
                                              <h3 class="panel-title">
                                                <a class="collapsed" role="button" title="" data-toggle="collapse" data-parent="#accordion" href="#feedCollapse" aria-expanded="true" aria-controls="feedCollapse">
                                                    Cronograma de antecipação da 2ª dose das vacinas AstraZeneca
                                                </a>
                                              </h3>
                                            </div>
                                            <div id="feedCollapse" class="panel-collapse collapse " role="tabpanel" aria-labelledby="heading0">
                                              <div class="panel-body px-3 mb-4">
                                                <p style="text-align: justify">
                                                    Cronograma de antecipação da 2ª dose das vacinas AstraZeneca, para pessoas que foram vacinadas com a primeira dose em Garanhuns.
                                                </p>
                                                <button type="button"  class="btn btn-success" data-toggle="modal" data-target="#feed">
                                                    Ver
                                                </button>
                                              </div>
                                            </div>
                                        </div>
                                        <div class="panel panel-default">
                                            <div class="panel-heading p-3 mb-3" role="tab" id="heading0"  style="border-radius: 8px;">
                                            <h3 class="panel-title">
                                                <a class="collapsed" role="button" title="" data-toggle="collapse" data-parent="#accordion" href="#anexos3" aria-expanded="true" aria-controls="anexos1">
                                                    Documentação necessária para vacinação dos grupos prioritários
                                                </a>
                                            </h3>
                                            </div>
                                            <div id="anexos3" class="panel-collapse collapse " role="tabpanel" aria-labelledby="heading0">
                                            <div class="panel-body px-3 mb-4">
                                                <p style="text-align: justify">
                                                    Relação contendo a documentação necessária, e que deve ser apresentada no ato da vacinação, de acordo com cada grupo prioritário.
                                                </p>
                                                <a href="{{route('baixar.anexo', ['name'=> 'anexo2.pdf'])}}"  class="btn btn-success "  target="_blank" style="color:white;">Baixar Anexo </a>
                                            </div>
                                            </div>
                                        </div>
                                        <div class="panel panel-default">
                                            <div class="panel-heading p-3 mb-3" role="tab" id="heading0"  style="border-radius: 8px;">
                                            <h3 class="panel-title">
                                                <a class="collapsed" role="button" title="" data-toggle="collapse" data-parent="#accordion" href="#anexos2" aria-expanded="true" aria-controls="anexos2">
                                                    Formulário com informações para gestantes e puérperas para vacinação contra a covid-19
                                                </a>
                                            </h3>
                                            </div>
                                            <div id="anexos2" class="panel-collapse collapse " role="tabpanel" aria-labelledby="heading0">
                                            <div class="panel-body px-3 mb-4">
                                                <p style="text-align: justify">
                                                    Através deste documento, a gestante ou puérpera poderá ter acesso as informações necessárias sobre a vacinação. No mesmo deverão ser preenchidos os dados de identificação, além da autorização para que a vacina seja administrada.
                                                </p>
                                                <a href="{{route('baixar.anexo', ['name'=> 'Termo de Ciência e Consentimento Vacinação contra a Covid - GESTANTE.docx'])}}"  class="btn btn-success "  target="_blank" style="color:white;">Baixar Formulário </a>
                                            </div>
                                            </div>
                                        </div>
                                        <div class="panel panel-default">
                                            <div class="panel-heading p-3 mb-3" role="tab" id="heading0"  style="border-radius: 8px;">
                                            <h3 class="panel-title">
                                                <a class="collapsed" role="button" title="" data-toggle="collapse" data-parent="#accordion" href="#anexos0" aria-expanded="true" aria-controls="anexos0">
                                                    Pessoas com comorbidades
                                                </a>
                                            </h3>
                                            </div>
                                            <div id="anexos0" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading0">
                                            <div class="panel-body px-3 mb-4">
                                                <p style="text-align: justify">
                                                    A comprovação das comorbidades deve ser feita no ato da vacinação. Para isso, a Secretaria Estadual de Saúde produziu um modelo de atestado aonde um profissional de saúde poderá indicar a doença preexistente do paciente. É obrigatório o carimbo, matrícula e/ou registro do conselho de classe do profissional.
                                                </p>
                                                <a href="{{route('baixar.anexo', ['name'=> 'anexo1.pdf'])}}"  class="btn btn-success "  target="_blank" style="color:white;">Baixar anexo </a>
                                            </div>
                                            </div>
                                        </div>
                                        <div class="panel panel-default">
                                            <div class="panel-heading p-3 mb-3" role="tab" id="heading0"  style="border-radius: 8px;">
                                            <h3 class="panel-title">
                                                <a class="collapsed" role="button" title="" data-toggle="collapse" data-parent="#accordion" href="#anexos1" aria-expanded="true" aria-controls="anexos1">
                                                    Nota técnica SIDI 11/2021
                                                </a>
                                            </h3>
                                            </div>
                                            <div id="anexos1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading0">
                                            <div class="panel-body px-3 mb-4">
                                                <p style="text-align: justify">
                                                    Trata das orientações da estratégia de vacinação dos grupos de pessoas com comorbidades, pessoas com deficiência permanente, gestantes e puérperas na Campanha Nacional de Vacinação contra a COVID-19, 2021.
                                                </p>
                                                <a href="{{route('baixar.anexo', ['name'=> 'nota.pdf'])}}"  class="btn btn-success "  target="_blank" style="color:white;">Baixar Nota Técnica </a>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                              </section>
                        </div>
                    </div>
                </div>
                <!-- Pergunta e resposta -->
                {{-- <div class="card_media2" style="margin-top: 1rem;">
                    <div class="card_menor3">
                        <div class="card-header style_card_menor_titulo" style=" border-top-left-radius: 12px; border-top-right-radius: 12px; ">PERGUNTAS FREQUENTES</div>
                        <div class="container" style="padding-top: 15px; padding-bottom: 14px;">
                            <section class="accordion-section clearfix mt-3" aria-label="Question Accordions">
                                <div class="container">
                                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">


                                    <div class="panel panel-default">
                                        <div class="panel-heading p-3 mb-3" role="tab" id="heading1" style="border-radius: 8px;">
                                        <h3 class="panel-title">
                                            <a class="collapsed" role="button" title="" data-toggle="collapse" data-parent="#accordion" href="#collapse1" aria-expanded="true" aria-controls="collapse1">
                                                Fiz meu cadastro na fila de espera e ainda não tive retorno.
                                            </a>
                                        </h3>
                                        </div>
                                        <div id="collapse1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading1">
                                        <div class="panel-body px-3 mb-4">
                                            <p style="text-align: justify">
                                                Olá! A equipe da Secretaria de Saúde está diariamente entrando em contato com as pessoas cadastradas na fila de espera para confirmação dos agendamentos; informando data, local e horário para vacinação.
                                            </p>
                                            <p style="text-align: justify">
                                                Esta população está sendo convocada de acordo com a ordem de inscrição e disponibilizada de doses. Você também pode verificar o status do agendamento, para saber quando ele for aprovado, informando número do CPF e data de nascimento, por meio da plataforma <a href="#">vemvacinagaranhuns.site</a>
                                            </p>
                                        </div>
                                        </div>
                                    </div>

                                    </div>

                                </div>
                            </section>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>



        @auth
            <div class="container" style="text-align: center; margin-top:2rem; margin-bottom: 4rem;">
                <p style="color: #204788; font-weight: bold;">
                    <a href="{{route('home.estatisticas')}}">Seção de Estatísticas</a>
                </p>
            </div>
        @endauth
        @guest
            <div class="container" style="text-align: center; margin-top:2rem; margin-bottom: 4rem;">
                <p style="color: #204788; font-weight: bold;">
                    <a href="{{route('manutencao')}}">Seção de Estatísticas</a>
                </p>
            </div>
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
                                <button type="button" class="btn btn-primary" style="width: 100%;" id="consultaNumSus">Consultar por Cartão SUS</button>
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
    <!-- Modal checar agendamento Número Cartão SUS -->
    <div class="modal fade" id="modalChecarAgendamentoNumSus" tabindex="-1" aria-labelledby="modalChecarAgendamentoNumSusLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content" style="border-radius: 12px;">
                <div class="modal-header" style="background-color: #FF545A; color: #fff; border-top-left-radius: 12px; border-top-right-radius: 12px; ">
                    <h5 class="modal-title" id="modalChecarAgendamentoNumSusLabel">CONSULTAR AGENDAMENTO</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="consultar_agendamento_numSus" action="{{route('agendamento.consultarNumSus')}}" method="POST">
                        @csrf
                        <div class="container">
                            <input type="hidden" name="consulta" value="1">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="inputNumSus" class="style_titulo_input">Número Cartão SUS <span class="style_titulo_campo">*</span><span class="style_subtitulo_input"> (obrigatório)</span> </label>
                                    <input type="text" class="form-control style_input sus @error('numSus') is-invalid @enderror" id="inputNumSus" placeholder="Ex.: 000 0000 0000 0000" name="numSus" value="{{old('numSus')}}">

                                    @error('numSus')
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
                                    <button type="button" class="btn btn-primary" style="width: 100%;" id="consultaCpf">Consultar por CPF</button>
                                </div>
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-success" style="width: 100%;" form="consultar_agendamento_numSus">Consultar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Fim modal checar agendamento SUS -->
    <!-- Modal feed agendamento -->
    <div class="modal fade" id="feed" tabindex="-1" aria-labelledby="feedAdiatamento" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="border-radius: 12px;">
            <div class="modal-header" style="background-color: #FF545A; color: #fff; border-top-left-radius: 12px; border-top-right-radius: 12px; ">
                <h5 class="modal-title" id="feedAdiatamento">Informações para vacinação de adolescentes</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    @foreach ($feeds as $feed)
                        <div class="row justify-content-center mb-4">
                            <div class="col-10 align-self-center">
                                <div class="card mb-3">
                                    <img style="height: 100%;width:100%;" src="{{ asset('storage/'.$feed->path) }}" alt="Teste">
                                    <div class="card-body">
                                      {{-- <h5 class="card-title">Card title</h5>
                                      <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p> --}}
                                      <p class="card-text"><small class="text-muted">{{ 'Postado ' .$feed->created_at->diffForHumans() }}</small></p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        </div>
    </div>
    <!-- Fim feed checar agendamento -->
    @if (old('consulta') != null)
        @error('cpf')
            <script>
                $(document).ready(function() {
                    $("#modalChecarAgendamento").modal('show');
                });
            </script>
        @enderror

        @error('numSus')
            <script>
                $(document).ready(function() {
                    $("#modalChecarAgendamentoNumSus").modal('show');
                });
            </script>
        @enderror
   <!-- Modal de info inicial ao entrar no site
        <script>
        $(document).ready(function() {
            $("#feed").modal('show');
        });


    </script> -->
    @endif

    <!-- Alternancia do tipo da consulta do agendamento -->
    <script type="text/javascript">

        document.getElementById("consultaCpf").onclick = function(){
            $("#modalChecarAgendamentoNumSus").modal('hide');
            setTimeout(() => {   $("#modalChecarAgendamento").modal(); }, 500);
        };

        document.getElementById("consultaNumSus").onclick = function(){
            $("#modalChecarAgendamento").modal('hide');
            setTimeout(() => {   $("#modalChecarAgendamentoNumSus").modal(); }, 500);
        };

    </script>
    <!-- Fim do Script de Altenancia -->

    <script>

    </script>

</x-guest-layout>
