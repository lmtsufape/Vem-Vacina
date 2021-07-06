<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CandidatoFila extends Notification implements ShouldQueue
{
    use Queueable;

    public $candidato;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($candidato)
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
        if (env('ATIVAR_FILA', false) == true){
            return (new MailMessage)
                ->from(env('MAIL_USERNAME'), 'Prefeitura Municipal de Garanhuns')
                ->line("Sr(a). {$this->candidato->nome_completo},")
                ->line("Informamos que a sua solicitação de agendamento para vacinação está sendo processada. Aguarde a confirmação da Secretaria de Saúde, indicando agendamento com data, local e horário para vacinação.")
                ->line("Lembramos que para que seja realizada a aplicação da vacina, a pessoa deve apresentar documento de identificação com foto (RG/CPF), cartão do SUS e comprovante de residência. Para os agendamentos de pessoas com comorbidades é necessária a apresentação do formulário que atesta a comorbidade, previamente preenchido por um profissional de saúde (exceto pessoas com Síndrome de Down).")
                ->line("Reforçamos a importância de que o idoso esteja de posse de todos os documentos! Eles são necessários para que a vacina possa ser aplicada.")
                ->line("Agradecemos a sua atenção e ficamos à disposição para outros esclarecimentos que sejam necessários!")
                ->action('Acessar site', url('/'));
        }else{
            return (new MailMessage)
                ->from(env('MAIL_USERNAME'), 'Prefeitura Municipal de Garanhuns')
                ->line("Sr(a). {$this->candidato->nome_completo},")
                ->line("Informamos que a sua solicitação de agendamento para vacinação foi para a fila de espera, aguarde o contato da Secretaria Municipal de Saúde de Garanhuns - PE.")
                ->line("Lembramos que para que seja realizada a aplicação da vacina, a pessoa deve apresentar documento de identificação com foto (RG/CPF), cartão do SUS e comprovante de residência. Para os agendamentos de pessoas com comorbidades é necessária a apresentação do formulário que atesta a comorbidade, previamente preenchido por um profissional de saúde (exceto pessoas com Síndrome de Down).")
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
            'message' => 'Condidato/fila de ID:'. $this->candidato->cpf. ' Aprovado'
        ];
    }
}
