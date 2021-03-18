<x-app-layout>
  <x-slot name="header">
    <div class="grid grid-cols-6 gap-4">
        <div class="col-span-5">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Lista de Postos') }}
            </h2>
        </div>
        <div class="...">
            <a href="{{ route('postos.create') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                Adicionar Posto
            </a>
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
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Nome</th>
                        <th scope="col">Endereço</th>
                        <th scope="col">Nº de vacinas disponíveis</th>
                        <th scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($postos as $posto)
                    <tr>
                        <td>{{$posto->nome}}</td>
                        <td>{{$posto->endereco}}</td>
                        <td>{{ "-" }}</td>
                        <td>
                            <div class="row">
                                <div class="col-md-4">
                                  <form action="{{ route('postos.edit', ['posto' => $posto->id]) }}" method="get">
                                      @csrf
                                      <button type="submit" class=" bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-2">
                                          Editar
                                      </button>
                                  </form>
                                </div>
                                <div class="col-md-4 ">
                                    <form action="{{ route('postos.destroy', ['posto' => $posto->id]) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button onclick="return confirm('Você tem certeza?')" type="submit" class=" bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded mb-2">
                                            Excluir
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
          </div>
      </div>
  </div>
</x-app-layout>
