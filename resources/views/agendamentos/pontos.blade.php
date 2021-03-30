@extends('agendamentos.index')

@section('content')
    <form method="GET" action="{{route('candidato.pontos')}}">
        <div class="row">
            <div class="col-sm-9">
                <select name="id" class="form-control" id="filtro" onchange="this.form.submit()">
                    <option value=""  selected >-- selecione --</option>
                    @foreach ($postos as $posto)
                        <option value="{{ $posto->id }}" @if($ponto == $posto->id) selected  @endif  >{{ $posto->nome }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </form>
    @include('agendamentos.lista', ['candidatos' => $candidatos,'candidato_enum' => $candidato_enum, 'tipos' => $tipos])

@endsection
