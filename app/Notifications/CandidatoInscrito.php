<?php

namespace App\Notifications;

use App\Models\Candidato;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class CandidatoInscrito extends Notification
{
    use Queueable;

    public $candidato;
    public $data_chegada;
    public $texto;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Candidato $candidato)
    {
        $this->candidato = $candidato;
        $this->data_chegada =  date('d/m/Y \à\s  H:i \h', strtotime($this->candidato->chegada));
        $this->texto = "Sr(a) cidadão(ã),
        Informamos que a vossa solicitação de agendamento para vacinação foi recebida com sucesso e se encontra em avaliação pela Secretaria Municipal de Saúde de Garanhuns - PE!
        Caso sua solicitação seja aprovada, seu dia, horário e local de aplicação da primeira e segunda dose são os seguintes:
        Dose:".$this->candidato->dose ." - Data: ".$this->data_chegada."
        A confirmação de seu agendamento poderá ser realizada de três formas: a) por meio do próprio site, no campo 'Consultar agendamento'; b) por comunicação feito por e-mail, caso tenha cadastrado; c) por comunicação feita no Whatsapp, caso tenha cadastrado.
        Agradecemos a sua atenção e ficamos à disposição para outros esclarecimentos que sejam necessários!

        Secretaria Municipal de Saúde (Garanhuns - PE)";
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
                    ->line($this->texto)
                    ->action('Acessar site', url('/'))
                    ->line('Obrigador por utilizar nosso site!');
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
            'message' => 'Condidato de ID:'. $this->candidato->id. ' registrado'
        ];
    }
}
