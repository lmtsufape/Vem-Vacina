<x-app-layout>
    <x-slot name="header">

        <div class="grid grid-cols-6 gap-4">
            <div class="col-span-5">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">

                    {{ __('Editar Ponto de Vacinação') }}
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
                            <h4>Informações necessárias</h4>
                        </div>
                    </div>
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
                        <div class="col-md-12">
                            <input id="padrao_no_formulario" type="checkbox" name="padrao_no_formulario" @if(old('padrao_no_formulario') || old('padrao_no_formulario') == null && $posto->padrao_no_formulario) checked @endif>
                            <label for="padrao_no_formulario">Exibir por padrão no formulário</label>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <h4>Quais públicos são permitidos nesse ponto?</h4>
                        </div>
                    </div>
                    <div class="row">
                        @foreach ($publicos as $publico)
                            <div class="col-md-6">
                                <input id="publico_{{$publico->id}}" type="checkbox" value="{{$publico->id}}" name="publicos[]" @if(old('publicos') != null && in_array($publico->id, old('publicos'))) @elseif(old('publicos') == null && $publicosDoPosto->contains('etapa_id', $publico->id)) checked @endif>
                                @if($publico->tipo == $tipos[0])
                                    <label for="publico_{{$publico->id}}">De {{$publico->inicio_intervalo}} à {{$publico->fim_intervalo}} anos</label>
                                @elseif($publico->tipo == $tipos[1] || $publico->tipo == $tipos[2])
                                    <label for="publico_{{$publico->id}}">{{$publico->texto}}</label>
                                @endif
                            </div>
                        @endforeach
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
