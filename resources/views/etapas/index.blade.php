<x-app-layout>
    <x-slot name="header">
        <div class="row">
            <div class="col-md-7">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Públicos') }}
                </h2>
            </div>

            <div class="col-md-3" style="text-align: right;">
                <a data-toggle="modal" data-target="#definirEtapa">
                    {{-- @can('definir-etapa')
                        <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            Definir etapa atual
                        </button>
                    @endcan --}}
                </a>
            </div>

            <div class="col-md-2" style="text-align: right;">
                <a href="{{route('etapas.create')}}">
                    @can('criar-etapa')
                        <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            Adicionar público
                        </button>
                    @endcan
                </a>
            </div>
        </div>
    </x-slot>

    <div class="container" style="margin-top: 30px;">
        @if(session('mensagem'))
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-success" role="alert">
                        <p>{{session('mensagem')}}</p>
                    </div>
                </div>
            </div>
        @endif
        @if(session('error'))
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-danger" role="alert">
                        <p>{{session('error')}}</p>
                    </div>
                </div>
            </div>
        @endif
        <div class="row" style="margin-top: 10px; margin-bottom: 50px;">
            <div class="col-md-12">
                <div class="accordion" id="accordionExample">
                    @foreach ($etapas as $etapa)
                        <div class="card">
                            <div class="card-header" id="headingOne">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-9">
                                        <h2 class="mb-0">
                                            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse{{$etapa->id}}" aria-expanded="true" aria-controls="collapseOne">
                                                @if ($etapa->tipo == $tipos[0]) 
                                                    De {{$etapa->inicio_intervalo}} às {{$etapa->fim_intervalo}}
                                                @elseif($etapa->tipo == $tipos[1] || $etapa->tipo == $tipos[2]) 
                                                    {{$etapa->texto}}
                                                @endif
                                            </button>
                                        </h2>
                                    </div>
                                    <div class="col-md-3" style="text-align: right;">
                                        <a href="{{route('etapas.edit', ['id' => $etapa->id])}}" class="btn btn-primary">Editar</a>
                                        <button class="btn btn-danger" data-toggle="modal" data-target="#excluirEtapa{{$etapa->id}}">Excluir</button>
                                    </div>
                                </div>
                            </div>
                            </div>
                        
                            <div id="collapse{{$etapa->id}}" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                                <div class="card-body">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label for="tipo_{{$etapa->id}}">Tipo de público</label>
                                                @if ($etapa->tipo == $tipos[0])
                                                    <input id="tipo_{{$etapa->id}}" class="form-control" type="text" value="Representado pela idade" disabled>
                                                @elseif($etapa->tipo == $tipos[1] || $etapa->tipo == $tipos[2])
                                                    <input id="tipo_{{$etapa->id}}" class="form-control" type="text" value="Representado por texto" disabled>
                                                @endif
                                            </div>
                                            <div class="col-md-3">
                                                <label for="exibir_na_home_{{$etapa->id}}">É exibido na home?</label>
                                                @if ($etapa->exibir_na_home)
                                                    <input id="exibir_na_home_{{$etapa->id}}" class="form-control" type="text" value="Sim" disabled>
                                                @else
                                                    <input id="exibir_na_home_{{$etapa->id}}" class="form-control" type="text" value="Não" disabled>
                                                @endif
                                            </div>
                                            <div class="col-md-3">
                                                <label for="exibir_no_form_{{$etapa->id}}">Esta no agendamento?</label>
                                                @if ($etapa->exibir_no_form)
                                                    <input id="exibir_no_form_{{$etapa->id}}" class="form-control" type="text" value="Sim" disabled>
                                                @else
                                                    <input id="exibir_no_form_{{$etapa->id}}" class="form-control" type="text" value="Não" disabled>
                                                @endif
                                            </div>
                                            <div class="col-md-3">
                                                <label for="opcoes_{{$etapa->id}}">Tem opções para selecionar?</label>
                                                @if ($etapa->tipo == $tipos[2])
                                                    <input id="opcoes_{{$etapa->id}}" class="form-control" type="text" value="Sim" disabled>
                                                @else
                                                    <input id="opcoes_{{$etapa->id}}" class="form-control" type="text" value="Não" disabled>
                                                @endif
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label for="texto_da_home_{{$etapa->id}}">Texto que aparece na home</label>
                                                @if ($etapa->texto_home != null)
                                                    <input id="texto_da_home_{{$etapa->id}}" class="form-control" type="text" value="{{$etapa->texto_home}}" disabled>
                                                @else
                                                    <input id="texto_da_home_{{$etapa->id}}" class="form-control" type="text" value="Não tem texto opcional" disabled>
                                                @endif
                                            </div>
                                            <div class="col-md-3">
                                                <label for="pri_dose_{{$etapa->id}}">Pessoas vacinadas com 1ª dose</label>
                                                <input id="pri_dose_{{$etapa->id}}" class="form-control" type="text" value="{{$etapa->total_pessoas_vacinadas_pri_dose}}" disabled>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="seg_dose_{{$etapa->id}}">Pessoas vacinadas com 2ª dose</label>
                                                <input id="seg_dose_{{$etapa->id}}" class="form-control" type="text" value="{{$etapa->total_pessoas_vacinadas_seg_dose}}" disabled>
                                            </div>
                                            <div class="col-md-3" style="position: relative; top: 35px;">
                                                <input id="atual_{{$etapa->id}}" type="checkbox" @if($etapa->atual) checked @endif onclick="salvarEtapa(this, {{$etapa->id}})" @can('definir-etapa') @else disabled @endif>
                                                <label for="atual_{{$etapa->id}}">Faz parte da vacinação atual?</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        
    </div>

<!-- Modal definir etapa atual -->
<div class="modal fade" id="definirEtapa" tabindex="-1" aria-labelledby="definirEtapaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="definirEtapaLabel">Definir etapa atual</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="container modal-body">
            <form id="form_definir_etapa_atual" action="{{route('etapas.definirEtapa')}}" method="post">
                @csrf
                <div class="row">
                    <div class="col-sm-12">
                        <label for="etapa_atual">Escolha a etapa atual</label>
                        <select name="etapa_atual" id="etapa_atual" class="form-control" required>
                            <option value="" disabled selected>-- Etapa atual --</option>
                            @foreach ($etapas as $etapa)
                                <option value="{{$etapa->id}}" @if($etapa->atual) selected @endif>De {{$etapa->inicio_intervalo}} à {{$etapa->fim_intervalo}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary" form="form_definir_etapa_atual">Salvar</button>
        </div>
      </div>
    </div>
</div>
<!-- Fim modal definir etapa atual -->

@foreach ($etapas as $etapa)
    <!-- Modal excluir etapa atual -->
    <div class="modal fade" id="excluirEtapa{{$etapa->id}}" tabindex="-1" aria-labelledby="excluirEtapa{{$etapa->id}}Label" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="excluirEtapa{{$etapa->id}}Label">
                    @if($etapa->tipo == $tipos[0]) 
                        Excluir público {{$etapa->inicio_intervalo}} até {{$etapa->fim_intervalo}}
                    @elseif($etapa->tipo == $tipos[1] || $etapa->tipo == $tipos[2])
                        Excluir público {{$etapa->texto}}
                    @endif    
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="excluir_etapa_{{$etapa->id}}" action="{{route('etapas.destroy', ['id' => $etapa->id])}}" method="post">
                    @csrf
                    Tem certeza que deseja excluir esse público?
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Não</button>
                <button type="submit" class="btn btn-primary" form="excluir_etapa_{{$etapa->id}}">Sim</button>
            </div>
        </div>
        </div>
    </div>
    <!-- Fim modal excluir etapa atual -->
@endforeach
<script>
    function salvarEtapa(input, id) {
        valor = input.checked;
        $.ajax({
            url: "{{route('etapas.definirEtapa')}}",
            method: 'get',
            type: 'get',
            data: {
                etapa_id: id,
                valor: function () {
                    if (valor) {
                        return true;
                    } else {
                        return false;
                    }
                } 
            },
            statusCode: {
                404: function() {
                    alert("Nenhum posto encontrado");
                }
            },
            success: function(data){
                alert("Salvo com sucesso");
            }
        })
    }
</script>
@if (old('etapa_id') != null)
<script>
    $(document).ready(function() {
        $('#editarEtapa{{old('etapa_id')}}').modal('show');
    });
</script>
@endif
</x-app-layout>
