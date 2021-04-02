<?php

namespace App\Notifications;

use App\Models\Lote;
use App\Models\Candidato;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class CandidatoAprovado extends Notification
{
    use Queueable;

    public $candidato1;
    public $candidato2;
    public $data_chegada;
    public $texto;
    public $texto_dose_unica;
    public $texto_dose_dupla;
    public $lote;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Candidato $candidato1, $candidato2,Lote $lote)
    {
        $this->candidato1 = $candidato1;
        $this->candidato2 = $candidato2;
        $this->lote = $lote;
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
        return ['mail', 'database'];
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
                                ->line("Lembramos que para que seja realizada a aplicação da vacina, o idoso deve apresentar documento de identificação com foto (RG/CPF), cartão do SUS e comprovante de residência.")
                                ->line("Reforçamos a importância de que o idoso esteja de posse de todos os documentos! Eles são necessários para que a vacina possa ser aplicada.")
                                ->line("Agradecemos a sua atenção e ficamos à disposição para outros esclarecimentos que sejam necessários!")
                                ->action('Acessar site', url('/'));
        }else{
            return (new MailMessage)
                                ->from(env('MAIL_USERNAME'), 'Prefeitura Municipal de Garanhuns')
                                ->line("Sr(a). {$this->candidato1->nome_completo},")
                                ->line("Informamos que a sua solicitação de agendamento para vacinação foi aprovada pela Secretaria Municipal de Saúde de Garanhuns - PE.")
                                ->line("A seguir, encontram-se o dia, horário e local de aplicação da {$this->candidato1->dose} para que registre ou imprima:")
                                ->line("Dia: {$this->data_chegada1}.")
                                ->line("Local: {$this->candidato1->posto->nome}.")
                                ->line("Endereço: {$this->candidato1->posto->endereco}.")
                                ->line("Lembramos que para que seja realizada a aplicação da vacina, o idoso deve apresentar documento de identificação com foto (RG/CPF), cartão do SUS e comprovante de residência.")
                                ->line("Reforçamos a importância de que o idoso esteja de posse de todos os documentos! Eles são necessários para que a vacina possa ser aplicada.")
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
            'message' => 'Condidato de ID:'. $this->candidato1->cpf. ' Aprovado'
        ];
    }

}
