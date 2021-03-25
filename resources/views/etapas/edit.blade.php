<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar') }} {{$publico->texto}}
        </h2>
    </x-slot>
    <div style="margin-top: 30px;">
        <form id="editar_etapa_{{$publico->id}}" action="{{route('etapas.update', ['id' => $publico->id])}}" method="post">
            @csrf
            <div class="container" style="margin-bottom: 35px;">
                @if(session('error'))
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-danger" role="alert">
                                <p>{{session('error')}}</p>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="row">
                    <div class="col-md-4">
                        <label for="tipo">Classficação do público</label>
                        <select name="tipo" id="tipo" class="form-control" onchange="selecionarDiv(this)">
                            <option value="" selected disabled>-- selecione a classificação do público --</option>
                            @if (old('tipo') != null)
                                <option value="{{$tipos[0]}}" @if(old('tipo') == $tipos[0]) selected @endif>Por idade</option>
                                <option value="{{$tipos[1]}}" @if(old('tipo') == $tipos[1]) selected @endif>Texto livre</option>
                                <option value="{{$tipos[2]}}" @if(old('tipo') == $tipos[2]) selected @endif>Texto livre com campo extra selecionável</option>
                            @else 
                                <option value="{{$tipos[0]}}" @if($publico->tipo == $tipos[0]) selected @endif>Por idade</option>
                                <option value="{{$tipos[1]}}" @if($publico->tipo == $tipos[1]) selected @endif>Texto livre</option>
                                <option value="{{$tipos[2]}}" @if($publico->tipo == $tipos[2]) selected @endif>Texto livre com campo extra selecionável</option>
                            @endif
                        </select>

                        @error('tipo')
                            <div id="tipo" class="invalid-feedback">
                                <strong>{{$message}}</strong>
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="texto_do_agendamento">Texto exibido no agendamento</label>
                        <input type="text" id="texto_do_agendamento" name="texto_do_agendamento" class="form-control" value="@if(old('texto_do_agendamento')!=null){{old('texto_do_agendamento')}}@else{{$publico->texto}}@endif">

                        @error('texto_do_agendamento')
                            <div id="texto_do_agendamento" class="invalid-feedback">
                                <strong>{{$message}}</strong>
                            </div>
                        @enderror
                        <input id="exibir_no_form" type="checkbox" name="exibir_no_form" @if(old('exibir_no_form') || (old('exibir_no_form') == null && $publico->exibir_no_form)) checked @endif>
                        <label for="exibir_no_form" >Exibir público no agendamento</label>
                    </div>
                    <div class="col-md-4">
                        <label for="texto_da_home">Texto exibido na home</label>
                        <input id="texto_da_home" type="text" class="form-control @error('texto_da_home') is-invalid @enderror" name="texto_da_home" value="@if(old('texto_da_home')!=null){{old('texto_da_home')}}@else{{$publico->texto_home}}@endif">

                        @error('texto_da_home')
                            <div id="validationServer05Feedback" class="invalid-feedback">
                                <strong>{{$message}}</strong>
                            </div>
                        @enderror
                        <input id="exibir_na_home" type="checkbox" name="exibir_na_home" @if(old('exibir_na_home') || (old('exibir_na_home') == null && $publico->exibir_na_home)) checked @endif>
                        <label for="exibir_na_home" >Exibir público na home</label>
                    </div>
                </div>
                <br>
                <div id="divIdade" @if(old('tipo') == $tipos[0] || (old('tipo') == null && $publico->tipo == $tipos[0])) style="display: block;" @else style="display: none;" @endif>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="inicio_faixa_etaria">Inicio da faixa etaria</label>
                            <input id="inicio_faixa_etaria" class="form-control @error('inicio_faixa_etária') is-invalid @enderror" type="number" name="inicio_faixa_etária" placeholder="80" value="@if(old('inicio_faixa_etária') != null){{old('inicio_faixa_etária')}}@else{{$publico->inicio_intervalo}}@endif" min="0">
                        
                            @error('inicio_faixa_etária')
                                <div id="validationServer05Feedback" class="invalid-feedback">
                                    <strong>{{$message}}</strong>
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="fim_faixa_etaria">Fim da faixa etaria</label>
                            <input id="fim_faixa_etaria" class="form-control @error('fim_faixa_etária') is-invalid @enderror" type="number" name="fim_faixa_etária" placeholder="85" value="@if(old('fim_faixa_etária') != null){{old('fim_faixa_etária')}}@else{{$publico->fim_intervalo}}@endif" min="0">
                            
                            @error('fim_faixa_etária')
                                <div id="validationServer05Feedback" class="invalid-feedback">
                                    <strong>{{$message}}</strong>
                                </div>
                            @enderror
                        </div>
                    </div>
                    <br>
                </div>
                <div id="divOpcoes" style="@if(old('tipo') == $tipos[2] || (old('tipo') == null && $publico->tipo == $tipos[2])) display: block; @else display: none; @endif 
                                        border: 1px solid rgb(196, 196, 196);
                                        padding: 15px;
                                        border-radius: 10px;">
                    <label>Opções do campo selecionável</label>
                    <div id="divTodasOpcoes" class="row">
                        @if (old('opcoes') != null) 
                            @foreach (old('opcoes') as $i => $textoOpcao)
                                <div class="col-md-5" style="border: 1px solid rgb(196, 196, 196);
                                            padding: 15px;
                                            border-radius: 10px;
                                            margin: 15px;">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label>Opção</label>
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <input type="hidden" name="op_ids[]" value="{{'op_ids.'.$i}}">
                                                    <input type="text" name="opcoes[]" class="form-control @error('opcoes.'.$i) is-invalid @enderror" placeholder="Digite a opção selecionável" value="{{$textoOpcao}}">
                                                    @error('opcoes.'.$i)
                                                        <div id="validationServer05Feedback" class="invalid-feedback">
                                                            <strong>{{$message}}</strong>
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-3">
                                                    <a class="btn btn-danger" onclick="excluirOpcao(this)" style="cursor: pointer; color: white;">Excluir</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @elseif(old('opcoes') == null)
                            @if ($publico->opcoes)
                                @foreach ($publico->opcoes as $op)
                                    <div class="col-md-5" style="border: 1px solid rgb(196, 196, 196);
                                                padding: 15px;
                                                border-radius: 10px;
                                                margin: 15px;">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Opção</label>
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <input type="hidden" name="op_ids[]" value="{{$op->id}}">
                                                        <input type="text" name="opcoes[]" class="form-control" placeholder="Digite a opção selecionável" value="{{$op->opcao}}">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <a class="btn btn-danger" onclick="excluirOpcao(this)" style="cursor: pointer; color: white;">Excluir</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        @endif
                    </div>
                    <br>
                    <div class="row" style="text-align: right">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-info" onclick="adicionarOpcao()">Adicionar opção</button>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-6">
                        <label for="pri_dose">Total de pessoas vacinadas na 1ª dose</label>
                        <input id="pri_dose" class="form-control @error('primeria_dose') is-invalid @enderror" type="number" name="primeria_dose" placeholder="0" value="@if(old('primeria_dose') != null){{old('primeria_dose')}}@else{{$publico->total_pessoas_vacinadas_pri_dose}}@endif" min="0">

                        @error('primeria_dose')
                            <div id="validationServer05Feedback" class="invalid-feedback">
                                <strong>{{$message}}</strong>
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="seg_dose">Total de pessoas vacinadas na 2ª dose</label>
                        <input id="seg_dose" class="form-control @error('segunda_dose') is-invalid @enderror" type="number" name="segunda_dose" placeholder="0" value="@if(old('segunda_dose')!=null){{old('segunda_dose')}}@else{{$publico->total_pessoas_vacinadas_seg_dose}}@endif" min="0">

                        @error('segunda_dose')
                            <div id="validationServer05Feedback" class="invalid-feedback">
                                <strong>{{$message}}</strong>
                            </div>
                        @enderror
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <input id="atual" type="checkbox" name="atual" @if(old('atual') || (old('atual') == null && $publico->atual)) checked @endif>
                        <label for="atual">A vacinação deste público esta ocorrendo atualmente.</label>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <h5>Vincular público a pontos</h5>
                    </div>
                </div>
                <br>
                <div class="row">
                    @error('pontos')
                        <div class="col-md-12">
                            <div id="validationServer05Feedback" class="invalid-feedback">
                                <strong>{{$message}}</strong>
                            </div>
                        </div>
                    @enderror
                    @foreach ($pontos as $ponto)
                        <div class="col-md-4">
                            <input type="checkbox" name="pontos[]" value="{{$ponto->id}}" @if((old('pontos') != null && in_array($ponto->id, old('pontos'))) || (old('pontos') == null && $publico->pontos != null && $publico->pontos->contains($ponto))) checked @endif>
                            <label for="">{{$ponto->nome}}</label>
                        </div>
                    @endforeach
                </div>
                <br>
                <div class="row">
                    <div class="col-md-6" style="text-align: right;">
                        <a href="{{route('etapas.index')}}" class="btn btn-secondary" style="width: 100%; padding-top: 20px; padding-bottom: 20px; cursor:pointer; color:white;">Voltar</a>
                    </div>
                    <div class="col-md-6" style="text-align: right;">
                        <button type="submit" class="btn btn-success" style="width: 100%; padding-top: 20px; padding-bottom: 20px;">Salvar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script>
        function adicionarOpcao() {
            html = `<div class="col-md-5" style="border: 1px solid rgb(196, 196, 196);
                                    padding: 15px;
                                    border-radius: 10px;
                                    margin: 15px;">
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Opção</label>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <input type="hidden" name="op_ids[]" value="0">
                                            <input type="text" name="opcoes[]" class="form-control" placeholder="Digite a opção selecionável">
                                        </div>
                                        <div class="col-md-3">
                                            <a class="btn btn-danger" onclick="excluirOpcao(this)"  style="cursor: pointer; color: white;">Excluir</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>`
            $('#divTodasOpcoes').append(html);
        }

        function excluirOpcao(button) {
            button.parentElement.parentElement.parentElement.parentElement.parentElement.remove();
        }

        function selecionarDiv(select) {
            
            valor = select.children[select.selectedIndex].textContent;
            if (valor == "Por idade") {
                document.getElementById('divIdade').style.display = "block";
                document.getElementById('divOpcoes').style.display = "none";
                excluirOpcoes();
            } else if (valor == "Texto livre") {
                // alert(valor);
                document.getElementById('divIdade').style.display = "none";
                document.getElementById('divOpcoes').style.display = "none";
                document.getElementById('inicio_faixa_etaria').value = "";
                document.getElementById('fim_faixa_etaria').value = "";
                excluirOpcoes();
            } else if (valor == "Texto livre com campo extra selecionável") {
                // alert(valor);
                document.getElementById('divIdade').style.display = "none";
                document.getElementById('divOpcoes').style.display = "block";
                document.getElementById('inicio_faixa_etaria').value = "";
                document.getElementById('fim_faixa_etaria').value = "";
                adicionarOpcao();
            }
        }

        function excluirOpcoes() {
            
            var todasOpcoes = document.getElementById('divTodasOpcoes');
            
            for (var i = 0; i < todasOpcoes.children.length; i++) {
                console.log(todasOpcoes.children[i]);
                todasOpcoes.children[i].remove();
            }
        }
    </script>
</x-app-layout>
