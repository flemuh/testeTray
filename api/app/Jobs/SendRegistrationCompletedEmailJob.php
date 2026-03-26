<?php

namespace App\Jobs;

use App\Mail\RegistrationCompletedMail;
use App\Repositories\UserRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendRegistrationCompletedEmailJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public int $userId,
        public string $email
    ) {
    }

    public function handle(UserRepository $userRepository): void
    {
        $user = $userRepository->findById($this->userId);

        if (! $user) {
            return;
        }

        Mail::to($this->email)->send(new RegistrationCompletedMail($user));
    }
}
