<x-guest-layout>
    <body style="background-color: #FBFBFB;">
        <div style="padding-bottom: 0rem;padding-top: 1rem;; margin-top: -15%;">
            <img src="{{asset('/img/cabecalho_1.png')}}" alt="Orientação" width="100%">
            <div class="container">
                <img src="{{asset('/img/cabecalho_2.png')}}" alt="Orientação" width="100%">
            </div>
        </div>

        <div class="container" style="margin-bottom: 1rem;;">
            <div class="row justify-content-center  style_card_apresentacao">
                @if($agendamento)
                    <div class="col-md-12">
                        <br>
                        <h3>Informações pessoais</h3>
                        <table class="table">
                            <tr><td>{{$agendamento->nome_completo}}</td></tr>
                            <tr><td>Estado da vacinação: {{$agendamento->aprovacao}}</td></tr>
                            <tr><td>Dia e hora da vacinação: {{$agendamento->chegada->format("d/m/Y") . ", " . $agendamento->chegada->format("H:i")}}</td></tr>
                            <tr><td>Lote da vacina: {{$agendamento->lote->numero_lote}}</td></tr>
                        </table>
                    </div>
                    <div class="col-md-12">
                        <h3>Local de atendimento</h3>
                        <table class="table">
                            <tr><td>{{$agendamento->posto->nome}}</td></tr>
                            <tr><td>{{$agendamento->posto->endereco}}</td></tr>
                        </table>
                    </div>
                @else
                    <div style="text-align: center;">Número de agendamento invalido</div>
                @endif
            </div>
        </div>
       <br>

        <!-- rodapé -->
        <div style="background-color:#BDC3C7; display: flex; flex-wrap: wrap; justify-content: center;padding-bottom:5rem">
            <div class="row" style="margin-top:1rem;text-align:center">
                <hr class="col-md-12" size = 7 style="background-color:#fff">
                <div class="col-md-4">
                    <div class="row justify-content-center" style="text-align:center; margin-bottom:2rem;">
                        <div class="col-12" style="margin-bottom: 10px; color:#fff;">Desenvolvido por:</div>
                        <img src="{{asset('/img/logo_lmts_p_branco.png')}}" alt="LMTS" width="200px">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="row justify-content-center" style="text-align:center; margin-bottom:2rem;">
                        <div class="col-12" style="color:#fff;">Apoio:</div>
                        <img src="{{asset('/img/logo_ufape_branco.png')}}" alt="UFAPE" width="240px">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="row justify-content-center" style="text-align:center">
                        <div class="col-12" style="margin-bottom: 2rem; color:#fff;">Redes sociais:</div>
                        <img src="{{asset('/img/logo_facebook_branco.png')}}" width="40px" height="40px" style="margin-left: 10px; margin-right: 10px;">
                        <img src="{{asset('/img/logo_instagram_branco.png')}}" width="40px" height="40px" style="margin-left: 10px; margin-right: 10px;">
                        <img src="{{asset('/img/logo_twitter_branco.png')}}" width="40px" height="40px" style="margin-left: 10px; margin-right: 10px;">
                    </div>
                </div>
            </div>
        </div>
        <!--x rodapé x-->
    </body>
</x-guest-layout>
