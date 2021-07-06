<div class="accordion" id="accordionHorario">
    @foreach ($postos as $posto)
        <div class="card">
            <div class="card-header" id="headingOne">
                <h2 class="mb-0">
                <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse{{ $posto->id }}" aria-expanded="true" aria-controls="collapse{{ $posto->id }}">
                    {{ $posto->nome }}
                </button>
                </h2>
            </div>

            <div id="collapse{{ $posto->id }}" class="collapse" aria-labelledby="headingOne" data-parent="#accordionHorario">
                @include('horarios.collapse_horario')
            </div>
        </div>
    @endforeach
</div>
