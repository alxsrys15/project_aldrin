<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * Transactions Controller
 *
 * @property \App\Model\Table\TransactionsTable $Transactions
 *
 * @method \App\Model\Entity\Transaction[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TransactionsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */

    public function beforeFilter (Event $event) {
        parent::beforeFilter($event);
    }

    public function initialize () {
        parent::initialize();
        $this->viewBuilder()->setLayout('admin');
    }

    public function index()
    {
        $statuses = $this->Transactions->Statuses->find('all');
        $this->paginate = [
            'contain' => ['Users', 'Statuses', 'TransactionTypes'],
        ];
        $transactions = $this->paginate($this->Transactions);

        $this->set(compact('transactions', 'statuses'));
    }

    /**
     * View method
     *
     * @param string|null $id Transaction id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $transaction = $this->Transactions->get($id, [
            'contain' => ['Users', 'Statuses', 'TransactionTypes', 'TransactionDetails', 'TransactionDetails.Products'],
        ]);

        $this->set('transaction', $transaction);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $transaction = $this->Transactions->newEntity();
        if ($this->request->is('post')) {
            $transaction = $this->Transactions->patchEntity($transaction, $this->request->getData());
            if ($this->Transactions->save($transaction)) {
                $this->Flash->success(__('The transaction has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The transaction could not be saved. Please, try again.'));
        }
        $users = $this->Transactions->Users->find('list', ['limit' => 200]);
        $statuses = $this->Transactions->Statuses->find('list', ['limit' => 200]);
        $transactionTypes = $this->Transactions->TransactionTypes->find('list', ['limit' => 200]);
        $this->set(compact('transaction', 'users', 'statuses', 'transactionTypes'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Transaction id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $transaction = $this->Transactions->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $transaction = $this->Transactions->patchEntity($transaction, $this->request->getData());
            if ($this->Transactions->save($transaction)) {
                $this->Flash->success(__('The transaction has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The transaction could not be saved. Please, try again.'));
        }
        $users = $this->Transactions->Users->find('list', ['limit' => 200]);
        $statuses = $this->Transactions->Statuses->find('list', ['limit' => 200]);
        $transactionTypes = $this->Transactions->TransactionTypes->find('list', ['limit' => 200]);
        $this->set(compact('transaction', 'users', 'statuses', 'transactionTypes'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Transaction id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $transaction = $this->Transactions->get($id);
        if ($this->Transactions->delete($transaction)) {
            $this->Flash->success(__('The transaction has been deleted.'));
        } else {
            $this->Flash->error(__('The transaction could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function changeStatus ($status_id, $transaction_id) {
        if ($transaction_id) {
            $transaction = $this->Transactions->get($transaction_id);
            $transaction->status_id = $status_id;
            if ($this->Transactions->save($transaction)) {
                $this->Flash->success('Transaction updated');
            }
        }
        return $this->redirect(['action' => 'index']);
    }
}
