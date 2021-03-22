<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Adicionar uma nova etapa') }}
        </h2>
    </x-slot>

    <div style="margin-top: 30px;">
        <form action="{{route('etapas.store')}}" method="post">
            @csrf
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <label for="tipo">Classficação do público</label>
                        <select name="tipo" id="tipo" class="form-control" onchange="selecionarDiv(this)">
                            <option value="" selected disabled>-- selecione a classificação do público --</option>
                            <option value="{{$tipos[0]}}">Por idade</option>
                            <option value="{{$tipos[1]}}">Texto livre</option>
                            <option value="{{$tipos[2]}}">Texto livre com campo extra selecionável</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="texto">Texto exibido no agendamento</label>
                        <input type="text" id="texto" name="texto" class="form-control" value="{{old('texto')}}">

                        @error('texto')
                            <div id="validationServer05Feedback" class="invalid-feedback">
                                <strong>{{$message}}</strong>
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="texto_da_home">Texto exibido na home</label>
                        <input id="texto_da_home" type="text" class="form-control @error('texto_da_home') is-invalid @enderror" name="texto_da_home" >

                        @error('texto_da_home')
                            <div id="validationServer05Feedback" class="invalid-feedback">
                                <strong>{{$message}}</strong>
                            </div>
                        @enderror
                    </div>
                </div>
                <br>
                <div id="divIdade" style="display: none;">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="inicio_faixa_etaria">Inicio da faixa etaria</label>
                            <input id="inicio_faixa_etaria" class="form-control @error('inicio_faixa_etaria') is-invalid @enderror" type="number" name="inicio_faixa_etaria" placeholder="80" value="{{old('inicio_faixa_etaria')}}">
                        
                            @error('inicio_faixa_etaria')
                                <div id="validationServer05Feedback" class="invalid-feedback">
                                    <strong>{{$message}}</strong>
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="fim_faixa_etaria">Fim da faixa etaria</label>
                            <input id="fim_faixa_etaria" class="form-control @error('fim_faixa_etaria') is-invalid @enderror" type="number" name="fim_faixa_etaria" placeholder="85" value="{{old('fim_faixa_etaria')}}">
                            
                            @error('fim_faixa_etaria')
                                <div id="validationServer05Feedback" class="invalid-feedback">
                                    <strong>{{$message}}</strong>
                                </div>
                            @enderror
                        </div>
                    </div>
                    <br>
                </div>
                <div id="divOpcoes" style="display: none; 
                                           border: 1px solid rgb(196, 196, 196);
                                           padding: 15px;
                                           border-radius: 10px;">
                    <label>Opções do campo selecionável</label>
                    <div id="divTodasOpcoes" class="row">
                        <div class="col-md-5" style="border: 1px solid rgb(196, 196, 196);
                                    padding: 15px;
                                    border-radius: 10px;
                                    margin: 15px;">
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Opção</label>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <input type="text" name="opcoes" class="form-control" placeholder="Digite a opção selecionável">
                                        </div>
                                        <div class="col-md-3">
                                            <a class="btn btn-danger" onclick="excluirOpcao(this)" style="cursor: pointer; color: white;">Excluir</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                        <input id="pri_dose" class="form-control @error('primeria_dose') is-invalid @enderror" type="number" name="primeria_dose" placeholder="0" value="{{old('primeria_dose')}}">
                    
                        @error('primeria_dose')
                            <div id="validationServer05Feedback" class="invalid-feedback">
                                <strong>{{$message}}</strong>
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="seg_dose">Total de pessoas vacinadas na 2ª dose</label>
                        <input id="seg_dose" class="form-control @error('segunda_dose') is-invalid @enderror" type="number" name="segunda_dose" placeholder="0" value="{{old('segunda_dose')}}">
                    
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
                        <input id="atual" type="checkbox" name="atual" @if(old('atual')) checked @endif>
                        <label for="atual">Esta é a etapa que está ocorrendo atualmente.</label>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12" style="text-align: right;">
                        <button type="submit" class="btn btn-success" style="width: 25%;">Adicionar</button>
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
                                            <input type="text" name="opcoes" class="form-control" placeholder="Digite a opção selecionável">
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
            } else if (valor == "Texto livre") {
                // alert(valor);
                document.getElementById('divIdade').style.display = "none";
                document.getElementById('divOpcoes').style.display = "none";
                document.getElementById('inicio_faixa_etaria').value = "";
                document.getElementById('fim_faixa_etaria').value = "";
            } else if (valor == "Texto livre com campo extra selecionável") {
                // alert(valor);
                document.getElementById('divIdade').style.display = "none";
                document.getElementById('divOpcoes').style.display = "block";
                document.getElementById('inicio_faixa_etaria').value = "";
                document.getElementById('fim_faixa_etaria').value = "";
            }
        }
    </script>
</x-app-layout>