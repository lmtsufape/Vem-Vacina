<?php

namespace App\Notifications;

use App\Models\Lote;
use App\Models\Candidato;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class CandidatoInscrito extends Notification
{
    use Queueable;

    public $candidato;
    public $candidatoSegundo;
    public $data_chegada;
    public $texto;
    public $texto_dose_unica;
    public $texto_dose_dupla;
    public $lote;
    public $linha_p1;
    public $linha_p2;
    public $linha_p3;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Candidato $candidato,  Lote $lote)
    {
        $this->candidato = $candidato;
        $this->data_chegada =  date('d/m/Y \à\s  H:i \h', strtotime($this->candidato->chegada));
        $this->linha_p1 = "Sr(a). " . $this->candidato->nome_completo.",";
        $this->linha_p2 = "Informamos que a vossa solicitação de agendamento para vacinação foi recebida com sucesso e se encontra em avaliação pela Secretaria Municipal de Saúde de Garanhuns - PE!
        Caso sua solicitação seja aprovada, seu dia, horário e local de aplicação da primeira dose são os seguintes:";
        $this->linha_p3 = "Dose: ".$this->candidato->dose ." - Data: ".$this->data_chegada;
        $this->texto_p1 = "A confirmação de seu agendamento poderá ser realizada de três formas: ";
        $this->texto_p2 = "a) por meio do próprio site, no campo 'Consultar agendamento';";
        $this->texto_p3 = "b) por comunicação feito por e-mail, caso tenha cadastrado;"; 
        $this->texto_p4 = "c) por comunicação feita no Whatsapp, caso tenha cadastrado.";
        $this->texto_p5 = "Agradecemos a sua atenção e ficamos à disposição para outros esclarecimentos que sejam necessários!";
        $this->texto_p6 = "Atenciosamente,";
        $this->texto_p7 = "Secretaria Municipal de Saúde (Garanhuns - PE)";
        $this->lote = $lote;
        $this->texto_dose_unica = "".$this->data_chegada.".";
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
        return (new MailMessage)
            ->from(env('MAIL_USERNAME'), 'Prefeitura Municipal de Garanhuns')
            ->line($this->linha_p1)
            ->line($this->linha_p2)
            ->line($this->linha_p3)
            ->line($this->texto_p1)
            ->line($this->texto_p2)
            ->line($this->texto_p3)
            ->line($this->texto_p4)
            ->line($this->texto_p5)
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
            'message' => 'Condidato de ID:'. $this->candidato->id. ' registrado'
        ];
    }
}
