<div>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="container">
                <form  wire:submit.prevent="calcular">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <h4>Nº de vacinas do lote: {{ intdiv ( $lote->qtdVacina , $postos->count() ) . ' vacinas/posto' }}</h4>
                            <h6>Total: {{ $lote->qtdVacina }}</h6>
                            {{-- <input type="text" wire:model="$lote->qtdVacina"> --}}
                            @foreach ($array_vacinas_disponiveis as $key => $item)
                                {{ $key }}
                                {{ $item  }}
                            @endforeach

                        </div>

                    </div>
                    <div class="row">
                        @foreach ($postos as $key => $posto)
                            <div class="col-md-12">
                                <div class="input-group mb-3">
                                    <div class="custom-file">
                                        <input type="number" class="form-control" wire:model="array_vacinas_disponiveis.{{$posto->nome}}" >
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="basic-addon2">{{ $posto->nome }}</span>
                                          </div>
                                    </div>
                                  </div>
                            </div>
                        @endforeach
                    </div>



                    <br>
                    <div class="row">
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-success">Salvar</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
