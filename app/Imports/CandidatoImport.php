<?php

namespace App\Imports;

use App\Candidato;
use App\Models\Etapa;
use Maatwebsite\Excel\Concerns\ToModel;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Throwable;

class CandidatoImport implements ToModel, SkipsOnError, WithHeadingRow
{

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {



        $idade = $this->idade($row['Data de nascimento']);

        if ($row[1] == 'Idosos de 70 a 74 anos') {
            $etapa = Etapa::find(4);
        }elseif ($row[1] == 'Idosos de 65 a 69 anos') {
            $etapa = Etapa::find(5);;
        }

        if (!$this->validar_telefone($row[8])) {
            throw new Exception('error');
        }

        if (!$this->validar_cpf($row[4])) {
            throw new Exception('error');
        }

        if ($etapa->tipo == Etapa::TIPO_ENUM[0]) {
            if (!($etapa->inicio_intervalo <= $idade && $etapa->fim_intervalo >= $idade)) {
                throw new Exception('error');
            }
        }

        $candidato = new Candidato([
            'nome_completo' => $row['Nome completo'],
            'data_de_nascimento' =>$row['Data de nascimento'],
            'cpf' => $row['Informe seu CPF'],
            'numero_cartao_sus' => $row['Número do cartão do SUS'],
            'sexo' => $row['Sexo'],
            'idade' => $idade,
            'nome_da_mae' => $row['Nome completo da mãe'],
            'telefone' => $row['Telefone para contato'],
            'whatsapp' => $row['WhatsApp'],
            'email' => $row['E-mail'],
            'cep' => $row['CEP'] == "" ? NULL : $row['CEP'],
            'cidade' => "Garanhuns",
            'bairro' => $row['Bairro'],
            'logradouro' => $row['Nome da rua'],
            'numero_residencia' => $row['Número da casa'],
            'complemento_endereco' => " ",
            'aprovacao' => Candidato::APROVACAO_ENUM[1],
            'dose' => Candidato::DOSE_ENUM[0],
            'etapa_id' => $etapa->id,

        ]);
        if (  $row['O idoso é acamado?'] == 'Sim' ) {
            $candidato->outrasInfo()->attach(1);
        }
        return $candidato;
    }

    public function idade($data_nascimento) {
        $hoje = Carbon::today();

        return $hoje->diffInYears($data_nascimento);
    }

    public function onError(Throwable $e)
    {

    }


}
