<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="container">

            {{-- <livewire:contador/> --}}

            {{-- <div wire:poll="counter">
                <h1>{{ $count }}</h1>

            </div> --}}
            <br>
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
                        @error('ponto_id')<div class="alert alert-danger">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="numero_vacinas">Etapas</label>
                        <select wire:model="etapa_id" class="custom-select" id="inputGroupSelect01">
                            <option selected>Selecione...</option>
                            @foreach ($etapas as $key => $etapa)
                            <tr>
                                <option  value="{{ $etapa->id }}" wire:key="{{ $key }}" >{{$etapa->texto}}</option>
                            </tr>
                            @endforeach
                        </select>
                        @error('etapa_id')<div class="alert alert-danger">{{ $message }}</div> @enderror
                    </div>


                </div>
                <br>
                <div class="row">
                    <div class="col-md-6">
                        <label for="qtdFila">Quantidade de pessoas da fila para aprovar:</label><br>
                        <input wire:model="qtdFila" type="number">
                        @error('qtdFila')<div class="alert alert-danger">{{ $message }}</div> @enderror
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-6">
                        <label for="cpf">CPF:</label><br>
                        <input wire:model="cpf" type="text">
                        {{-- @error('cpf')<div class="alert alert-danger">{{ $message }}</div> @enderror --}}
                    </div>
                </div>
                <br>
                <div wire:loading.delay>
                    <p>Processando distribuição...</p>

                </div>

                <br>
                <div class="row" wire:loading.remove.delay>
                    <div class="col-md-3">
                        <button class="btn btn-success">Distribuir</button>
                    </div>
                </div>
            </form>
            <hr>
            <div class="accordion" id="accordionHorario">
                @foreach ($postos as $posto)
                    <div class="card">
                        <div class="card-header" id="headingOne">
                            <div class="row">
                                <div class="col-10">
                                    <div class="mb-0">
                                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse{{ $posto->id }}" aria-expanded="true" aria-controls="collapse{{ $posto->id }}">
                                            {{ $posto->nome }}
                                        </button>
                                    </div>
                                </div>

                            </div>

                        </div>

                        <div id="collapse{{ $posto->id }}" class="collapse" aria-labelledby="headingOne" data-parent="#accordionHorario">
                            <div class="row ml-4">
                                @foreach ($posto->dias as $dia)
                                    <div class="col-6">
                                        {{ date('d/m/Y ', strtotime($dia->dia )) }}
                                        {{ " - Nº:".$dia->horarios->count() }}
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
</div>
