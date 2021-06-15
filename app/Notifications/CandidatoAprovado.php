<?php

namespace App\Notifications;

use App\Models\Lote;
use App\Models\Candidato;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class CandidatoAprovado extends Notification implements ShouldQueue
{
    use Queueable;

    public $candidato1;
    public $candidato2;
    public $data_chegada;
    public $data_chegada1;
    public $data_chegada2;
    public $texto;
    public $texto_dose_unica;
    public $texto_dose_dupla;
    public $lote;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Candidato $candidato1, $candidato2)
    {
        $this->candidato1 = $candidato1;
        $this->candidato2 = $candidato2;
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
                                ->line("Lembramos que para que seja realizada a aplicação da vacina, a pessoa deve apresentar documento de identificação com foto (RG/CPF), cartão do SUS e comprovante de residência.")
                                ->line("- Para os agendamentos de pessoas com comorbidades é necessária a apresentação do formulário que atesta a comorbidade, previamente preenchido por um profissional de saúde (exceto pessoas com Síndrome de Down). ")
                                ->line("- As pessoas que pertencem aos grupos prioritários de funcionários do sistema de privação de liberdade; trabalhadores da educação, iniciando por professores da ativa de 45 a 59 anos; policiais federais, militares, civis e rodoviários, bombeiros militares e civis, e guardas municipais de 40 a 59 anos; trabalhadores do transporte coletivo de passageiros urbano de 45 a 59 anos, e caminhoneiros de 55 a 59 anos; deverão comprovar esta condição, através um dos documentos a seguir: declaração de vínculo profissional da empresa ou instituição, contracheque, ou outro documento que comprove o exercício da função e/ou vinculação com o serviço onde atua. Além de documento oficial com foto, cartão do SUS e comprovante de residência. ")
                                ->line("Reforçamos a importância de que a pessoa esteja de posse de todos os documentos! Eles são necessários para que a vacina possa ser aplicada. Agradecemos a sua atenção e ficamos à disposição para outros esclarecimentos que sejam necessários!")
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
                                ->line("Lembramos que para que seja realizada a aplicação da vacina, a pessoa deve apresentar documento de identificação com foto (RG/CPF), cartão do SUS e comprovante de residência.")
                                ->line("- Para os agendamentos de pessoas com comorbidades é necessária a apresentação do formulário que atesta a comorbidade, previamente preenchido por um profissional de saúde (exceto pessoas com Síndrome de Down). ")
                                ->line("- As pessoas que pertencem aos grupos prioritários de funcionários do sistema de privação de liberdade; trabalhadores da educação, iniciando por professores da ativa de 45 a 59 anos; policiais federais, militares, civis e rodoviários, bombeiros militares e civis, e guardas municipais de 40 a 59 anos; trabalhadores do transporte coletivo de passageiros urbano de 45 a 59 anos, e caminhoneiros de 55 a 59 anos; deverão comprovar esta condição, através um dos documentos a seguir: declaração de vínculo profissional da empresa ou instituição, contracheque, ou outro documento que comprove o exercício da função e/ou vinculação com o serviço onde atua. Além de documento oficial com foto, cartão do SUS e comprovante de residência. ")
                                ->line("Reforçamos a importância de que a pessoa esteja de posse de todos os documentos! Eles são necessários para que a vacina possa ser aplicada. Agradecemos a sua atenção e ficamos à disposição para outros esclarecimentos que sejam necessários!")
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

        ];
    }

}
