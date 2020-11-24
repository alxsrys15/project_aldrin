<?php 
namespace App\Mailer;

use Cake\Mailer\Mailer;

/**
 * 
 */
class UserMailer extends Mailer
{
	public function welcome ($user) {
		$this->to($user->email)
			->from(['no-reply@loukhaclothing.store' => 'Welcome'])
			->subject('Welcome')
			->setViewVars(['user' => $user])
			->emailFormat('html')
			->template('welcome', 'default');
	}
}