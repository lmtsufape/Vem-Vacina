<div class="accordion" id="accordionDia">
    @if ($posto->dias != null)
        @foreach ($posto->dias->sortBy('dia') as $dia)
            <div class="card">
                <div class="card-header" id="headingOne">
                    <div class="row">
                        <div class="col-2">
                            <div class="mb-0">
                                <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseDia{{ $dia->id }}Ponto{{ $posto->id }}" aria-expanded="true" aria-controls="collapseDia{{ $dia->id }}Ponto{{ $posto->id }}">
                                    {{ date('d/m/Y', strtotime($dia->dia )) }}
                                </button>
                            </div>
                        </div>
                        <div class="col-2">
                            {{ $dia->horarios->count() }}
                        </div>
                        <div class="col-2">
                            <a
                            href="{{ route('horarios.delete', ['posto_id' => $posto->id, 'dia_id'=>$dia->id]) }}" class="text-danger">
                                Apagar
                            </a>
                        </div>
                    </div>
                </div>

                <div id="collapseDia{{ $dia->id }}Ponto{{ $posto->id }}" class="collapse ml-4" aria-labelledby="headingOne" data-parent="#accordionDia">
                    <div class="container">
                        <div class="row ml-4">
                            @foreach ($dia->horarios()->orderBy('horario')->withTrashed()->get() as $horario)
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
    @else
        {{ "Sem horários" }}
    @endif
    
</div>
