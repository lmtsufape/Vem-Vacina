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
                            @if($postos->count())
                                <h4>Nº de vacinas do lote: {{ $lote->numero_vacinas }}</h4>
                                @php
                                    $sobras = $lote->numero_vacinas % $postos->count();
                                @endphp

                            @else
                                <p>Cadastre um Ponto de Vacinação</p>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                        {{-- @dd($errors->__get('default')->toArray()[]) --}}
                        @forelse ($postos as $key => $posto)
                            @php
                                $sobras -= 1;
                            @endphp
                            <div class="col-md-12">
                                <div class="input-group mb-3">
                                    <div class="custom-file">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">{{ $posto->getVacinasDisponivel($lote->id, $posto->id ) ? $posto->getVacinasDisponivel($lote->id, $posto->id) : 0 }}</span>
                                            <span class="input-group-text">+</span>
                                        </div>
                                        <div class="input-group-prepend">
                                            @php
                                                $lote_pivot = $lotes_pivot->where('lote_id', $lote->id)->where('posto_vacinacao_id', $posto->id)->first();
                                                $qtdCandidato = $candidatos->where('posto_vacinacao_id', $posto->id)->where('lote_id', $lote_pivot->id)->count();
                                            @endphp
                                            <span class="input-group-text">{{ $lote_pivot->qtdVacina - $qtdCandidato }}</span>
                                            <span class="input-group-text">+</span>
                                        </div>
                                        @if($sobras >= 0)
                                            <input type="number" class="form-control " min="0" name="posto[{{ $posto->id }}]" value="{{ intdiv ( $lote->numero_vacinas , $postos->count()) + 1 }}" >
                                        @else
                                            <input type="number" class="form-control " min="0" name="posto[{{ $posto->id }}]" value="{{ intdiv ( $lote->numero_vacinas , $postos->count()) }}" >
                                        @endif
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="basic-addon2">{{  $posto->nome }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @empty

                        @endforelse

                    </div>



                    <br>
                    <div class="row justify-content-md-center">
                        <div class="col-md-2">
                            <a href="{{ route('lotes.index') }}" class="btn btn-danger btn-lg">Voltar</a>
                        </div>
                        @if($postos->count())
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-success btn-lg">Salvar</button>
                            </div>
                        @endif
                    </div>
                </form>

            </div>
        </div>
    </div>


</x-app-layout>
