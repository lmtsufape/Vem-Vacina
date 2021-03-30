@extends('agendamentos.index')

@section('content')

    @include('agendamentos.lista', ['candidatos' => $candidatos,'candidato_enum' => $candidato_enum, 'tipos' => $tipos])

@endsection
