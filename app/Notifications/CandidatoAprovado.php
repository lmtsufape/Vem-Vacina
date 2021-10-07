<?php

namespace App\Notifications;

use App\Models\Lote;
use App\Models\Candidato;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class CandidatoAprovado extends Notification implements ShouldQueue
{
    use Queueable;

    public $candidato1;
    public $candidato2;
    public $data_chegada;
    public $data_chegada1;
    public $data_chegada2;
    public $texto;
    public $texto_dose_unica;
    public $texto_dose_dupla;
    public $lote;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Candidato $candidato1, $candidato2)
    {
        $this->candidato1 = $candidato1;
        $this->candidato2 = $candidato2;
        $this->data_chegada1 =  date('d/m/Y \à\s  H:i\h', strtotime($this->candidato1->chegada));
        if ($this->candidato2) {
            $this->data_chegada2 =  date('d/m/Y \à\s  H:i\h', strtotime($this->candidato2->chegada));
        }
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        if ($this->candidato2) {
            return (new MailMessage)
                                ->from(env('MAIL_USERNAME'), 'Prefeitura Municipal de Garanhuns')
                                ->line("Sr(a). {$this->candidato1->nome_completo},")
                                ->line("Informamos que a sua solicitação de agendamento para vacinação foi aprovada pela Secretaria Municipal de Saúde de Garanhuns - PE.")
                                ->line("A seguir, encontram-se o dia, horário e local de aplicação da {$this->candidato1->dose} e da {$this->candidato2->dose} para que registre ou imprima:")
                                ->line("{$this->candidato1->dose}:")
                                ->line("Dia: {$this->data_chegada1}.")
                                ->line("Local: {$this->candidato1->posto->nome}.")
                                ->line("Endereço: {$this->candidato1->posto->endereco}.")
                                ->line("{$this->candidato2->dose}:")
                                ->line("Dia: {$this->data_chegada2}.")
                                ->line("Local: {$this->candidato2->posto->nome}.")
                                ->line("Endereço: {$this->candidato2->posto->endereco}.")
                                ->line("Lembramos que para que seja realizada a aplicação da vacina, a pessoa deve apresentar documento de identificação com foto (RG/CPF), cartão do SUS e comprovante de residência constando o nome da pessoa a ser vacinada. . Na dose de reforço também será exigido o cartão de vacina constando a segunda dose ou dose única. Trabalhadores da saúde devem apresentar declaração de vínculo da instituição onde atuam em Garanhuns.")
                                ->line("Para os agendamentos de comorbidades é necessário o formulário que atesta a comorbidade, previamente preenchido por um profissional de saúde. Os imunossuprimidos devem apresentar laudo médico ou receita de medicamento imunossupressor. ")
                                ->line("Para vacinação de pessoas com menos de 18 anos é indispensável a presença do pai ou responsável legal (a condição de tutela deverá ser comprovada através de documento emitido em cartório), munidos de documento de identificação. A criança/adolescente deve estar com documento de identificação com foto ou certidão de nascimento, CPF, cartão do SUS e comprovante de residência constando o nome do pai ou responsável legal. ")
                                ->line("Reforçamos a importância de que a pessoa esteja de posse de todos os documentos! Eles são necessários para que a vacina possa ser aplicada. Agradecemos a sua atenção e ficamos à disposição para outros esclarecimentos que sejam necessários!")
                                ->line("Agradecemos a sua atenção e ficamos à disposição para outros esclarecimentos que sejam necessários!")
                                ->action('Acessar site', url('/'));
        }else{
            return (new MailMessage)
                                ->from(env('MAIL_USERNAME'), 'Prefeitura Municipal de Garanhuns')
                                ->line("Sr(a). {$this->candidato1->nome_completo},")
                                ->line("Informamos que a sua solicitação de agendamento para vacinação foi aprovada pela Secretaria Municipal de Saúde de Garanhuns - PE.")
                                ->line("A seguir, encontram-se o dia, horário e local de aplicação da sua dose para que registre ou imprima:")
                                ->line("Dia: {$this->data_chegada1}.")
                                ->line("Local: {$this->candidato1->posto->nome}.")
                                ->line("Endereço: {$this->candidato1->posto->endereco}.")
                                ->line("Lembramos que para que seja realizada a aplicação da vacina, a pessoa deve apresentar documento de identificação com foto (RG/CPF), cartão do SUS e comprovante de residência constando o nome da pessoa a ser vacinada. . Na dose de reforço também será exigido o cartão de vacina constando a segunda dose ou dose única. Trabalhadores da saúde devem apresentar declaração de vínculo da instituição onde atuam em Garanhuns.")
                                ->line("Para os agendamentos de comorbidades é necessário o formulário que atesta a comorbidade, previamente preenchido por um profissional de saúde. Os imunossuprimidos devem apresentar laudo médico ou receita de medicamento imunossupressor.")
                                ->line("Para vacinação de pessoas com menos de 18 anos é indispensável a presença do pai ou responsável legal (a condição de tutela deverá ser comprovada através de documento emitido em cartório), munidos de documento de identificação. A criança/adolescente deve estar com documento de identificação com foto ou certidão de nascimento, CPF, cartão do SUS e comprovante de residência constando o nome do pai ou responsável legal.")
                                ->line("Reforçamos a importância de que a pessoa esteja de posse de todos os documentos! Eles são necessários para que a vacina possa ser aplicada. Agradecemos a sua atenção e ficamos à disposição para outros esclarecimentos que sejam necessários!")
                                ->line("Agradecemos a sua atenção e ficamos à disposição para outros esclarecimentos que sejam necessários!")
                                ->action('Acessar site', url('/'));

        }
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [

        ];
    }

}
