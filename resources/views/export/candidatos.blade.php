@php
use App\Models\Lote;
use App\Models\LotePostoVacinacao;
@endphp
<table>
    <thead>
    <tr>
        <th>#</th>
        <th>Nome</th>
        <th>data_de_nascimento</th>
        <th>Idade</th>
        <th>cpf</th>
        <th>numero_cartao_sus</th>
        <th>sexo</th>
        <th>nome_da_mae</th>
        <th>observacao</th>
        <th>telefone</th>
        <th>whatsapp</th>
        <th>email</th>
        <th>cidade</th>
        <th>bairro</th>
        <th>logradouro</th>
        <th>numero_residencia</th>
        <th>aprovacao</th>
        <th>dose</th>
        <th>chegada</th>
        <th>saida</th>
        <th>numero_lote</th>
        <th>fabricante</th>
        <th>posto_vacinacao_id</th>
        <th>etapa_id/Texto exibido na home</th>
        <th>campo selecionado</th>
        <th>Informações(acamado)</th>
        <th>criado</th>
        <th>atualizado</th>
        <th>apagado</th>


    </tr>
    </thead>
    <tbody>
    @foreach($candidatos as $candidato)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $candidato->nome_completo }}</td>
            <td>{{ date('d/m/Y', strtotime($candidato->data_de_nascimento)) }}</td>
            <td>{{ $candidato->idade }}</td>
            <td>{{ $candidato->cpf }}</td>
            @php
                $pieces = explode(" ", $candidato->numero_cartao_sus);
            @endphp
            <td>{{ implode(".", $pieces)  }}</td>
            <td>{{ $candidato->sexo }}</td>
            <td>{{ $candidato->nome_da_mae }}</td>
            <td>{{ $candidato->observacao }}</td>
            <td>{{ $candidato->telefone }}</td>
            <td>{{ $candidato->whatsapp }}</td>
            <td>{{ $candidato->email }}</td>
            <td>{{ $candidato->cidade }}</td>
            <td>{{ $candidato->bairro }}</td>
            <td>{{ $candidato->logradouro }}</td>
            <td>{{ $candidato->numero_residencia }}</td>
            <td>{{ $candidato->aprovacao }}</td>
            <td>{{ $candidato->dose }}</td>
            <td>{{ date('d/m/Y', strtotime($candidato->chegada)) }}</td>
            <td>{{ date('d/m/Y', strtotime($candidato->saida)) }}</td>
            @php
                $lote = LotePostoVacinacao::find($candidato->lote_id);
                if($lote != null){
                    $lote = $lote->lote;
                }
            @endphp
            @if ($candidato->lote_id)
                <td>{{  $lote ? $lote->numero_lote : "Erro"  }} </td>
                <td>{{  $lote ? $lote->fabricante : "Erro"  }}</td>
                <td>{{ $candidato->posto->nome ?? "posto" }}</td>
                {{-- @if ($candidato->etapa->tipo == $tipos[0])
                    <td> {{ 'De '.$candidato->etapa->inicio_intervalo." às ".$candidato->etapa->fim_intervalo}}</td>
                @elseif($candidato->etapa->tipo == $tipos[1] || $candidato->etapa->tipo == $tipos[2])
                    <td> {{$candidato->etapa->texto}} </td>
                @endif
                --}}
                @if ($candidato->etapa->tipo == $tipos[0] || $candidato->etapa->tipo == $tipos[1] )
                    <td>{{$candidato->etapa->texto}}</td>
                    <td> </td>
                @elseif($candidato->etapa->tipo == $tipos[2])
                    <td>{{$candidato->etapa->texto}}</td>
                    <td>
                    @if(App\Models\OpcoesEtapa::find($candidato->etapa_resultado) != null)
                        {{App\Models\OpcoesEtapa::find($candidato->etapa_resultado)->opcao}}
                    @endif
                    </td>
                @endif
                <td>
                    @if ($candidato->outrasInfo != null && count($candidato->outrasInfo) > 0)
                        @foreach ($candidato->etapa->outrasInfo as $outraInfo)
                            @if($candidato->outrasInfo->contains('id', $outraInfo->id))
                            {{  $outraInfo->campo . "SIM " }}
                            @endif
                        @endforeach
                    @endif
                </td>
            @else
                <td>{{  "Erro"  }} </td>
                <td>{{  "Erro"  }} </td>
                <td>{{  "Erro"  }} </td>
                <td>{{  "Erro"  }} </td>
                <td>{{  "Erro"  }} </td>
                <td>{{  "Erro"  }} </td>
            @endif
            <td>{{ $candidato->created_at }}</td>
            <td>{{ $candidato->updated_at }}</td>
            <td>{{ $candidato->deleted_at }}</td>

        </tr>
    @endforeach
    </tbody>
</table>
