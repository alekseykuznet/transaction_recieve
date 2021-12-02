<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserResetPassword extends Mailable
{
    use Queueable, SerializesModels;

	/**
	 * @var User $user
	 */
	private $user;

	/**
	 * @var string $subjectMail
	 */
	private $subjectMail;

	/**
	 * UserResetPassword constructor.
	 * @param User $user
	 * @param string $subject
	 */
    public function __construct(User $user, string $subject = '' )
    {
        $this->user = $user;
		$this->subjectMail = $subject;
    }

	/**
	 * @return UserResetPassword
	 */
    public function build()
    {
        return $this
			->to($this->user->email)
			->subject($this->subjectMail)
			->markdown('mail.users.reset', [
				'user' => $this->user
			]);
    }
}
