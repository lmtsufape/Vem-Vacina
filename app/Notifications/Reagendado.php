<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Candidato;
use App\Models\Lote;

class Reagendado extends Notification
{
    use Queueable;

    public $priDose;
    public $segDose;
    public $lote;
    public $data_chegada_pri_dose;
    public $data_chegada_seg_dose;

    /**
     * Create a new notification instance.
     *
     * @return void
     */

    public function __construct(Candidato $priDose, Candidato $segDose)
    {
        $this->priDose = $priDose;
        $this->segDose = $segDose;
        $this->data_chegada_pri_dose =  date('d/m/Y \à\s  H:i\h', strtotime($this->priDose->chegada));
        $this->data_chegada_seg_dose =  date('d/m/Y \à\s  H:i\h', strtotime($this->segDose->chegada));
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
                ->line("Sr(a). {$this->priDose->nome_completo},")
                ->line("Informamos que as suas datas de vacinação foram reagendadas pela Secretaria Municipal de Saúde de Garanhuns - PE.")
                ->line("A seguir, encontram-se o dia, horário e local de aplicação da 1ª e 2ª dose para que registre ou imprima:")
                ->line("1ª Dose")
                ->line("Dia: {$this->data_chegada_pri_dose}.")
                ->line("Local: {$this->priDose->posto->nome}.")
                ->line("Endereço: {$this->priDose->posto->endereco}.")
                ->line("2ª Dose")
                ->line("Dia: {$this->data_chegada_seg_dose}.")
                ->line("Local: {$this->segDose->posto->nome}.")
                ->line("Endereço: {$this->segDose->posto->endereco}.")
                ->line("Lembramos que para que seja realizada a aplicação da vacina, a pessoa deve apresentar documento de identificação com foto (RG/CPF), cartão do SUS e comprovante de residência. Para os agendamentos de pessoas com comorbidades é necessária a apresentação do formulário que atesta a comorbidade, previamente preenchido por um profissional de saúde (exceto pessoas com Síndrome de Down).")
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
            //
        ];
    }
}
