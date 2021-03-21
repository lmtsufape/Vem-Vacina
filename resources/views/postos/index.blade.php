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
            <div class="container">
                <table class="table table-condensed"  id="myTable">
                    <thead>
                        <tr>
                            <th scope="col">Nome</th>
                            <th scope="col">Endereço</th>
                            <th scope="col">Nº de Vacinas</th>
                            <th scope="col" colspan="2">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="panel">
                        @foreach ($postos as $posto)
                            <tr data-toggle="collapse" data-target="#demo1" data-parent="#myTable">
                                <td>{{ $posto->nome }}</td>
                                <td>{{ $posto->endereco }}</td>
                                <td>{{ $posto->getVacinasDisponivel() }}</td>
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
                            <tr id="demo1" class="collapse">

                                    <td colspan="5" class="hiddenRow">
                                        <table class="table table-bordered table-info">
                                          <thead>
                                            <tr>
                                              <th scope="col">Nº do lote</th>
                                              <th scope="col">Fabricante</th>
                                              <th scope="col">Nº de vacinas</th>
                                              <th scope="col">Segunda Dose</th>
                                              <th scope="col">Tempo para a segunda dose</th>
                                            </tr>
                                          </thead>
                                          <tbody>
                                            @foreach ($posto->lotes as $lote)
                                            <tr>
                                              <th scope="row">{{$lote->numero_lote}}</th>
                                              <td>{{$lote->fabricante}}</td>
                                              <td>{{$lote->pivot->qtdVacina}}</td>
                                              <td>{{$lote->segunda_dose ? 'Sim' : 'Não'}}</td>
                                              <td>{{ $lote->segunda_dose && $lote->fim_periodo  ? 'Entre '.$lote->inicio_periodo." à  ". $lote->fim_periodo." dias" : " - "}} </td>
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
