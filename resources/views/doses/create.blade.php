<x-app-layout>
    <x-slot name="header">

        <div class="grid grid-cols-6 gap-4">
            <div class="col-span-5">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">

                    {{ __('Cadastrar Dose') }}
                </h2>
            </div>
            <div class="...">


            </div>

        </div>

    </x-slot>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="container">
                {{-- @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif --}}
                <form action="{{ route('doses.registrar') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <label for="nome">Nome da Dose</label>
                            <input id="nome" type="text" class="form-control @error('nome') is-invalid @enderror" name="nome" value="{{ old('nome') }}">
                            @error('nome')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="dose_anterior">Dose Anterior</label>
                            <select class="form-control" id="dose_anterior" name="dose_anterior">
                                <option value="-1">Nenhuma</option>
                                <option value="0">{{\App\Models\Candidato::DOSE_ENUM[4]}}</option>
                                @foreach($doses as $dose)
                                    <option value="{{$dose->id}}">{{$dose->nome}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="intervalo">Intervalo após aplicação da dose (dias)</label>
                            <input id="intervalo" type="number" class="form-control @error('intervalo') is-invalid @enderror" name="intervalo" value="{{ old('intervalo') }}">
                            @error('intervalo')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <div class="input-group" style="margin-top: 32px">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <input type="checkbox" name="exibir_home" aria-label="Checkbox for following text input" @if(old('exibir_home')) checked @endif>
                                    </div>
                                </div>
                                <input type="text" class="form-control" aria-label="Text input with checkbox" value="Exibir na home?">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group" style="margin-top: 32px">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <input type="checkbox" name="desabilitar_cpf" aria-label="Checkbox for following text input" @if(old('desabilitar_cpf')) checked @endif>
                                    </div>
                                </div>
                                <input type="text" class="form-control" aria-label="Text input with checkbox" value="Desabilitar exigência do CPF?">
                            </div>
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
                                            <input type="checkbox" name="etapa_id[]" value="{{ $etapa->id }}" aria-label="Checkbox for following text input">
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
