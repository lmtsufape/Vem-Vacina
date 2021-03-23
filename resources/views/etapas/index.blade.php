<x-app-layout>
    <x-slot name="header">
        <div class="row">
            <div class="col-md-7">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Etapas') }}
                </h2>
            </div>

            <div class="col-md-3" style="text-align: right;">
                <a data-toggle="modal" data-target="#definirEtapa">
                    @can('definir-etapa')
                        <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            Definir etapa atual
                        </button>
                    @endcan
                </a>
            </div>

            <div class="col-md-2" style="text-align: right;">
                <a href="{{route('etapas.create')}}">
                    @can('criar-etapa')
                        <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            Adicionar etapa
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

        <div class="row">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">De</th>
                        <th scope="col">Até</th>
                        <th scope="col">Atual</th>
                        <th scope="col">Pessoas vacinadas na 1ª dose</th>
                        <th scope="col">Pessoas vacinadas na 2ª dose</th>
                        @can(['editar-etapa', 'apagar-etapa'])
                            <th scope="col">Ações</th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @foreach ($etapas as $etapa)
                        <tr>
                            <td>{{$etapa->inicio_intervalo}}</td>
                            <td>{{$etapa->fim_intervalo}}</td>
                            @if ($etapa->atual)
                                <td>Essa</td>
                            @else
                                <td></td>
                            @endif
                            <td>{{$etapa->total_pessoas_vacinadas_pri_dose}}</td>
                            <td>{{$etapa->total_pessoas_vacinadas_seg_dose}}</td>
                            <td>
                                @can('editar-etapa')
                                    <a href="#" data-toggle="modal" data-target="#editarEtapa{{$etapa->id}}"><button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Editar</button></a>
                                @endcan
                                @can('apagar-etapa')
                                <a href="#" data-toggle="modal" data-target="#excluirEtapa{{$etapa->id}}"><button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Excluir</button></a>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
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
    <!-- Modal editar etapa atual -->
    <div class="modal fade" id="editarEtapa{{$etapa->id}}" tabindex="-1" aria-labelledby="editarEtapa{{$etapa->id}}Label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarEtapa{{$etapa->id}}Label">Editar etapa de {{$etapa->inicio_intervalo}} até {{$etapa->fim_intervalo}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editar_etapa_{{$etapa->id}}" action="{{route('etapas.update', ['id' => $etapa->id])}}" method="post">
                    @csrf
                    <div class="container">
                        <input type="hidden" name="etapa_id" value="{{$etapa->id}}">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="inicio_faixa_etaria">Inicio da faixa etaria</label>
                                <input id="inicio_faixa_etaria" class="form-control @error('inicio_faixa_etaria') is-invalid @enderror" type="number" name="inicio_faixa_etaria" placeholder="80" value="@if(old('inicio_faixa_etaria') != null){{old('inicio_faixa_etaria')}}@else{{$etapa->inicio_intervalo}}@endif">

                                @error('inicio_faixa_etaria')
                                    <div id="validationServer05Feedback" class="invalid-feedback">
                                        <strong>{{$message}}</strong>
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="fim_faixa_etaria">Fim da faixa etaria</label>
                                <input id="fim_faixa_etaria" class="form-control @error('fim_faixa_etaria') is-invalid @enderror" type="number" name="fim_faixa_etaria" placeholder="85" value="@if(old('fim_faixa_etaria') != null){{old('fim_faixa_etaria')}}@else{{$etapa->fim_intervalo}}@endif">

                                @error('fim_faixa_etaria')
                                    <div id="validationServer05Feedback" class="invalid-feedback">
                                        <strong>{{$message}}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="texto">Texto adicional</label>
                                <textarea id="texto" class="form-control @error('texto') is-invalid @enderror" name="texto" cols="30" rows="5">@if(old('texto') != null){{old('texto')}}@else{{$etapa->texto}}@endif</textarea>
                            
                                @error('texto')
                                    <div id="validationServer05Feedback" class="invalid-feedback">
                                        <strong>{{$message}}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="pri_dose">Total de pessoas vacinadas na 1ª dose</label>
                                <input id="pri_dose" class="form-control @error('primeria_dose') is-invalid @enderror" type="number" name="primeria_dose" placeholder="0" value="@if(old('primeria_dose') != null){{old('primeria_dose')}}@else{{$etapa->total_pessoas_vacinadas_pri_dose}}@endif">

                                @error('primeria_dose')
                                    <div id="validationServer05Feedback" class="invalid-feedback">
                                        <strong>{{$message}}</strong>
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="seg_dose">Total de pessoas vacinadas na 2ª dose</label>
                                <input id="seg_dose" class="form-control @error('dose_unica') is-invalid @enderror" type="number" name="dose_unica" placeholder="0" value="@if(old('dose_unica') != null){{old('dose_unica')}}@else{{$etapa->total_pessoas_vacinadas_seg_dose}}@endif">

                                @error('dose_unica')
                                    <div id="validationServer05Feedback" class="invalid-feedback">
                                        <strong>{{$message}}</strong>
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary" form="editar_etapa_{{$etapa->id}}">Salvar</button>
            </div>
        </div>
        </div>
    </div>
    <!-- Fim modal editar etapa atual -->
    <!-- Modal excluir etapa atual -->
    <div class="modal fade" id="excluirEtapa{{$etapa->id}}" tabindex="-1" aria-labelledby="excluirEtapa{{$etapa->id}}Label" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="excluirEtapa{{$etapa->id}}Label">Excluir etapa de {{$etapa->inicio_intervalo}} até {{$etapa->fim_intervalo}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="excluir_etapa_{{$etapa->id}}" action="{{route('etapas.destroy', ['id' => $etapa->id])}}" method="post">
                    @csrf
                    Tem certeza que deseja excluir essa etapa?
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
@if (old('etapa_id') != null)
<script>
    $(document).ready(function() {
        $('#editarEtapa{{old('etapa_id')}}').modal('show');
    });
</script>
@endif
</x-app-layout>
