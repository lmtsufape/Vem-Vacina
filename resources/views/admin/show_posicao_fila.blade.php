<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Posição fila') }}

        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="container">
                <form method="GET" action={{ route('admin.posicao.fila') }}>
                    <div class="row ">
                        <div class="col-sm-8">
                            <div class="row">
                                <div class="col-md-3">
                                    <input type="checkbox" name="nome_check" id="nome_check_input" onclick="mostrarFiltro(this, 'nome_check')" @if($request->nome_check != null && $request->nome_check) checked @endif>
                                    <label>Por nome</label>
                                </div>
                                <div class="col-md-3">
                                    <input type="checkbox" name="cpf_check" id="cpf_check_input" onclick="mostrarFiltro(this, 'cpf_check')" @if($request->cpf_check != null && $request->cpf_check) checked @endif>
                                    <label>Por CPF</label>
                                </div>
                                <div class="col-md-3">
                                    <input type="checkbox" name="publico_check" id="publico_check_input" @if($request->publico_check != null && $request->publico_check) checked @endif onclick="mostrarFiltro(this, 'publico_check')">
                                    <label>Público</label>
                                </div>
                            </div>
                            <div class="row">
                                <div id="nome_check" class="col-md-3" style="@if($request->nome_check != null && $request->nome_check) display: block; @else display: none; @endif">
                                    <input type="text" class="form-control" name="nome" id="nome" placeholder="Digite o nome" @if($request->nome != null) value="{{$request->nome}}" @endif>
                                </div>
                                <div id="cpf_check" class="col-md-3" style="@if($request->cpf_check != null && $request->cpf_check) display: block; @else display: none; @endif">
                                    <input type="text" class="form-control cpf" name="cpf" id="cpf" placeholder="Digite o CPF"  @if($request->cpf != null) value="{{$request->cpf}}" @endif>
                                </div>
                                <div id="publico_check" class="col-md-3" @if($request->publico_check != null && $request->publico_check) style="display: block;" @else style="display:none;" @endif>
                                    <select id="publico" name="publico" class="form-control">
                                        <option value="">-- Público --</option>
                                        @foreach ($publicos as $publico)
                                            <option @if($request->publico == $publico->id) selected @endif value="{{ $publico->id }}">{{ $publico->texto_home }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-md-12" style="margin-bottom: 5px;">
                                    <button type="submit" class="btn btn-primary" style="width: 100%;">Filtrar</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <a href={{ route('admin.posicao.fila') }}><button type="button" class="btn btn-secondary" style="width: 100%;">Limpar filtros</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                @if(session('mensagem'))
                <div class="col-md-12">
                    <div class="alert alert-success" role="alert">
                        <p>{{session('mensagem')}}</p>
                    </div>
                </div>
                @endif
                <br>
                <br>
                <div class="row justify-content-center">
                    <div class="col-md-auto">
                        <h3>
                            @if ($candidato)
                                <div class="row justify-content-center ">
                                        <div class="col-auto align-self-center">Total:</div>
                                </div>
                                <div class="row justify-content-center ">
                                    <div class="col-auto align-self-center">{{ $total }}</div>
                                </div>
                                <br>
                                <div class="row justify-content-center ">
                                    <div class="col-auto align-self-center">Posição: </div>

                                </div>
                                <div class="row justify-content-center ">
                                    <div class="col-auto align-self-center">{{ $posicao ."º" }}</div>
                                </div>
                                <br>
                                <div class="row justify-content-center ">
                                    <div class="col-auto align-self-center">Nome/CPF:</div>
                                </div>
                                <div class="row justify-content-center ">
                                    <div class="col-auto align-self-center">
                                        {{ $candidato ? $candidato->nome_completo : "Não encontrado" }}
                                    </div>
                                </div>
                                <div class="row justify-content-center ">
                                    <div class="col-auto align-self-center">
                                        {{ $candidato ? $candidato->cpf : "" }}
                                    </div>
                                </div>
                            @else
                                <div class="row justify-content-center ">
                                    <div class="col-auto align-self-center">Não encontrado</div>
                                </div>
                            @endif

                        </h3>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        function mostrarFiltro(check, id) {
            if(check.checked) {
                document.getElementById(id).style.display = "block";
            } else {
                document.getElementById(id).style.display = "none";
            }
        }
    </script>
</x-app-layout>



