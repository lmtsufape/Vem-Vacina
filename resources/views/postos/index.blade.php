<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('Lista de postos') }}
      </h2>
  </x-slot>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="container">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Nome</th>
                        <th scope="col">Endereço</th>
                        <th scope="col">Ações</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($postos as $posto)
                    <tr>
                        <td>{{$posto->nome}}</td>
                        <td>{{$posto->endereco}}</td>
                        <td>
                            <form action="">
                                @csrf
                                <div class="row">
                                    <div class="col-md-3">
                                        <button class="btn btn-success">Lotes</button>
                                    </div>
                                </div>
                            </form>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
          </div>
      </div>
  </div>
</x-app-layout>
