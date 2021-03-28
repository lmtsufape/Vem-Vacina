<?php

namespace App\Notifications;

use App\Models\Lote;
use App\Models\Candidato;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class CandidatoInscritoSegundaDose extends Notification
{
    use Queueable;

    public $candidato;
    public $data_chegada;
    public $texto;
    public $texto_dose_unica;
    public $texto_dose_dupla;
    public $lote;
    public $segundo;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Candidato $candidato,  Lote $lote)
    {
        $this->candidato = $candidato;

        $this->lote = $lote;
        $this->data_chegada =  date('d/m/Y \à\s  H:i \h', strtotime($this->candidato->chegada));
        $this->segundo = "Segunda dose:".$this->data_chegada.".";
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
                            ->line("Sr(a) cidadão(ã),")
                            ->line("Informamos que a sua slicitação de agendamento para vacinação foi recebida com sucesso, e se encontra em avaliação pela Secretaria Municipal de Saúde de Garanhuns-PE.
                                    Caso a solicitação seja aprovada, o dia, horário e local de aplicação da segunda dose é o seguinte:")
                            ->line($this->segundo)
                            ->line("A confirmação de seu agendamento poderá ser realizada de três formas: a) por meio do próprio site, no campo 'Consultar agendamento'; b) por comunicação feita por e-mail, caso tenha cadastrado; c) por comunicação feita no Whatsapp, caso tenha cadastrado.")
                            ->line("Agradecemos a sua atenção e ficamos à disposição para outros esclarecimentos!
                            Secretaria Municipal de Saúde (Garanhuns-PE)
                            Informamos que a sua solicitação de agendamento para vacinação foi aprovada pela Secretaria Municipal de Saúde de Garanhuns - PE.
                            A seguir, encontram-se o dia, horário e local de aplicação da primeira e segunda dose para que registre ou imprima.")
                            ->line("Agradecemos a sua atenção e ficamos à disposição para outros esclarecimentos que sejam necessários!
                            Secretaria Municipal de Saúde (Garanhuns - PE)")
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
