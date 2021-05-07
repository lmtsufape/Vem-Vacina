<x-app-layout>
    <x-slot name="header">
        <div class="row">
            <div class="col-md-7">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Configurações') }}
                </h2>

            </div>
        </div>
    </x-slot>

    <div class="container" style="margin-top: 40px;">
        @if(session('mensagem'))
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-success" role="alert">
                        <p>{{session('mensagem')}}</p>
                    </div>
                </div>
            </div>
        @endif
        <form action="{{route('config.update')}}" method="GET">
            <div class="row">
                <div class="col-md-6">
                    <input type="checkbox" name="botao_solicitar_agendamento" id="botao_solicitar_agendamento" @if($config->botao_solicitar_agendamento) checked @endif>
                    <label for="botao_solicitar_agendamento">Desativar botão solicitar agendamento</label>
                </div>
                <div class="col-md-6">
                    <input type="checkbox" name="botao_lista_de_espera" id="botao_lista_de_espera" @if($config->botao_fila_de_espera) checked @endif>
                    <label for="botao_lista_de_espera">Ativar botão solicitar agendamento em lista de espera</label>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-8">
                    <label for="link_do_botao_solicitar_agendamento">Link para formulário da lista de espera</label>
                    <input type="url" name="link_do_botao_solicitar_agendamento" class="form-control @error('link_do_botao_solicitar_agendamento') is-invalid @enderror" placeholder="https://www.google.com.br/?gfe_rd=cr&ei=rhImVNHQG4WC8Qes3oCoBg&gws_rd=ssl" id="link_do_botao_solicitar_agendamento" value="@if(old('link_do_botao_solicitar_agendamento')){{old('link_do_botao_solicitar_agendamento')}}@else{{$config->link_do_form_fila_de_espera}}@endif">

                    @error('link_do_botao_solicitar_agendamento')
                        <div id="validationServer05Feedback" class="invalid-feedback">
                            <strong>{{$message}}</strong>
                        </div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="">Número de vacinas recebidas</label>
                    <input type="number" min="0" max="1000000" name="numero_vacinas" class="form-control" value="@if($config->vacinas_recebidas == null)0 @else{{$config->vacinas_recebidas}}@endif">
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <button class="btn btn-success">Salvar</button>
                </div>
            </div>
        </form>
        <hr>
        <form action="{{ route('config.agendados.aprovados') }}" method="post">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <button class="btn btn-success">Aprovar todos agendamentos</button>
                </div>
            </div>
        </form>



    </div>
</x-app-layout>
