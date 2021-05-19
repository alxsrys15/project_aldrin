<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Auth\DefaultPasswordHasher;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */

    public function initialize () {
        parent::initialize();
        $this->viewBuilder()->setLayout('admin');
    }

    public function index()
    {
        $query = $this->Users->find('all', [
            'conditions' => [
                'is_admin' => 1
            ]
        ]);
        $users = $this->paginate($query);

        $this->set(compact('users'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['FeedComments', 'FeedDislikes', 'FeedLikes', 'Transactions'],
        ]);

        $this->set('user', $user);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $new_data = $this->request->getData();
            $new_data['is_active'] = 1;
            $new_data['is_admin'] = 1;
            $user = $this->Users->patchEntity($user, $new_data);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function changePassword () {
        $this->autoRender = false;
        if ($this->request->is('post')) {
            $user = $this->Users->get($this->Auth->User('id'));
            $hasher = new DefaultPasswordHasher();
            $curr_pass = $this->request->getData('curr_password');
            if ($hasher->check($curr_pass, $user->password)) {
                $user->password = $this->request->getData('new_pass');
                if ($this->Users->save($user)) {
                    $this->Flash->success('Password changed successful');
                }
            } else {
                $this->Flash->error('Wrong current password');
            }
        }
        return $this->redirect($this->referer());
    }

    public function changeStatus ($status, $user_id) {
        $this->autoRender = false;
        if($user_id) {
            $user = $this->Users->get($user_id);
            $user->is_active = $status;
            $message = $status == 0 ? 'User deactivated' : 'User activated';
            if ($this->Users->save($user)) {
                $this->Flash->success($message);
            }
        }
        return $this->redirect(['action' => 'index']);
    }
}
