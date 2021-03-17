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
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Definir etapa atual
                    </button>
                </a>
            </div>

            <div class="col-md-2" style="text-align: right;">
                <a href="{{route('etapas.create')}}">
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Adicionar etapa
                    </button>
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
                        <th scope="col">Excluir</th>
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
</x-app-layout>