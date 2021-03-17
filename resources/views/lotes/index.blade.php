<x-app-layout>
    <x-slot name="header">
        <div class="grid grid-cols-6 gap-4">
            <div class="col-span-5">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">

                    {{ __('Lista de Lotes') }}
                </h2>
            </div>
            <div class="...">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Adicionar Lote
                </button>
            </div>

          </div>

    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="container">
              <table class="table">
                  <thead>
                      <tr>
                          <th scope="col">Nome</th>
                          <th scope="col">Nº de vacinas</th>
                          <th scope="col">Ações</th>

                      </tr>
                  </thead>
                  <tbody>
                      @foreach ($lotes as $lote)
                      <tr>
                          <td>{{$lote->nome}}</td>
                          <td>{{$lote->qtdVacina}}</td>
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
