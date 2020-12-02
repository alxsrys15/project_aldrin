<?php 
namespace App\Mailer;

use Cake\Mailer\Mailer;

/**
 * 
 */
class TransactionMailer extends Mailer
{
	public function order ($transaction) {
		$this->to($transaction->user->email)
			->from(['no-reply@loukhaclothing.store' => 'Your order has been placed'])
			->subject('Your order has been placed')
			->setViewVars(['transaction' => $transaction])
			->emailFormat('html')
			->template('order', 'default');
	}
}