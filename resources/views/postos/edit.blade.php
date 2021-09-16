<x-app-layout>
    <x-slot name="header">

        <div class="grid grid-cols-6 gap-4">
            <div class="col-span-5">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">

                    {{ __('Editar Ponto de Vacinação') }}
                </h2>
            </div>
            <div class="...">
            </div>
          </div>

    </x-slot>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="container">
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('postos.update', ['posto' => $posto->id]) }}" method="post">
                    @csrf
                    @method('put')
                    <div class="row">
                        <div class="col-md-12">
                            <h4>Informações necessárias</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="nome">Nome</label>
                            <input id="nome" type="text" class="form-control @error('nome') is-invalid @enderror" name="nome" value="{{ $posto->nome }}">
                            @error('nome')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="data_nacimento">Local</label>
                            <input id="data_nacimento" type="text" class="form-control @error('endereco') is-invalid @enderror" name="endereco" value="{{ $posto->endereco }}" >
                            @error('endereco') <div class="alert alert-danger">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <input id="padrao_no_formulario" type="checkbox" name="padrao_no_formulario" @if(old('padrao_no_formulario') || old('padrao_no_formulario') == null && $posto->padrao_no_formulario) checked @endif>
                            <label for="padrao_no_formulario">Exibir por padrão no agendamento</label>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <h4>Quais públicos são permitidos nesse ponto?</h4>
                        </div>
                    </div>
                    <div class="row">
                        @foreach ($publicos as $publico)
                            <div class="col-md-6">
                                <input id="publico_{{$publico->id}}" type="checkbox" value="{{$publico->id}}" name="publicos[]" @if(old('publicos') != null && in_array($publico->id, old('publicos'))) @elseif(old('publicos') == null && $publicosDoPosto->contains('etapa_id', $publico->id)) checked @endif>
                                @if($publico->tipo == $tipos[0])
                                    <label for="publico_{{$publico->id}}">De {{$publico->inicio_intervalo}} à {{$publico->fim_intervalo}} anos</label>
                                @elseif($publico->tipo == $tipos[1] || $publico->tipo == $tipos[2])
                                    <label for="publico_{{$publico->id}}">{{$publico->texto}}</label>
                                @endif
                            </div>
                        @endforeach
                        @error('publicos')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <br>


                    <div class="row">
                        <div class="col-md">
                            <h4>Dias de funcionamento</h4>

                            <input id="funciona_domingo" type="checkbox" name="funciona_domingo" @if(old('funciona_domingo') || (old('funciona_domingo') == null && $posto->funciona_domingo)) checked @endif>
                            <label for="funciona_domingo">Funciona nos domingos</label>
                            <br>

                            <input id="funciona_segunda" type="checkbox" name="funciona_segunda" @if(old('funciona_segunda') || (old('funciona_segunda') == null && $posto->funciona_segunda)) checked @endif>
                            <label for="funciona_segunda">Funciona nas segundas</label>
                            <br>

                            <input id="funciona_terca" type="checkbox" name="funciona_terca" @if(old('funciona_terca') || (old('funciona_terca') == null && $posto->funciona_terca)) checked @endif>
                            <label for="funciona_terca">Funciona nas terças</label>
                            <br>

                            <input id="funciona_quarta" type="checkbox" name="funciona_quarta" @if(old('funciona_quarta') || (old('funciona_quarta') == null && $posto->funciona_quarta)) checked @endif>
                            <label for="funciona_quarta">Funciona nas quartas</label>
                            <br>

                            <input id="funciona_quinta" type="checkbox" name="funciona_quinta" @if(old('funciona_quinta') || (old('funciona_quinta') == null && $posto->funciona_quinta)) checked @endif>
                            <label for="funciona_quinta">Funciona nas quintas</label>
                            <br>

                            <input id="funciona_sexta" type="checkbox" name="funciona_sexta" @if(old('funciona_sexta') || (old('funciona_sexta') == null && $posto->funciona_sexta)) checked @endif>
                            <label for="funciona_sexta">Funciona nas sextas</label>
                            <br>

                            <input id="funciona_sabado" type="checkbox" name="funciona_sabado" @if(old('funciona_sabado') || (old('funciona_sabado') == null && $posto->funciona_sabado)) checked @endif>
                            <label for="funciona_sabado">Funciona nos sábados</label>

                        </div>
                    </div>
                    <br>


                    <div class="row">
                        <div class="col-md">
                            <input onchange="check_funcionamento(this, 'seletores_funcionamento_manha')" id="funcionamento_manha" type="checkbox" name="funcionamento_manha" @if(old('funcionamento_manha') || (old('funcionamento_manha') == null && $posto->inicio_atendimento_manha && $posto->intervalo_atendimento_manha && $posto->fim_atendimento_manha)) checked @endif>
                            <label for="funcionamento_manha">Funciona pela manhã</label>
                            @error('funcionamento_manha') <div class="alert alert-danger">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div id="seletores_funcionamento_manha" class="row"  @if(!(old('funcionamento_manha') || (old('funcionamento_manha') == null && $posto->inicio_atendimento_manha && $posto->intervalo_atendimento_manha && $posto->fim_atendimento_manha))) style="display: none;" @endif >
                        <div class="col-md-3">
                            <label style="margin-right: 8%;">Inicio:</label>
                            <select name="inicio_atendimento_manha" class="form-control">
                                <option disabled selected> -- hrs</option>
                                @for($i = 5; $i <= 12; $i++)
                                   <option value="{{$i}}" @if(old('inicio_atendimento_manha', $posto->inicio_atendimento_manha) == $i) selected @endif >{{$i}} hrs</option>
                                @endfor
                            </select>
                            @error('inicio_atendimento_manha') <div class="alert alert-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-3">
                            <label style="margin-right: 8%;">Minutos:</label>
                            <select name="minutos_inicio_atendimento_manha" class="form-control">
                                <option disabled selected> -- hrs</option>
                                @for($i = 0; $i <= 60; $i++)
                                   <option value="{{$i}}" @if(old('minutos_inicio_atendimento_manha', $posto->minutos_inicio_atendimento_manha) == $i) selected @endif >{{$i}} min</option>
                                @endfor
                            </select>
                        </div>

                        
                        <div class="col-md-3">
                            <label style="margin-right: 8%;">Fim:</label>
                            <select name="fim_atendimento_manha" class="form-control">
                                <option disabled selected> -- hrs</option>
                                @for($i = 5; $i <= 12; $i++)
                                   <option value="{{$i}}" @if(old('fim_atendimento_manha', $posto->fim_atendimento_manha) == $i) selected @endif>{{$i}} hrs</option>
                                @endfor
                            </select>
                            @error('fim_atendimento_manha') <div class="alert alert-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-3">
                            <label style="margin-right: 8%;">Minutos:</label>
                            <select name="minutos_fim_atendimento_manha" class="form-control">
                                <option disabled selected> -- min</option>
                                @for($i = 0; $i <= 60; $i++)
                                   <option value="{{$i}}" @if(old('minutos_fim_atendimento_manha', $posto->minutos_fim_atendimento_manha) == $i) selected @endif>{{$i}} min</option>
                                @endfor
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label style="margin-right: 8%;">Intervalo (mins):</label>
                            <input min="1" max="60" type="number" class="form-control" style="width: 75%;" name="intervalo_atendimento_manha" value="{{old('intervalo_atendimento_manha', $posto->intervalo_atendimento_manha)}}">
                            @error('intervalo_atendimento_manha') <div class="alert alert-danger">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <br>








                    <div class="row">
                        <div class="col-md">
                            <input onchange="check_funcionamento(this, 'seletores_funcionamento_tarde')" id="funcionamento_tarde" type="checkbox" name="funcionamento_tarde" @if(old('funcionamento_tarde') || (old('funcionamento_tarde') == null && $posto->inicio_atendimento_tarde && $posto->intervalo_atendimento_tarde && $posto->fim_atendimento_tarde)) checked @endif>
                            <label for="funcionamento_tarde">Funciona pela tarde</label>
                            @error('funcionamento_tarde') <div class="alert alert-danger">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div id="seletores_funcionamento_tarde" class="row" @if(!(old('funcionamento_tarde') || (old('funcionamento_tarde') == null && $posto->inicio_atendimento_tarde && $posto->intervalo_atendimento_tarde && $posto->fim_atendimento_tarde))) style="display: none;" @endif>
                        <div class="col-md-3">
                            <label style="margin-right: 8%;">Inicio:</label>
                            <select name="inicio_atendimento_tarde" class="form-control">
                                <option disabled selected> -- hrs</option>
                                @for($i = 13; $i <= 18; $i++)
                                   <option value="{{$i}}" @if(old('inicio_atendimento_tarde', $posto->inicio_atendimento_tarde) == $i) selected @endif >{{$i}} hrs</option>
                                @endfor
                            </select>
                            @error('inicio_atendimento_tarde') <div class="alert alert-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-3">
                            <label style="margin-right: 8%;">Minutos:</label>
                            <select name="minutos_inicio_atendimento_tarde" class="form-control">
                                <option disabled selected> -- min</option>
                                @for($i = 0; $i <= 60; $i++)
                                   <option value="{{$i}}" @if(old('minutos_inicio_atendimento_tarde', $posto->minutos_inicio_atendimento_tarde) == $i) selected @endif >{{$i}} min</option>
                                @endfor
                            </select>
                            @error('minutos_inicio_atendimento_tarde') <div class="alert alert-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-3">
                            <label style="margin-right: 8%;">Fim:</label>
                            <select name="fim_atendimento_tarde"class="form-control">
                                <option disabled selected> -- hrs</option>
                                @for($i = 13; $i <= 18; $i++)
                                   <option value="{{$i}}" @if(old('fim_atendimento_tarde', $posto->fim_atendimento_tarde) == $i) selected @endif>{{$i}} hrs</option>
                                @endfor
                            </select>
                            @error('fim_atendimento_tarde') <div class="alert alert-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-3">
                            <label style="margin-right: 8%;">Minutos:</label>
                            <select name="minutos_fim_atendimento_tarde"class="form-control">
                                <option disabled selected> -- min</option>
                                @for($i = 0; $i <= 60; $i++)
                                   <option value="{{$i}}" @if(old('minutos_fim_atendimento_tarde', $posto->minutos_fim_atendimento_tarde) == $i) selected @endif>{{$i}} min</option>
                                @endfor
                            </select>
                            @error('minutos_fim_atendimento_tarde') <div class="alert alert-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label style="margin-right: 8%;">Intervalo (mins):</label>
                            <input min="1" max="60" type="number" class="form-control" style="width: 75%;" name="intervalo_atendimento_tarde" value="{{old('intervalo_atendimento_tarde', $posto->intervalo_atendimento_tarde)}}">
                            @error('intervalo_atendimento_tarde') <div class="alert alert-danger">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <br>





                    <div class="row">
                        <div class="col-md">
                            <input onchange="check_funcionamento(this, 'seletores_funcionamento_noite')" id="funcionamento_noite" type="checkbox" name="funcionamento_noite" @if(old('funcionamento_noite') || (old('funcionamento_noite') == null && $posto->inicio_atendimento_noite && $posto->inicio_atendimento_noite && $posto->fim_atendimento_noite)) checked @endif>
                            <label for="funcionamento_noite">Funciona pela noite</label>
                            @error('funcionamento_noite') <div class="alert alert-danger">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div id="seletores_funcionamento_noite" class="row" @if(!(old('funcionamento_noite') || (old('funcionamento_noite') == null && $posto->inicio_atendimento_noite && $posto->inicio_atendimento_noite && $posto->fim_atendimento_noite))) style="display: none;" @endif>
                        <div class="col-md-3">
                            <label style="margin-right: 8%;">Inicio:</label>
                            <select name="inicio_atendimento_noite" class="form-control">
                                <option disabled selected> -- hrs</option>
                                @for($i = 17; $i <= 23; $i++)
                                   <option value="{{$i}}" @if(old('inicio_atendimento_noite', $posto->inicio_atendimento_noite) == $i) selected @endif >{{$i}} hrs</option>
                                @endfor
                            </select>
                            @error('inicio_atendimento_noite') <div class="alert alert-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-3">
                            <label style="margin-right: 8%;">Minutos:</label>
                            <select name="minutos_inicio_atendimento_noite" class="form-control">
                                <option disabled selected> -- min</option>
                                @for($i = 0; $i <= 23; $i++)
                                   <option value="{{$i}}" @if(old('minutos_inicio_atendimento_noite', $posto->minutos_inicio_atendimento_noite) == $i) selected @endif >{{$i}} min</option>
                                @endfor
                            </select>
                            @error('minutos_inicio_atendimento_noite') <div class="alert alert-danger">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-3">
                            <label style="margin-right: 8%;">Fim:</label>
                            <select name="fim_atendimento_noite"class="form-control">
                                <option disabled selected> -- hrs</option>
                                @for($i = 0; $i <= 23; $i++)
                                   <option value="{{$i}}" @if(old('fim_atendimento_noite', $posto->fim_atendimento_noite) == $i) selected @endif>{{$i}} hrs</option>
                                @endfor
                            </select>
                            @error('fim_atendimento_noite') <div class="alert alert-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-3">
                            <label style="margin-right: 8%;">Minutos:</label>
                            <select name="minutos_fim_atendimento_noite"class="form-control">
                                <option disabled selected> -- min</option>
                                @for($i = 0; $i <= 60; $i++)
                                   <option value="{{$i}}" @if(old('minutos_fim_atendimento_noite', $posto->minutos_fim_atendimento_noite) == $i) selected @endif>{{$i}} min</option>
                                @endfor
                            </select>
                            @error('minutos_fim_atendimento_noite') <div class="alert alert-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label style="margin-right: 8%;">Intervalo (mins):</label>
                            <input min="1" max="60" type="number" class="form-control" style="width: 75%;" name="intervalo_atendimento_noite" value="{{old('intervalo_atendimento_noite', $posto->intervalo_atendimento_noite)}}">
                            @error('intervalo_atendimento_noite') <div class="alert alert-danger">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <br>
                    <br>
                    <br>





                    <div class="row">
                        <div class="col-md-3">
                            <button class="btn btn-success">Salvar</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>


    <script>

     function check_funcionamento(check, div) {
         if(check.checked) {
             document.getElementById(div).style.display = "flex";
         } else {
             document.getElementById(div).style.display = "none";
         }
     }

    </script>



  </x-app-layout>
