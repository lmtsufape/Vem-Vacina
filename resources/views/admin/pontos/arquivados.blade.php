<x-app-layout>
    <x-slot name="header">
        <div class="row">
            <div class="col-md-8">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Lista de Arquivados') }}
                </h2>
                
            </div>
            <div class="col-md-4" style="text-align: right;">

            </div>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="container">
                <div class="row">
                    @if(session('message'))
                    <div class="col-md-12">
                        <div class="alert alert-success" role="alert">
                            <p>{{session('message')}}</p>
                        </div>
                    </div>
                    @endif
                </div>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <br>
                <table class="table table-hover">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Endereço</th>
                        <th scope="col">Opção</th>
                      </tr>
                    </thead>
                    <tbody>
                        
                        @foreach ($pontos as $ponto)
                            <tr>
                                <th scope="row">{{ $loop->index + 1 }}</th>
                                <td>{{ $ponto->nome }}</td>
                                <td>{{ $ponto->endereco }}</td>
                                <td>
                                    @can('apagar-posto')
                                        <form action="{{ route('postos.arquivar', ['id' => $ponto->id, 'status' => 'ativo']) }}" method="post">
                                            @csrf
                                            
                                            <button onclick="return confirm('Você tem certeza?')" type="submit" class=" bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mb-2">
                                                Ativar
                                            </button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                      
                    </tbody>
                </table>

            </div>
        </div>
    </div>




</x-app-layout>

