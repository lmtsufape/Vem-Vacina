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
                    <div class="col-2">
                        <a href="{{ route('posto.geradorHorarios', ['id' => $posto->id]) }}">Gerar +1 dia</a>

                    </div>
                </div>

            </div>

            <div id="collapse{{ $posto->id }}" class="collapse @if($posto->id == session('posto_id', false) ) show @endif" aria-labelledby="headingOne" data-parent="#accordionHorario">
                @include('horarios.collapse_horario')
            </div>
        </div>
    @endforeach
</div>
