@php
use App\Models\Lote;
use App\Models\LotePostoVacinacao;
@endphp
<table>
    <thead>
    <tr>
        <th>Grupo Prioritário</th>
        <th>Local de Trabalho</th>
        <th>Função</th>
        <th>CPF do Vacinado</th>
        <th>CNS do Vacinado</th>
        <th>Nome do Vacinado</th>
        <th>Data de Nacimento</th>
        <th>Sexo</th>
        <th>Nome da Mãe</th>
        <th>Data de Vacinação</th>
        <th>Nome da Vacina</th>
        <th>Dose</th>
        <th>Lote</th>
        <th>Produtor</th>
        <th>Nome da vacinador (a)</th>
        <th>Digitado por</th>
        <th>Idade</th>
        <th>Enderenço</th>
        {{-- <th>Digitado por</th>
        <th>dose</th>
        <th>chegada</th>
        <th>saida</th>
        <th>numero_lote</th>
        <th>fabricante</th>
        <th>campo selecionado</th>
        <th>Informações(acamado)</th>
        <th>criado</th>
        <th>atualizado</th>
        <th>apagado</th> --}}


    </tr>
    </thead>
    <tbody>
    @foreach($candidatos as $candidato)
        <tr>
            {{-- <td>{{ $loop->iteration }}</td> --}}
            @php
                $lote = LotePostoVacinacao::find($candidato->lote_id);
                if($lote != null){
                    $lote = $lote->lote;
                }
            @endphp
            @if ($candidato->lote_id)
                
                
                @if ($candidato->etapa->tipo == $tipos[0] || $candidato->etapa->tipo == $tipos[1] )
                    <td>{{$candidato->etapa->texto}}</td>
                    <td>{{ $candidato->posto->nome ?? "posto" }}</td>
                    <td>{{ $candidato->observacao }}</td>
                    {{-- <td> {{$candidato->etapa->texto}}</td> --}}
                @elseif($candidato->etapa->tipo == $tipos[2])
                    <td>{{$candidato->etapa->texto}}</td>
                    <td>{{ $candidato->posto->nome ?? "posto" }}</td>
                    <td>{{ $candidato->observacao }}</td>
                    {{-- <td>
                    @if(App\Models\OpcoesEtapa::find($candidato->etapa_resultado) != null)
                        {{App\Models\OpcoesEtapa::find($candidato->etapa_resultado)->opcao}}
                    @else
                        {{$candidato->etapa->texto}}
                    @endif
                    </td> --}}
                @endif
                <td>{{ $candidato->cpf }}</td>
                @php
                    $sus = explode(" ", $candidato->numero_cartao_sus);
                @endphp
                <td>{{ implode(".", $sus)  }}</td>
                <td>{{ $candidato->nome_completo }}</td>
                <td>{{ date('d/m/Y', strtotime($candidato->data_de_nascimento)) }}</td>
                <td>{{ $candidato->sexo }}</td>
                <td>{{ $candidato->nome_da_mae }}</td>
                <td>{{ date('d/m/Y \à\s H:i\h', strtotime($candidato->chegada)) }}</td>
                <td>{{  $lote ? $lote->fabricante : "Erro"  }}</td>
                <td>{{ $candidato->dose }}</td>
                <td>{{  $lote ? $lote->numero_lote : "Erro"  }} </td>
                <td>{{  $lote ? $lote->fabricante : "Erro"  }}</td>
                <td>{{  "Nome do vacinador"  }}</td>
                <td>{{  "Digitado por"  }}</td>
                <td>{{ $candidato->idade }}</td>
                <td>{{ $candidato->logradouro . ' - ' . $candidato->numero_residencia . ' - ' . $candidato->bairro . ' - ' . $candidato->cidade }}</td>
                {{-- <td>{{ $candidato->bairro }}</td>
                <td>{{ $candidato->logradouro }}</td>
                <td>{{ $candidato->numero_residencia }}</td> --}}
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

            {{-- <td>{{ $candidato->telefone }}</td>
            <td>{{ $candidato->whatsapp }}</td>
            <td>{{ $candidato->email }}</td>
            <td>{{ $candidato->cidade }}</td>
            <td>{{ $candidato->bairro }}</td>
            <td>{{ $candidato->logradouro }}</td>
            <td>{{ $candidato->numero_residencia }}</td>
            <td>{{ $candidato->aprovacao }}</td>
            <td>{{ date('d/m/Y', strtotime($candidato->chegada)) }}</td>
            <td>{{ date('d/m/Y', strtotime($candidato->saida)) }}</td>
            
            <td>{{ $candidato->created_at }}</td>
            <td>{{ $candidato->updated_at }}</td>
            <td>{{ $candidato->deleted_at }}</td> --}}

        </tr>
    @endforeach
    </tbody>
</table>
