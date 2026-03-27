<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegistrationCompletedMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(public User $user) {}

    public function build(): self
    {
        return $this
            ->subject('Cadastro concluído com sucesso')
            ->html(
                '<p>Olá, '.e($this->user->name).'!</p>'.
                '<p>Seu cadastro foi concluído com sucesso.</p>'.
                '<p>Agora você já pode acessar a listagem de usuários do sistema.</p>'
            );
    }
}
