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
                        <th scope="col">Numero Lote</th>
                        <th scope="col">fabricante</th>
                        <th scope="col">numero_vacinas</th>
                        <th scope="col">dose_unica</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($candidatos as $candidato)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $candidato->nome_completo }}</td>
                                <td>{{ $candidato->lote->lote->numero_lote ?? "Indefinido" }}</td>
                                {{-- <td>{{ $candidato->lote->fabricante }}</td>
                                <td>{{ $candidato->lote->numero_vacinas }}</td>
                                <td>{{ $candidato->lote->dose_unica }}</td> --}}
                            </tr>
                        @endforeach
                    </tbody>
                  </table>
            </div>
        </div>
    </div>

</x-app-layout>

