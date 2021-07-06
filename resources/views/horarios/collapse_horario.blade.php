<div class="accordion" id="accordionDia">
    @foreach ($posto->dias as $dia)
        <div class="card">
            <div class="card-header" id="headingOne">
                <h2 class="mb-0 ml-4">
                <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseDia{{ $dia->id }}Ponto{{ $posto->id }}" aria-expanded="true" aria-controls="collapseDia{{ $dia->id }}Ponto{{ $posto->id }}">
                    {{ date('d/m/Y', strtotime($dia->dia )) }}
                </button>
                </h2>
            </div>

            <div id="collapseDia{{ $dia->id }}Ponto{{ $posto->id }}" class="collapse ml-4" aria-labelledby="headingOne" data-parent="#accordionDia">
                <div class="container">
                    <div class="row ml-4">
                        @foreach ($dia->horarios as $horario)
                            @if (!$horario->deleted_at)
                                <div class="col-3 text-success">
                                    {{ date('d/m/Y \à\s  H:i\h', strtotime($horario->horario )) }}
                                </div>
                            @else
                                <div class="col-3 text-danger">
                                    {{ date('d/m/Y \à\s  H:i\h', strtotime($horario->horario )) }}
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
