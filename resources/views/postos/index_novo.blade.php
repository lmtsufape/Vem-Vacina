<x-app-layout>
    <x-slot name="header">
        <div class="row">
            <div class="col-md-9">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Lista de Pontos de Vacinação') }}
                </h2>
            </div>
            <div class="col-md-3" style="text-align: right">
                @can('criar-posto')
                    <a href="{{ route('postos.create') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        Adicionar Ponto de Vacinação
                    </a>
                @endcan
            </div>
        </div>

    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="container">
              @if (session('message'))
                  <div class="alert alert-success">
                      {{ session('message') }}
                  </div>
              @endif
              @if (count($errors) > 0)
                  <div class="alert alert-danger">
                      <ul>
                          @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                          @endforeach
                      </ul>
                  </div>
              @endif
              <div class="table-responsive">
                  <table class="table table-condensed"  id="myTable">
                      <thead>
                          <tr>
                              <th scope="col">#</th>
                              <th scope="col">Nome</th>
                              <th scope="col">Endereço</th>
                              <th scope="col" colspan="2">Ações</th>
                          </tr>
                      </thead>
                      <tbody class="panel">
                          @foreach ($postos as $posto)
                              <tr  data-toggle="collapse" data-target="#demo{{ $posto->id }}" >
                                  <td><i class="fas fa-angle-down  fa-2x"></i> </td>
                                  <td> {{ $posto->nome }}</td>
                                  <td>{{ $posto->endereco }}</td>
                                  <td>
                                      @can('editar-posto')
                                          <form action="{{ route('postos.edit', ['posto' => $posto->id]) }}" method="get">
                                              @csrf
                                              <button type="submit" class=" bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-2">
                                                  Editar
                                              </button>
                                          </form>
                                      @endcan
                                  </td>
                                  <td>
                                      @can('apagar-posto')
                                          <form action="{{ route('postos.destroy', ['posto' => $posto->id]) }}" method="post">
                                              @csrf
                                              @method('delete')
                                              <button onclick="return confirm('Você tem certeza?')" type="submit" class=" bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded mb-2">
                                                  Excluir
                                              </button>
                                          </form>
                                      @endcan
                                  </td>
                              </tr>
                              <tr id="demo{{ $posto->id }}" class="collapse @if($posto->id == old('posto_id') ) show @endif">

                                      <td colspan="5" class="hiddenRow">
                                          <table class="table table-bordered table-info">
                                            <thead>
                                              <tr>
                                                <th scope="col">Nº do lote</th>
                                                <th scope="col">Faixa</th>
                                                <th scope="col">Fabricante</th>
                                                <th scope="col">Dose única</th>
                                                <th scope="col">Tempo para a segunda dose</th>
                                                <th scope="col">Nº de vacinas <i class="fas fa-exclamation-circle"  data-toggle="tooltip" data-placement="top" title="Quantidade de vacinas - quantidade de candidatos nesse lote = vacinas disponíveis"></i></th>
                                                <th scope="col" colspan="2">Ações</th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $pivot = $lotes_pivot->where('posto_vacinacao_id', $posto->id);
                                                @endphp
                                              @foreach ($pivot as $key => $lote_pivot)
                                              <tr>
                                                  <th scope="row">{{$lote_pivot->lote->numero_lote}}</th>
                                                  <td>
                                                  @foreach ($lote_pivot->lote->etapas as $key1 => $etapa)

                                                  @if ($etapa->tipo == $tipos[0])
                                                    <span class="d-inline-block text-truncate" class="d-inline-block" tabindex="0" data-toggle="tooltip" title="{{ $lote_pivot->lote->etapas->count() > 1 ? 'De '.$etapa->inicio_intervalo." às ".$etapa->fim_intervalo ."/" : 'De '.$etapa->inicio_intervalo." às ".$etapa->fim_intervalo  }}" style="max-width: 150px;">
                                                        {{ $lote_pivot->lote->etapas->count() > 1 ? 'De '.$etapa->inicio_intervalo." às ".$etapa->fim_intervalo ."/" : 'De '.$etapa->inicio_intervalo." às ".$etapa->fim_intervalo  }}
                                                    </span>

                                                  @elseif($etapa->tipo == $tipos[1] || $etapa->tipo == $tipos[2])
                                                    <span class="d-inline-block text-truncate" class="d-inline-block" tabindex="0" data-toggle="tooltip" title="{{$etapa->texto."-"}}" style="max-width: 150px;">
                                                        {{$etapa->texto."-"}}
                                                    </span>
                                                  @endif
                                                  @endforeach
                                                </td>
                                                <th scope="row">
                                                    <span class="d-inline-block text-truncate" class="d-inline-block" tabindex="0" data-toggle="tooltip" title="{{$lote_pivot->lote->fabricante}}" style="max-width: 100px;">
                                                        {{$lote_pivot->lote->fabricante}}
                                                    </span>
                                                </th>
                                                <td>{{$lote_pivot->lote->dose_unica ? 'Sim' : 'Não'}}</td>
                                                <td>{{$lote_pivot->lote->dose_unica ? " - " : 'Entre '.$lote_pivot->lote->inicio_periodo." à  ". $lote_pivot->lote->fim_periodo." dias" }} </td>
                                                <td>{{($lote_pivot->qtdVacina - $posto->candidatos()->where('lote_id', $lote_pivot->id)->count())}}</td>
                                                {{-- <td>{{$lote_pivot->qtdVacina}}</td> --}}
                                                {{-- <td>{{($posto->candidatos()->where('lote_id', $lote_pivot->id)->count())}}</td> --}}
                                                {{-- <td>{{($lote_pivot->candidatos()->count() )}}</td> --}}

                                                <td scope="row">
                                                  <form action="{{ route('lotes.alterarQuantidadeVacina') }}" method="post">
                                                      @csrf
                                                      <input type="hidden" name="posto_id" value="{{ $posto->id }}">
                                                      <input type="hidden" name="lote_id" value="{{ $lote_pivot->id }}">
                                                      <input type="hidden" name="lote_original_id" value="{{ $lote_pivot->lote->id }}">
                                                      <div class="row">
                                                          <div class="col-6">
                                                              <input class="form-control" name="quantidade"  min="1" type="number" placeholder="Quantidade">
                                                          </div>
                                                          <div class="col-2">
                                                              <button class="btn btn-success">Devolver</button>
                                                          </div>
                                                      </div>
                                                  </form>
                                                </td>
                                              </tr>

                                              @endforeach
                                            </tbody>
                                          </table>
                                      </td>
                              </tr>
                          @endforeach

                      </tbody>
                  </table>
                  {{ $postos->links() }}
              </div>
            </div>
        </div>
    </div>
  </x-app-layout>
