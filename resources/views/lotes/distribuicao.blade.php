<x-app-layout>
    <x-slot name="header">
        <div class="grid grid-cols-6 gap-4">
            <div class="col-span-5">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __( 'Lote: '.$lote->numero_lote ) }}
                    {{ __( ' - Fabricante: '.$lote->fabricante ) }}
                </h2>
            </div>
            <div class="...">
            </div>
          </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="container">
                <form action="{{ route('lotes.calcular') }}" method="post">
                    @csrf
                    <input type="hidden" name="lote" value="{{ $lote->id }}">
                    <div class="row">
                        <div class="col-md-12">
                            <h4>Nº de vacinas do lote: {{ intdiv ( $lote->numero_vacinas , $postos->count() ) . ' vacinas/posto' }}</h4>
                            <h6>Total do lote: {{ $lote->numero_vacinas }}</h6>
                        </div>
                    </div>
                    <div class="row">
                        @foreach ($postos as $key => $posto)
                            <div class="col-md-12">
                                <div class="input-group mb-3">
                                    <div class="custom-file">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">{{  $posto->getVacinasDisponivel() ?? "0"}}</span>
                                            <span class="input-group-text">+</span>
                                        </div>

                                        <input type="number" class="form-control" name="posto[{{ $posto->id }}]" value="" >
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="basic-addon2">{{  $posto->nome }}</span>
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


</x-app-layout>
