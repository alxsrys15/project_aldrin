<?php 
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;


/**
 * 
 */
class HomeController extends AppController
{
	
	public function beforeFilter (Event $event) {
		parent::beforeFilter($event);
		$this->Auth->allow(['index']);
	}

	public function initialize () {
		parent::initialize();
		$this->viewBuilder()->setLayout('home_index');
	}

	public function index () {
		$this->loadModel('Products');
		$products = $this->Products->find('all', [
			'order' => 'rand()',
			'limit' => 3
		]);
		$this->set(compact('products'));
	}
}

?>