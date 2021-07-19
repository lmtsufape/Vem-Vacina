<?php

namespace App\Imports;

use Exception;
use Throwable;
use App\Models\Candidato;
use Carbon\Carbon;
use App\Models\Etapa;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

class CandidatoImport implements ToModel, WithHeadingRow //, SkipsOnError
{

    use Importable;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        $controller = new Controller();
        $bodytag = str_replace("/", "-", $row['data_de_nascimento']);
        // $pieces = explode("-", $bodytag);
        // $bodytag = $pieces[2].'-'.$pieces[1].'-'.$pieces[0];
        $row['data_de_nascimento'] = $bodytag;
        // dd(checkdate($pieces[1], $pieces[0], $pieces[2]));

        // if (!checkdate($pieces[1], $pieces[2], $pieces[0])) {
            //     return null;
            // }

        $idade = $this->idade($row['data_de_nascimento']);
        $row['informe_seu_cpf'] = $this->formatar_cpf_cnpj($row['informe_seu_cpf']);
        if ($row['grupo_prioritario'] == 'Idosos de 70 a 74 anos') {
            $etapa = Etapa::find(1); //4
        }elseif ($row['grupo_prioritario'] == 'Idosos de 65 a 69 anos') {
            $etapa = Etapa::find(3); //5

        }else{
            return null;
        }
        $row['cep'] = str_replace("-", "", $row['cep']);
        // dd( $row);
        // if (!$this->validar_telefone($row['telefone_para_contato'])) {
        //     return null;
        // }

        // if (!$this->validar_cpf($row['informe_seu_cpf'])) {
        //     return null;
        // }

        if ($etapa->tipo == Etapa::TIPO_ENUM[0]) {
            if (!($etapa->inicio_intervalo <= $idade && $etapa->fim_intervalo >= $idade)) {
                return null;
            }
        }
        // var_dump($this->idade($row['data_de_nascimento']));
        // if(Candidato::where('cpf', $row['informe_seu_cpf'])->count()){
        //     return null;
        // }
        $candidato = new Candidato([
            'nome_completo' => $row['nome_completo'],
            'data_de_nascimento' =>$row['data_de_nascimento'],
            'cpf' => $row['informe_seu_cpf'] ,
            'numero_cartao_sus' => $row['numero_do_cartao_do_sus'],
            'sexo' => $row['sexo'],
            'idade' => $this->idade($row['data_de_nascimento']),
            'nome_da_mae' => $row['nome_completo_da_mae'],
            'telefone' => $row['telefone_para_contato'],
            'whatsapp' => $row['whatsapp'],
            'email' => $row['e_mail'],
            'cep' => $row['cep'] == "" ? NULL : $row['cep'],
            'cidade' => "Garanhuns",
            'bairro' => $row['bairro'],
            'logradouro' => $row['nome_da_rua'],
            'numero_residencia' => $row['numero_da_casa'],
            'complemento_endereco' => " ",
            'aprovacao' => Candidato::APROVACAO_ENUM[1],
            'dose' => Candidato::DOSE_ENUM[0],
            'etapa_id' => $etapa->id,

        ]);
        return $candidato;
    }

    public function idade($data_nascimento) {
        $hoje = Carbon::today();

        return $hoje->diffInYears($data_nascimento);
    }


    // public function onError(\Throwable $e)
    // {
    //     // Handle the exception how you'd like.
    // }

    protected function validar_telefone($telefone) {
        return preg_match('/^\(\d{2}\)\s?\d{5}-\d{4}$/', $telefone) > 0;
    }

    protected function validar_cpf($cpf)
    {

        // https://gist.github.com/rafael-neri/ab3e58803a08cb4def059fce4e3c0e40

        // Extrai somente os números
        $cpf = preg_replace('/[^0-9]/is', '', $cpf);

        // Verifica se foi informado todos os digitos corretamente
        if (strlen($cpf) != 11) {
            return false;
        }

        // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        // Faz o calculo para validar o CPF
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }
        return true;
    }

    public function formatar_cpf_cnpj($doc) {

        $doc = preg_replace("/[^0-9]/", "", $doc);
        $qtd = strlen($doc);

        if($qtd >= 11) {

            if($qtd === 11 ) {

                $docFormatado = substr($doc, 0, 3) . '.' .
                                substr($doc, 3, 3) . '.' .
                                substr($doc, 6, 3) . '-' .
                                substr($doc, 9, 2);
            } else {
                $docFormatado = substr($doc, 0, 2) . '.' .
                                substr($doc, 2, 3) . '.' .
                                substr($doc, 5, 3) . '/' .
                                substr($doc, 8, 4) . '-' .
                                substr($doc, -2);
            }

            return $docFormatado;

        } else {
            return 'Documento invalido';
        }
    }


}
