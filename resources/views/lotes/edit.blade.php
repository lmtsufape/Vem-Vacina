<x-app-layout>
    <x-slot name="header">

        <div class="grid grid-cols-6 gap-4">
            <div class="col-span-5">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">

                    {{ __('Editar Lote') }}
                </h2>
            </div>
            <div class="...">
            </div>
          </div>

    </x-slot>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="container">

                <form action="{{ route('lotes.update', ['lote' => $lote->id]) }}" method="post">
                    @csrf
                    @method("PUT")
                    <div class="row">
                        <div class="col-md-12">
                            <label for="nome">Código do lote</label>
                            <input id="nome" type="text" class="form-control @error('numero_lote') is-invalid @enderror" name="numero_lote" value="{{ $lote->numero_lote }}">
                            @error('numero_lote')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="data_nacimento">Fabricante</label>
                            <input id="data_nacimento" type="text" class="form-control @error('fabricante') is-invalid @enderror" name="fabricante" value="{{ $lote->fabricante }}" >
                            @error('fabricante') <div class="alert alert-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="numero_vacinas">Nº de vacinas</label>
                            <input id="numero_vacinas" min="0" type="number" class="form-control @error('numero_vacinas') is-invalid @enderror" name="numero_vacinas"  value="{{ $lote->numero_vacinas }}">
                            @error('numero_vacinas') <div class="alert alert-danger">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="inicio_periodo">Inicio do periodo <i class="fas fa-exclamation-circle" data-toggle="tooltip" data-placement="top" title="Quantidade dever em dias."></i></label>
                            <input id="inicio_periodo" type="number" class="form-control @error('inicio_periodo') is-invalid @enderror" name="inicio_periodo" value="{{ $lote->inicio_periodo }}">
                            @error('inicio_periodo') <div class="alert alert-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="fim_periodo">Fim do periodo <i class="fas fa-exclamation-circle" data-toggle="tooltip" data-placement="top" title="Quantidade dever em dias."></i></label>
                            <input id="fim_periodo" type="number" class="form-control @error('fim_periodo') is-invalid @enderror" name="fim_periodo" value="{{ $lote->fim_periodo }}" >
                            @error('fim_periodo') <div class="alert alert-danger">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="data_fabricacao">Fabricação</label>
                            <input id="data_fabricacao" type="date" class="form-control @error('data_fabricacao') is-invalid @enderror" name="data_fabricacao" value="{{ $lote->data_fabricacao }}">
                            @error('data_fabricacao') <div class="alert alert-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="data_validade">Validade</label>
                            <input id="data_validade" type="date" class="form-control @error('data_validade') is-invalid @enderror" name="data_validade" value="{{ $lote->data_validade }}" >
                            @error('data_validade') <div class="alert alert-danger">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <hr>
                    <div class="row ">
                        <div class="col-md-12">
                            <h5>Selecione a que público(s) se destina esse lote:</h5>
                        </div>
                        <div class="col-md-12 mt-2">
                            @foreach ($etapas as $etapa)
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                        <input type="checkbox" name="etapa_id[]" @if($lote->etapas()->find($etapa->id)) checked @endif value="{{ $etapa->id }}" aria-label="Checkbox for following text input">
                                        </div>
                                    </div>
                                    <input type="hidden" >
                                    <input type="text" class="form-control"  aria-label="Text input with checkbox"
                                        {{-- @if ($etapa->tipo == $tipos[0])
                                            placeholder="{{ 'De '.$etapa->inicio_intervalo." às ".$etapa->fim_intervalo}}"
                                        @elseif($etapa->tipo == $tipos[1] || $etapa->tipo == $tipos[2])
                                            placeholder="{{$etapa->texto}}"
                                        @endif --}}
                                        placeholder="{{$etapa->texto}}"
                                        >
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mt-2">
                            <div class="input-group mt-2">
                                <div class="input-group-prepend">
                                  <div class="input-group-text">
                                    <label for="doseUnica " class="mr-2 mt-2">É dose única?</label>
                                    <input id="doseUnica" class="mb-2 mt-2" type="checkbox" name="dose_unica" @if($lote->dose_unica) checked @endif value="true" aria-label="Checkbox for following text input">
                                  </div>
                                </div>
                            </div>
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
