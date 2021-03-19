<x-app-layout>
    <x-slot name="header">

        <div class="grid grid-cols-6 gap-4">
            <div class="col-span-5">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">

                    {{ __('Lista de Lotes') }}
                </h2>
            </div>
            <div class="...">
                <a href="{{ route('lotes.create') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    Adicionar Lote
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
                          <th scope="col">Nº do lote</th>
                          <th scope="col">Fabricante</th>
                          <th scope="col">Nº de vacinas</th>
                          <th scope="col">Segunda dose</th>
                          <th scope="col">Fabricação</th>
                          <th scope="col">Validade</th>
                          <th scope="col">Ações</th>

                      </tr>
                  </thead>
                  <tbody>
                      @foreach ($lotes as $lote)
                      <tr>
                          <td>{{$lote->numero_lote}}</td>
                          <td>{{$lote->fabricante}}</td>
                          <td>{{$lote->numero_vacinas}}</td>
                          <td>{{$lote->segunda_dose ? 'Sim' : 'Não'}}</td>
                          <td>{{ date('d/m/Y', strtotime($lote->data_fabricacao))  }}</td>
                          <td>{{ date('d/m/Y', strtotime($lote->data_validade))}}</td>
                          <td>
                              <div class="row">
                                  <div class="col-md-3">
                                    <form action="{{ route('lotes.edit', ['lote' => $lote->id]) }}" method="get">
                                        @csrf
                                        @method('put')
                                        <button type="submit" class=" bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                            Editar
                                        </button>
                                    </form>
                                  </div>
                                  <div class="col-md-3">
                                      <form action="{{ route('lotes.destroy', ['lote' => $lote->id]) }}" method="post">
                                          @csrf
                                          @method('delete')
                                          <button type="submit" onclick="return confirm('Você tem certeza?')" class=" bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded ">
                                              Excluir
                                          </button>
                                      </form>
                                  </div>
                                  <div class="col-md-3 ">
                                    <form action="{{ route('lotes.distribuir', ['lote' => $lote->id]) }}" method="post">
                                        @csrf
                                        <button type="submit" @if($lote->numero_vacinas == 0) disabled @endif class="disabled:opacity-50 bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                                            Distribuir
                                        </button>
                                    </form>
                                </div>
                              </div>
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
