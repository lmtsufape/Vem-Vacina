<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
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

        </div>
    </div>
</div>
