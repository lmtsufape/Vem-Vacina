<?php

namespace App\Notifications;

use App\Models\Candidato;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CandidatoReprovado extends Notification
{
    use Queueable;

    public $candidato;
    public $texto = "Sr(a) cidadão(ã),
    Informamos que a vossa solicitação de agendamento para vacinação não foi aprovada pela Secretaria Municipal de Saúde de Garanhuns - PE!
    O pedido possuía algum tipo de inconsistência, que pode ter ocorrido por diversas razões: desde a divergência entre a data de nascimento e faixa etária sendo vacinada, ou erros de digitação. Caso o erro tenha sido de digitação de algum número, por exemplo, pedimos que refaça a solicitação de agendamento.
    Agradecemos a sua atenção e ficamos à disposição para outros esclarecimentos que sejam necessários!
    Secretaria Municipal de Saúde (Garanhuns - PE)";
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Candidato $candidato)
    {
        $this->candidato = $candidato;
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
            'message' => 'Condidato de CPF:'. $this->candidato->cpf. ' Reprovado'
        ];
    }
}
