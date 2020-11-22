<?php
namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * Categories Controller
 *
 * @property \App\Model\Table\CategoriesTable $Categories
 *
 * @method \App\Model\Entity\Category[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DashboardsController extends AppController
{
    public function initialize () {
        parent::initialize();
        $this->viewBuilder()->setLayout('admin');
        $this->loadModel('Transactions');
        $this->loadModel('ProductStocks');
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $years = $this->Transactions->find('all', [
            'fields' => [
                'year' => 'distinct YEAR(created)'
            ]
        ]);

        $this->set(compact('years'));
    }

    /**
     * View method
     *
     * @param string|null $id Category id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $category = $this->Categories->get($id, [
            'contain' => ['Products'],
        ]);

        $this->set('category', $category);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $category = $this->Categories->newEntity();
        if ($this->request->is('post')) {
            $category = $this->Categories->patchEntity($category, $this->request->getData());
            if ($this->Categories->save($category)) {
                $this->Flash->success(__('The category has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The category could not be saved. Please, try again.'));
        }
        $this->set(compact('category'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Category id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $category = $this->Categories->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $category = $this->Categories->patchEntity($category, $this->request->getData());
            if ($this->Categories->save($category)) {
                $this->Flash->success(__('The category has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The category could not be saved. Please, try again.'));
        }
        $this->set(compact('category'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Category id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $category = $this->Categories->get($id);
        if ($this->Categories->delete($category)) {
            $this->Flash->success(__('The category has been deleted.'));
        } else {
            $this->Flash->error(__('The category could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function salesPerYear () {
        $this->autoRender = false;
        if ($this->request->is('ajax')) {
            $year = $this->request->data['year'];
            $query = $this->Transactions->find();
            $month = $query->func()->monthname([
                'created' => 'identifier'
            ]);
            $query->select([
                'total' => $query->func()->sum('total_price'),
                'month' => $month
            ])
            ->group('month')
            ->order(['month' => 'DESC'])
            ->where(['year(created)' => $year]);

            $data = [];
            foreach ($query as $q) {
                $data[] = [
                    'label' => $q->month,
                    'data' => $q->total
                ];
            }
            $this->response->type('json');
            $this->response->body(json_encode($data));
            return $this->response;
        }
    }

    public function getStocks () {
        $this->autoRender = false;
        if ($this->request->is('ajax')) {
            $query = $this->ProductStocks->find('all', [
                'contain' => 'Products'
            ]);
            $query->select([
                'total' => $query->func()->sum('sku'),
                'Products.name'
            ]);
            $data = [];
            foreach ($query as $q) {
                $data[] = [
                    'label' => $q->product->name,
                    'data' => $q->total
                ];
            }
            $this->response->type('json');
            $this->response->body(json_encode($data));
            return $this->response;
        }
    }
}
