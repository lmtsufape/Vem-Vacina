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

    public $candidato;
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
    public function __construct(Candidato $candidato, Lote $lote)
    {
        $this->candidato = $candidato;
        $this->lote = $lote;
        $this->data_chegada =  date('d/m/Y \à\s  H:i\h', strtotime($this->candidato->chegada));
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
        return (new MailMessage)
                            ->from(env('MAIL_USERNAME'), 'Prefeitura Municipal de Garanhuns')
                            ->line("Sr(a). {$this->candidato->nome_completo},")
                            ->line("Informamos que a sua solicitação de agendamento para vacinação foi aprovada pela Secretaria Municipal de Saúde de Garanhuns - PE.")
                            ->line("A seguir, encontram-se o dia, horário e local de aplicação da {$this->candidato->dose} para que registre ou imprima:")
                            ->line("Dia: {$this->data_chegada}.")
                            ->line("Local: {$this->candidato->posto->nome}.")
                            ->line("Endereço: {$this->candidato->posto->endereco}.")
                            ->line("Lembramos que para que seja realizada a aplicação da vacina, o idoso deve apresentar documento de identificação com foto (RG/CPF), cartão do SUS e comprovante de residência.")
                            ->line("Reforçamos a importância de que o idoso esteja de posse de todos os documentos! Eles são necessários para que a vacina possa ser aplicada.")
                            ->line("Agradecemos a sua atenção e ficamos à disposição para outros esclarecimentos que sejam necessários!")
                            ->action('Acessar site', url('/'));
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
            'message' => 'Condidato de ID:'. $this->candidato->id. ' Aprovado'
        ];
    }

}
