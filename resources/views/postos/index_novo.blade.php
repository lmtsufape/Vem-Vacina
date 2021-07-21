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
            {{-- <div class="col-md-2" style="text-align: right">

                @can('ver-fila')
                    <a href="{{ route('fila.index') }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                        {{ __('Fila de Espera') }}
                    </a>
                @endcan
            </div> --}}
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
                <form action="{{ route('postos.index.new') }}" method="get">
                    <select class="custom-select" style="height: 200px" name="posto[]" multiple>
                        @foreach ($todosPosto as $posto)
                            <option value="{{ $posto->id }}" >{{ $posto->nome }}</option>
                        @endforeach
                    </select>

                    <button type="submit" class="btn btn-primary mt-1">
                        Ver
                    </button>

                </form>
                <br>
              <div class="table-responsive">
                  <table class="table table-condensed"  id="myTable">
                      <thead>
                          <tr>
                              <th scope="col">#</th>
                              <th scope="col">Nome</th>
                              <th scope="col">Endereço</th>
                              <th scope="col">Dias</th>
                              <th scope="col" colspan="2">Ações</th>
                          </tr>
                      </thead>
                      <tbody class="panel">
                          @foreach ($postos as $posto)
                              <tr  data-toggle="collapse" data-target="#demo{{ $posto->id }}" >
                                  <td><i class="fas fa-angle-down  fa-2x"></i> </td>
                                  <td> {{ $posto->nome }}</td>
                                  <td>
                                    <span class="d-inline-block text-truncate" class="d-inline-block" tabindex="0" data-toggle="tooltip" title="{{ $posto->endereco }}" style="max-width: 150px;">
                                        {{ $posto->endereco  }}
                                    </span>

                                  </td>
                                  <td scope="row">
                                        @if($posto->funciona_domingo)
                                            <small class="text-success">D</small>
                                        @else
                                            <small class="text-danger">D</small>
                                        @endif
                                        @if($posto->funciona_segunda)
                                            <small class="text-success">S</small>
                                        @else
                                            <small class="text-danger">S</small>
                                        @endif
                                        @if($posto->funciona_terca)
                                            <small class="text-success">T</small>
                                        @else
                                            <small class="text-danger">T</small>
                                        @endif
                                        @if($posto->funciona_quarta)
                                            <small class="text-success">Q</small>
                                        @else
                                            <small class="text-danger">Q</small>
                                        @endif
                                        @if($posto->funciona_quinta)
                                            <small class="text-success">Q</small>
                                        @else
                                            <small class="text-danger">Q</small>
                                        @endif
                                        @if($posto->funciona_sexta)
                                            <small class="text-success">S</small>
                                        @else
                                            <small class="text-danger">S</small>
                                        @endif
                                        @if($posto->funciona_sabado)
                                            <small class="text-success">S</small>
                                        @else
                                            <small class="text-danger">S</small>
                                        @endif
                                  </td>
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
                                  <td>
                                      @can('apagar-posto')
                                          <form action="{{ route('postos.arquivar', ['id' => $posto->id, 'status' => 'arquivado']) }}" method="post">
                                              @csrf
                                              
                                              <button onclick="return confirm('Você tem certeza?')" type="submit" class=" bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded mb-2">
                                                  Arquivar
                                              </button>
                                          </form>
                                      @endcan
                                  </td>
                              </tr>
                              <tr id="demo{{ $posto->id }}" class="collapse @if($posto->id == old('posto_id') ) show @endif">

                                      <td colspan="7" class="hiddenRow">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-info">
                                              <thead>
                                                <tr>
                                                  <th scope="col">Nº do lote</th>
                                                  <th scope="col">Faixa</th>
                                                  <th scope="col">Fabricante</th>
                                                  <th scope="col">Dose única</th>
                                                  {{-- <th scope="col">Tempo para a segunda dose</th> --}}
                                                  <th scope="col">Nº de vacinas <i class="fas fa-exclamation-circle"  data-toggle="tooltip" data-placement="top" title="Quantidade de vacinas - quantidade de candidatos nesse lote = vacinas disponíveis"></i></th>
                                                  <th scope="col" colspan="2">Ações</th>
                                                </tr>
                                              </thead>
                                              <tbody>
                                                  @php
                                                      $pivot = $lotes_pivot->where('posto_vacinacao_id', $posto->id);
                                                      $candidatosPosto = $posto->candidatos();
                                                  @endphp
                                                @foreach ($pivot as $key => $lote_pivot)
                                                <tr>
                                                    <th scope="row">{{$lote_pivot->lote->numero_lote}}</th>
                                                    <td>
                                                    @foreach ($lote_pivot->lote->etapas as $key1 => $etapa)
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <span class="d-inline-block text-truncate" class="d-inline-block" tabindex="0" data-toggle="tooltip" title="{{ $etapa->texto }}" style="max-width: 150px;">
                                                                    {{$etapa->texto ." -" }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    {{-- @if ($etapa->tipo == $tipos[0])

                                                    @elseif($etapa->tipo == $tipos[1] || $etapa->tipo == $tipos[2])
                                                      <span class="d-inline-block text-truncate" class="d-inline-block" tabindex="0" data-toggle="tooltip" title="{{$etapa->texto."-"}}" style="max-width: 150px;">
                                                          {{$etapa->texto."-"}}
                                                      </span>
                                                    @endif --}}
                                                    @endforeach
                                                  </td>
                                                  <th scope="row">
                                                      <span class="d-inline-block text-truncate" class="d-inline-block" tabindex="0" data-toggle="tooltip" title="{{$lote_pivot->lote->fabricante}}" style="max-width: 100px;">
                                                          {{$lote_pivot->lote->fabricante}}
                                                      </span>
                                                  </th>
                                                  <td>{{$lote_pivot->lote->dose_unica ? 'Sim' : 'Não'}}</td>
                                                  {{-- <td>{{$lote_pivot->lote->dose_unica ? " - " : 'Entre '.$lote_pivot->lote->inicio_periodo." à  ". $lote_pivot->lote->fim_periodo." dias" }} </td> --}}
                                                  <td>{{($lote_pivot->qtdVacina - $posto->candidatos()->where('lote_id', $lote_pivot->id)->count())}}</td>
                                                  {{-- <td>{{$lote_pivot->qtdVacina}}</td> --}}
                                                  {{-- <td>{{($posto->candidatos()->where('lote_id', $lote_pivot->id)->count())}}</td> --}}
                                                  {{-- <td>{{($lote_pivot->candidatos()->count() )}}</td> --}}

                                                  <td scope="row">
                                                    <div class="row">
                                                        <div class="col">
                                                            <form action="{{ route('lotes.alterarQuantidadeVacina') }}" method="post">
                                                                @csrf
                                                                <input type="hidden" name="posto_id" value="{{ $posto->id }}">
                                                                <input type="hidden" name="lote_id" value="{{ $lote_pivot->id }}">
                                                                <input type="hidden" name="lote_original_id" value="{{ $lote_pivot->lote->id }}">

                                                                        <input class="form-control" name="quantidade" style="width: 100%"  min="1" type="number" placeholder="Quantidade">

                                                                        <button style="width: 100%" class="btn btn-success mt-1">Devolver</button>

                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                  </td>
                                                </tr>

                                                @endforeach
                                              </tbody>
                                            </table>
                                        </div>
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
