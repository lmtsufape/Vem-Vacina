<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lista de agendamentos') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="container">
                <table class="table table-striped table-dark">
                    <thead>
                      <tr>
                        <th scope="col">Nome</th>
                        <th scope="col">lote</th>
                        <th scope="col">Last</th>
                        <th scope="col">Handle</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($candidatos as $candidato)
                            <tr>
                                <th>{{ $candidato->nome }}</th>
                                <td>{{ $candidato->lote }}</td>
                                <td>Otto</td>
                                <td>@mdo</td>
                            </tr>
                        @endforeach
                    </tbody>
                  </table>
            </div>
        </div>
    </div>

</x-app-layout>

