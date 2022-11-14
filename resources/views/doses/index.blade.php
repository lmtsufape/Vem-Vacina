<x-app-layout>
    <x-slot name="header">
        <div class="row">
            <div class="col-md-10">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Doses') }}
                </h2>
            </div>

            <div class="col-md-2" style="text-align: right;">
                <a href="{{route('doses.create')}}">
                    @can('criar-dose')
                        <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            Adicionar Dose
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
        @if(session('sucesso'))
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-success" role="alert">
                        <p>{{session('sucesso')}}</p>
                    </div>
                </div>
            </div>
        @endif

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
                    <table class="table table-condensed" id="myTable">
                        <thead>
                        <tr>
                            <th scope="col" style="width: 3%">#</th>
                            <th scope="col" style="width: 30%">Nome da Dose</th>
                            <th scope="col" style="width: 30%">Dose Anterior</th>
                            <th scope="col" style="width: 30%">Exibir na home?</th>
                            @can(['editar-dose', 'apagar-dose'])
                                <th scope="col" colspan="2" style="width: 5%">Ações</th>
                            @endcan
                        </tr>
                        </thead>
                        <tbody class="panel">
                        @foreach ($doses as $dose)
                            <tr data-toggle="collapse" data-target="#demo{{ $dose->id }}">
                                <td><i class="fas fa-angle-down  fa-2x"></i></td>
                                <td> {{ $dose->nome }}
                                @if($dose->dose_anterior_id == 0)
                                    <td>{{\App\Models\Candidato::DOSE_ENUM[4]}}</td>
                                @elseif($dose->dose_anterior_id == -1)
                                    <td>Nenhuma</td>
                                @else
                                    <td> {{\App\Models\Dose::find($dose->dose_anterior_id)->nome }}</td>
                                @endif
                                <td>
                                    @if($dose->exibir_home == true)
                                        Sim
                                    @else
                                        Não
                                    @endif
                                </td>
                                <td>
                                    @can('editar-dose')
                                        <form action="{{ route('doses.edit', ['id' => $dose->id]) }}" method="get">
                                            @csrf
                                            <button type="submit" class=" bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-2">
                                                Editar
                                            </button>
                                        </form>
                                    @endcan
                                </td>
                                <td>
                                    @can('apagar-dose')
                                        <form action="{{ route('doses.destroy', ['id' => $dose->id]) }}" method="post">
                                            @csrf
                                            <button onclick="return confirm('Você tem certeza?')" type="submit" class=" bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded mb-2">
                                                Excluir
                                            </button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                            <tr id="demo{{$dose->id}}" class="collapse">
                                <td colspan="12" class="hiddenRow">
                                    <table class="table table-bordered table-info">
                                        <thead>
                                        <tr>
                                            <th scope="col">Públicos associados com essa dose</th>
                                            {{-- <th scope="col" colspan="2">Ações</th> --}}
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($dose->etapas as $key => $etapa)
                                            <tr>
                                                {{-- @if ($etapa->tipo == $tipos[0])
                                                    <td> {{ 'De '.$etapa->inicio_intervalo." às ".$etapa->fim_intervalo}}</td>
                                                @elseif($etapa->tipo == $tipos[1] || $etapa->tipo == $tipos[2])
                                                    <td> {{$etapa->texto}} </td>
                                                @endif --}}
                                                <td>{{ $etapa->texto }}</td>
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
</x-app-layout>
