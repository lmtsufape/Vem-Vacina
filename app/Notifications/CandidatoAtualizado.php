<?php

namespace App\Notifications;

use App\Models\Candidato;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class CandidatoAtualizado extends Notification
{
    use Queueable;

    public $candidato1;
    public $data_chegada1;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Candidato $candidato1)
    {
        $this->candidato1 = $candidato1;
        $this->data_chegada1 =  date('d/m/Y \à\s  H:i\h', strtotime($this->candidato1->chegada));

    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database','mail'];
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
            ->line("Sr(a). {$this->candidato1->nome_completo},")
            ->line("Informamos que a sua solicitação de agendamento para vacinação foi atualizada pela Secretaria Municipal de Saúde de Garanhuns - PE.")
            ->line("A seguir, encontram-se o dia, horário e local de aplicação da sua {$this->candidato1->dose} para que registre ou imprima:")
            ->line("Dia: {$this->data_chegada1}.")
            ->line("Local: {$this->candidato1->posto->nome}.")
            ->line("Endereço: {$this->candidato1->posto->endereco}.")
            ->line("Lembramos que para que seja realizada a aplicação da vacina, a pessoa deve apresentar documento de identificação com foto (RG/CPF), cartão do SUS e comprovante de residência constando o nome da pessoa a ser vacinada.")
            ->line("- Para os agendamentos de comorbidades é necessário o formulário que atesta a comorbidade, previamente preenchido por um profissional de saúde (exceto pessoas com Síndrome de Down). ")
            ->line("- Os demais grupos prioritários deverão comprovar esta condição através um destes documentos: declaração de vínculo profissional, contracheque, ou outro documento que comprove o exercício da função e/ou vinculação com o serviço.")
            ->line("Reforçamos a importância de que a pessoa esteja de posse de todos os documentos! Eles são necessários para que a vacina possa ser aplicada. Agradecemos a sua atenção e ficamos à disposição para outros esclarecimentos que sejam necessários!")
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
            'message' => 'Atualizado por: '. Auth::user()->email .' Condidato ID:'. $this->candidato1->cpf. ' Aprovado'
        ];
    }
}
