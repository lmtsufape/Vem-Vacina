<div class="py-12">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="container">
            <div>
                @if (session()->has('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                @endif
            </div>
            <form wire:submit.prevent="distribuir">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <label for="data_nacimento">Pontos</label>
                        <select wire:model="ponto_id" class="custom-select" id="inputGroupSelect01">
                            <option selected>Selecione...</option>
                            @foreach ($pontos as $key => $ponto)
                                <option  value="{{ $ponto->id }}" wire:key="{{ $key }}">{{ $ponto->nome }}</option>
                            @endforeach
                        </select>
                        @error('fabricante') <div class="alert alert-danger">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="numero_vacinas">Etapas</label>
                        <select wire:model="etapa_id" class="custom-select" id="inputGroupSelect01">
                            <option selected>Selecione...</option>
                            @foreach ($etapas as $key => $etapa)
                            <tr>
                                @if ($etapa->tipo == $tipos[0])
                                    <option  value="{{ $etapa->id }}" wire:key="{{ $key }}" >{{ 'De '.$etapa->inicio_intervalo." às ".$etapa->fim_intervalo}}</option>
                                @elseif($etapa->tipo == $tipos[1] || $etapa->tipo == $tipos[2])
                                    <option value="{{ $etapa->id }}" >{{$etapa->texto}}</option>
                                @endif
                            </tr>
                            @endforeach
                        </select>
                        @error('numero_vacinas') <div class="alert alert-danger">{{ $message }}</div> @enderror
                    </div>
                </div>
                <br>
                <div wire:loading.delay>
                    <p>Processando distribuição...</p>

                </div>
                <div wire:poll.60000ms>
                    Current time: {{ $qtdFila }}
                </div>


                <br>
                <div class="row" wire:loading.remove.delay>
                    <div class="col-md-3">
                        <button class="btn btn-success">Distribuir</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
