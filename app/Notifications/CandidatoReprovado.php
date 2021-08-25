<?php

namespace App\Notifications;

use App\Models\Lote;
use App\Models\Candidato;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class CandidatoReprovado extends Notification implements ShouldQueue
{
    use Queueable;

    public $candidato;
    public $email;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Candidato $candidato, $email)
    {
        $this->candidato = $candidato;
        $this->email = $email;

    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
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
                    ->line("{$this->candidato->nome_completo},")
                    ->line("Informamos que a vossa solicitação de agendamento para vacinação não foi aprovada pela Secretaria Municipal de Saúde de Garanhuns - PE!")
                    ->line("O pedido possuía algum tipo de inconsistência, que pode ter ocorrido por diversas razões: desde a divergência entre a data de nascimento e faixa etária sendo vacinada, ou erros de digitação. Caso o erro tenha sido de digitação de algum número ou por falta de comparecimento ao local de vacinação no dia agendado, pedimos que refaça a solicitação de agendamento.")
                    ->line("Agradecemos a sua atenção e ficamos à disposição para outros esclarecimentos que sejam necessários!
                    Secretaria Municipal de Saúde (Garanhuns - PE).")
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
        $user = Auth::user();
        if($user == null){
            $user = "Erro";
        }else{
           $user = Auth::user()->email;
        }
        return [
            'message' => 'Condidato de CPF:'. $this->candidato->cpf. ' reprovado ou ausente por:' . $this->email
        ];
    }
}
