<x-app-layout>
    <x-slot name="header">

        <div class="grid grid-cols-6 gap-4">
            <div class="col-span-5">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">

                    {{ __('Editar Dose') }}
                </h2>
            </div>
            <div class="...">
            </div>
          </div>

    </x-slot>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="container">

                <form  action="{{route('doses.atualizar', ['id' => $dose->id])}}" method="post">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <label for="nome">Nome da Dose</label>
                            <input id="nome" type="text" class="form-control @error('nome') is-invalid @enderror" name="nome" value="{{ $dose->nome }}">
                            @error('nome')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="dose_anterior">Dose Anterior</label>
                            <select class="form-control" id="dose_anterior" name="dose_anterior">
                                <option value="0" @if($dose->dose_anterior_id == 0) selected @endif>{{\App\Models\Candidato::DOSE_ENUM[4]}}</option>
                                @foreach($doses as $doseTemp)
                                    <option value="{{$doseTemp->id}}" @if($dose->dose_anterior_id == $doseTemp->id) selected @endif>{{$doseTemp->nome}}</option>
                                @endforeach

                            </select>
                        </div>
                    </div>
                    <hr>
                    <div class="row ">
                        <div class="col-md-12">
                            <h5>Selecione a que público(s) se destina essa dose:</h5>
                        </div>
                        <div class="col-md-12 mt-2">
                            @foreach ($etapas as $etapa)

                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <input type="checkbox" name="etapa_id[]" @if($dose->etapas->find($etapa->id)) checked @endif value="{{ $etapa->id }}" aria-label="Checkbox for following text input">
                                        </div>
                                    </div>
                                    <input type="hidden">
                                    <input type="text" class="form-control" aria-label="Text input with checkbox"
                                           @if ($etapa->tipo == $tipos[0])
                                           value="{{ 'De '.$etapa->inicio_intervalo." às ".$etapa->fim_intervalo}}"
                                           @elseif($etapa->tipo == $tipos[1] || $etapa->tipo == $tipos[2])
                                           value="{{$etapa->texto}}"
                                        @endif
                                    >
                                </div>
                            @endforeach
                        </div>
                    </div>
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
