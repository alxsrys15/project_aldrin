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
        $this->loadModel('Products');
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
            ],
            'order' => [
                'year' => 'DESC'
            ]
        ]);

        $products = $this->Products->find('all');

        $categories = $this->Products->Categories->find('list', [
            'conditions' => [
                'is_active' => 1
            ]
        ]);
        $months = [];
        for($i = 1 ; $i <= 12; $i++) {
            $months[strtolower(date("F",mktime(0,0,0,$i,1,date("Y"))))] = date("F",mktime(0,0,0,$i,1,date("Y")));
        }

        $this->set(compact('years', 'products', 'categories', 'months'));
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
            ->where(['year(created)' => $year])
            ->where(['status_id IN' => [2,3,4]]);

            $data = [];
            $bg_colors = [];
            foreach ($query as $q) {
                $data[] = [
                    'label' => $q->month,
                    'data' => $q->total
                ];
                $bg_colors[] = $q->total >= 10000 ? 'rgba(0, 255, 2, 0.4)' : 'rgba(241, 0, 0, 0.56)';
            }
            $returnData = [
                'data' => $data,
                'bg_colors' => $bg_colors
            ];
            $this->response->type('json');
            $this->response->body(json_encode($returnData));
            return $this->response;
        }
    }

    public function getStocks () {
        $this->autoRender = false;
        if ($this->request->is('ajax')) {
            $query = $this->Products->get($this->request->getData('prod_id'), [
                'contain' => ['ProductStocks', 'ProductStocks.Sizes']
            ]);
            
            $data = [];
            foreach ($query->product_stocks as $q) {
                $data[] = [
                    'label' => $q->variant . ' ' . '('.$q->size->name.')',
                    'data' => $q->sku,
                ];

                $bg_colors[] = $q->sku >= 50 ? 'rgba(0, 255, 2, 0.4)' : 'rgba(241, 0, 0, 0.56)';
            }
            $returnData = [
                'data' => $data,
                'bg_colors' => $bg_colors
            ];
            $this->response->type('json');
            $this->response->body(json_encode($returnData));
            return $this->response;
        }
    }

    public function getBestSeller () {
        $this->autoRender = false;
        if ($this->request->is('ajax')) {
            $query = $this->Transactions->TransactionDetails->find();
            $query->select($this->Transactions->TransactionDetails)
                ->select([
                    'total' => $query->func()->sum('TransactionDetails.total_qty'),
                    'label' => $query->func()->concat(['Products.name' => 'identifier', ' - ', 'Sizes.name' => 'identifier'])
                ])
                ->where([
                    'monthname(TransactionDetails.created)' => $this->request->getData('month'),
                    'year(TransactionDetails.created)' => $this->request->getData('year'),
                    'Products.category_id' => $this->request->getData('category'),
                    'Transactions.status_id IN' => [2,3,4]
                ])
                ->limit(5)
                ->group(['TransactionDetails.product_stocks_id'])
                ->order(['TransactionDetails.total_qty' => 'DESC'])
                ->innerJoinWith('Products')
                ->innerJoinWith('Transactions')
                ->innerJoinWith('ProductStocks')
                ->innerJoinWith('ProductStocks.Sizes');
            $data = [];
            $bg_colors = [];
            foreach ($query as $q) {
                $data[] = [
                    'label' => $q->label,
                    'data' => $q->total
                ];
                $bg_colors[] = 'rgba('.implode(",", $this->generateRgb()).')';
            }
            $returnData = [
                'data' => $data,
                'bg_colors' => $bg_colors
            ];
            $this->response->type('json');
            $this->response->body(json_encode($returnData));
            return $this->response;
        }
    }

    private function generateRgb () {
        $rgbColor = [];
        foreach(array('r', 'g', 'b', 'a') as $color){
            $rgbColor[$color] = $color == 'a' ? '0.4' : mt_rand(0, 255);
        }
        return $rgbColor;
    }
}
