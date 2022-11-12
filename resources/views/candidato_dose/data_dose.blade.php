<x-guest-layout>


    {{-- @dd($validate) --}}

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
                    <form action="{{ route('solicitacao.reforcoDose') }}" method="get">

                        <input type="hidden" name="dose" value="{{$dose->id}}">
                        <input type="hidden" name="cpf" value="{{ $validate['cpf'] }}">
                        <input type="hidden" name="data_de_nascimento" value="{{ $validate['data_de_nascimento'] }}">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row" style="text-align: center;">
                                    <div class="col-md-12" style="margin-top: 20px;margin-bottom: 10px;">
                                        <img src="{{asset('img/logo_vem_vacina.png')}}" alt="Orientação" width="300px">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 style_titulo_campo">Solicitar Vacinação da {{$dose->nome}}</div>
                            <div class="col-md-12">
                                <hr class="style_linha_campo">
                            </div>

                            <div class="container">
                                @if (session('status'))
                                    <div class="alert alert-danger">
                                        {{ session('status') }}
                                    </div>
                                @endif
                                <p class="alert alert-warning" id="alerta_vacinas">
                                    Preencher com a data da
                                    @if($dose->dose_anterior_id == 0)
                                        Quarta Dose.
                                    @else
                                        {{\App\Models\Dose::find($dose->dose_anterior_id)->nome}}.
                                    @endif
                                    A veracidade das informações preenchidas na Plataforma Vem Vacina será verificada no ato da vacinação!
                                    <br>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="inputData" class="style_titulo_input">Data da
                                            @if($dose->dose_anterior_id == 0)
                                                Quarta Dose
                                            @else
                                                {{\App\Models\Dose::find($dose->dose_anterior_id)->nome}}
                                            @endif
                                            <span class="style_titulo_campo">*</span><span class="style_subtitulo_input"> (obrigatório)</span> </label>
                                        <input id="inputDataDois" type="date" class="form-control style_input @error('data_dois') is-invalid @enderror" name="data_dois" value="{{old('data_dois')}}">

                                        @error('data')
                                        <div id="validationServer05Feedback" class="invalid-feedback">
                                            <strong>{{$message}}</strong>
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="mb-3 col-md-12">
                                        <button type="submit" class="btn btn-success" style="width: 100%;">Cadastro da {{$dose->nome}}</button>
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
                        <div class="col-12" style="margin-bottom: 45px; color:#fff;font-weight: 600;font-family: Arial, Helvetica, sans-serif;"><img src="{{asset('img/logo_rede_sociais.png')}}"
                                                                                                                                                     alt="LMTS" width="20px"> Redes Sociais
                        </div>
                        <a href="https://www.facebook.com/PrefeituradeGaranhuns/" target="_blank"><img src="{{asset('img/facebook.png')}}" alt="LMTS" width="55px"> </a>
                        <a href="https://twitter.com/garanhunspref" target="_blank"><img src="{{asset('img/twitter.png')}}" alt="LMTS" width="55px"> </a>
                        <a href="https://www.instagram.com/prefgaranhuns/" target="_blank"><img src="{{asset('img/instagram.png')}}" alt="LMTS" width="55px"> </a>
                        <a href="https://www.youtube.com/channel/UCHNqCIPyK42cjWUgO85C7Yg" target="_blank"><img src="{{asset('img/youtube.png')}}" alt="LMTS" width="43px" height="43x"
                                                                                                                style="margin-top: 4.5px;margin-left: 4px;"></a>
                    </div>
                </div>
                <div class="col-sm">
                    <div class="form-group justify-content-center" style="text-align:center; margin-bottom:1rem;margin-top: 1.5rem;">
                        <div style="color:#fff;font-weight: 600;font-family: Arial, Helvetica, sans-serif;"><img src="{{asset('img/logo_fale_conosco.png')}}" alt="LMTS" width="15px"> Fale Conosco
                        </div>
                        <div style="color:#fff; font-size: 30px; font-weight: 600; font-family: Arial, Helvetica, sans-serif; margin-top:20px">(87) 3762-1252</div>
                        <div style="color:#fff; font-size: 18px; font-weight: 100; font-family: Arial, Helvetica, sans-serif; margin-top:6px">agendamentovacinacovidgus@gmail.com</div>

                    </div>
                </div>
                <div class="col-sm">
                    <div class="form-group justify-content-center" style="text-align:center; margin-bottom:1rem;margin-top: 1.5rem;">
                        <div style="color:#fff;font-weight: 600;font-family: Arial, Helvetica, sans-serif;">Desenvolvido por:</div>
                        <div class="btn-group">
                            <div style="margin-top: 21px;margin-right: 15px;"><a href="http://ufape.edu.br/" target="_blank"><img src="{{asset('img/logo_ufape.png')}}" alt="LMTS" width="165px"> </a>
                            </div>
                            <div style="margin-top: 35px;"><a href="http://lmts.uag.ufrpe.br/" target="_blank"><img src="{{asset('img/logo_lmts.png')}}" alt="LMTS" width="140px"> </a></div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12" style="text-align: center; margin-bottom: 2rem;margin-top: 1rem;">
                    <a href="https://garanhuns.pe.gov.br/mapa-do-site/" target="_blank" style="margin-left: 15px;margin-right: 15px; color: #fff;text-decoration:none; ">MAPA DO SITE</a>
                    <a href="https://garanhuns.pe.gov.br/teclas-de-acessibilidade/" target="_blank" style="margin-left: 15px;margin-right: 15px; color: #fff;text-decoration:none; ">TECLAS DE
                        ACESSIBILIDADE</a>
                    <a href="https://garanhuns.pe.gov.br/telefones-uteis/" target="_blank" style="margin-left: 15px;margin-right: 15px; color: #fff;text-decoration:none; ">TELEFONES ÚTEIS</a>

                </div>
            </div>
        </div>
    </div>

    <!--x rodapé x-->


</x-guest-layout>

