<x-app-layout>
    <x-slot name="header">

        <div class="grid grid-cols-6 gap-4">
            <div class="col-span-5">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">

                    {{ __('Cadastrar Lote') }}
                </h2>
            </div>
            <div class="...">
            </div>
          </div>

    </x-slot>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="container">

                <form action="{{ route('postos.update', ['posto' => $posto->id]) }}" method="post">
                    @csrf
                    @method('put')
                    <div class="row">
                        <div class="col-md-12">
                            <label for="nome">Nome</label>
                            <input id="nome" type="text" class="form-control @error('nome') is-invalid @enderror" name="nome" value="{{ $posto->nome }}">
                            @error('nome')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="data_nacimento">Local</label>
                            <input id="data_nacimento" type="text" class="form-control @error('endereco') is-invalid @enderror" name="endereco" value="{{ $posto->endereco }}" >
                            @error('endereco') <div class="alert alert-danger">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-3">
                            <button class="btn btn-success">Salvar</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
  </x-app-layout>
