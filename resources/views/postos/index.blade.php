<x-app-layout>
  <x-slot name="header">
    <div class="grid grid-cols-6 gap-4">
        <div class="col-span-5">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Lista de Postos') }}
            </h2>
        </div>
        <div class="...">
            @can('criar-posto')
                <a href="{{ route('postos.create') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    Adicionar Posto
                </a>
            @endcan
        </div>
      </div>
  </x-slot>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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
            <div class="container">
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
                            <tr id="demo{{ $posto->id }}" class="collapse">

                                    <td colspan="5" class="hiddenRow">
                                        <table class="table table-bordered table-info">
                                          <thead>
                                            <tr>
                                              <th scope="col">Nº do lote</th>
                                              <th scope="col">Fabricante</th>
                                              <th scope="col">Dose única</th>
                                              <th scope="col">Tempo para a segunda dose</th>
                                              <th scope="col">Nº de vacinas disponíveis <i class="fas fa-exclamation-circle"  data-toggle="tooltip" data-placement="top" title="Quantidade de vacinas menos quantidade de vacinas reservadas"></i></th>
                                              <th scope="col" colspan="2">Ações</th>
                                            </tr>
                                          </thead>
                                          <tbody>
                                            @foreach ($posto->lotes as $lote)
                                            <tr>
                                              <th scope="row">{{$lote->numero_lote}}</th>
                                              <td>{{$lote->fabricante }}</td>
                                              <td>{{$lote->dose_unica ? 'Sim' : 'Não'}}</td>
                                              <td>{{$lote->dose_unica ? " - " : 'Entre '.$lote->inicio_periodo." à  ". $lote->fim_periodo." dias" }} </td>
                                              <td>{{$lote->pivot->qtdVacina - $posto->getCandidatosPorLote($lote->id) }}</td>
                                              <td>
                                                <form action="{{ route('lotes.alterarQuantidadeVacina') }}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="posto_id" value="{{ $posto->id }}">
                                                    <input type="hidden" name="lote_id" value="{{ $lote->id }}">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <input class="form-control" name="quantidade" type="number" placeholder="Quantidade">
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
            </div>
          </div>
      </div>
  </div>
</x-app-layout>
