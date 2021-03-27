<x-app-layout>
    <x-slot name="header">

        <div class="grid grid-cols-6 gap-4">
            <div class="col-span-5">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">

                    {{ __('Lista de Lotes') }}
                </h2>
            </div>
            <div class="...">
                @can('criar-lote')
                    <a href="{{ route('lotes.create') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        Adicionar Lote
                    </a>
                @endcan

            </div>

          </div>

    </x-slot>
    <div class="py-12">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8 ">
            <div class="container ">
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
                <table class="table table-condensed"  id="myTable">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nº do lote</th>
                            <th scope="col">Fabricante</th>
                            <th scope="col">Nº de vacinas</th>
                            <th scope="col">Dose única</th>
                            <th scope="col" colspan="2">Tempo para segunda dose</th>
                            <th scope="col">Fabricação</th>
                            <th scope="col">Validade</th>
                            @can(['editar-lote', 'apagar-lote'])
                              <th scope="col" colspan="3">Ações</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody class="panel">
                        @foreach ($lotes as $lote)
                            <tr  data-toggle="collapse" data-target="#demo{{ $lote->id }}" >
                                <td><i class="fas fa-angle-down  fa-2x"></i> </td>
                                <td> {{ $lote->numero_lote }}</td>
                                <td> {{ $lote->fabricante }}</td>
                                <td>{{$lote->numero_vacinas}}</td>
                                <td>{{$lote->dose_unica ? 'Sim' : 'Não'}}</td>
                                <td colspan="2">{{ $lote->dose_unica ?  " - " : 'Entre '.$lote->inicio_periodo." à  ". $lote->fim_periodo." dias" }}</td>
                                <td>{{ $lote->data_fabricacao ? date('d/m/Y', strtotime($lote->data_fabricacao)) : "Data não definida"  }}</td>
                                <td>{{ $lote->data_validade ? date('d/m/Y', strtotime($lote->data_validade)) : "Data não definida" }}</td>
                                <td>
                                    @can('editar-lote')
                                        <form action="{{ route('lotes.edit', ['lote' => $lote->id]) }}" method="get">
                                            @csrf
                                            <button type="submit" class=" bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-2">
                                                Editar
                                            </button>
                                        </form>
                                    @endcan
                                </td>
                                <td>
                                    @can('apagar-lote')
                                        <form action="{{ route('lotes.destroy', ['lote' => $lote->id]) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button onclick="return confirm('Você tem certeza?')" type="submit" class=" bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded mb-2">
                                                Excluir
                                            </button>
                                        </form>
                                    @endcan
                                </td>
                                <td>
                                    @can('distribuir-lote')
                                        <form action="{{ route('lotes.distribuir', ['lote' => $lote->id]) }}" method="get">
                                            <button type="submit" @if($lote->numero_vacinas == 0) disabled @endif class="disabled:opacity-50 bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-2 rounded">
                                                Distribuir
                                            </button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                            <tr id="demo{{ $lote->id }}" class="collapse">
                                <td colspan="12" class="hiddenRow">
                                    <table class="table table-bordered table-info">
                                        <thead>
                                        <tr>
                                            <th scope="col">Públicos associados com esse lote</th>
                                            {{-- <th scope="col" colspan="2">Ações</th> --}}
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($lote->etapas as $key => $etapa)
                                        <tr>
                                            @if ($etapa->tipo == $tipos[0])
                                                <td> {{ 'De '.$etapa->inicio_intervalo." às ".$etapa->fim_intervalo}}</td>
                                            @elseif($etapa->tipo == $tipos[1] || $etapa->tipo == $tipos[2])
                                                <td> {{$etapa->texto}} </td>
                                            @endif
                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

              {{ $lotes->links() }}
            </div>
        </div>
    </div>
  </x-app-layout>
