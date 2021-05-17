<?php
namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * Products Controller
 *
 *
 * @method \App\Model\Entity\Product[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProductsController extends AppController
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
        $products = $this->paginate($this->Products);

        $this->set(compact('products'));
    }

    /**
     * View method
     *
     * @param string|null $id Product id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $product = $this->Products->get($id, [
            'contain' => [],
        ]);

        $this->set('product', $product);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $categories = $this->Products->Categories->find('list' ,[
            'conditions' => [
                'is_active' => 1
            ]
        ]);
        $sizes = $this->Products->ProductStocks->Sizes->find('list');
        $product = $this->Products->newEntity();
        $upload_status = [
            'success' => false,
            'message' => ""
        ];
        $uploaded_images = [];
        if ($this->request->is('post')) {
            
            $new_product = $this->request->data;
            $new_product['images'] = "";
            $images = $this->request->data['images'];
            
            foreach ($images as $image) {
                if (in_array(pathinfo($image['name'], PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png'])) {
                    if (move_uploaded_file($image['tmp_name'], WWW_ROOT . 'img/product_images/' . $image['name'])) {
                        $upload_status['success'] = true;
                        $uploaded_images[] = $image['name'];
                    } else {
                        $upload_status['message'] = "Something wrong!";
                        break;
                    }
                } else {
                    $upload_status['message'] = "Wrong image format";
                    break;
                }
            }
            if ($upload_status['success']) {
                $new_product['imgs'] = implode(',', $uploaded_images);
                $new_product = $this->Products->newEntity($new_product, ['associated' => ['ProductStocks']]);
                if ($this->Products->save($new_product, ['associated' => ['ProductStocks']])) {
                    $this->Flash->success('Product added.');
                    return $this->redirect(['action' => 'index']);
                } else {
                    $this->Flash->success('Something went wrong');
                }
            } else {
                $this->Flash->error($upload_status['message']);
            }
        }
        $this->set(compact('product', 'categories', 'sizes'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Product id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $product = $this->Products->get($id, [
            'contain' => [
                'ProductStocks'
            ],
        ]);

        $categories = $this->Products->Categories->find('list' ,[
            'conditions' => [
                'is_active' => 1
            ]
        ]);
        $sizes = $this->Products->ProductStocks->Sizes->find('list');

        $product['images'] = explode(',', $product->imgs);
        $upload_status = [
            'success' => false,
            'message' => ""
        ];
        $uploaded_images = [];
        if ($this->request->is(['patch', 'post', 'put'])) {
            $images = $this->request->data['images'];
            foreach ($images as $key => $image) {
                if (in_array(pathinfo($image['name'], PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png'])) {
                    if (move_uploaded_file($image['tmp_name'], WWW_ROOT . 'img/product_images/' . $image['name'])) {
                        $upload_status['success'] = true;
                        $uploaded_images[$key] = $image['name'];
                    }
                }
            }
            unset($this->request->data['images']);
            $new_images_keys = array_keys($uploaded_images);
            foreach ($new_images_keys as $k) {
                $product['images'][$k] = $uploaded_images[$k];
            }
            $this->request->data['imgs'] = implode(',', $product['images']);
            $product = $this->Products->patchEntity($product, $this->request->getData(), ['associated' => ['ProductStocks']]);
            if ($this->Products->save($product, ['associated' => ['ProductStocks']])) {
                $this->Flash->success(__('The product has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The product could not be saved. Please, try again.'));
        }
        $this->set(compact('product', 'categories', 'sizes'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Product id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $product = $this->Products->get($id);
        if ($this->Products->delete($product)) {
            $this->Flash->success(__('The product has been deleted.'));
        } else {
            $this->Flash->error(__('The product could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function updateProd ($id, $is_active = 1) {
        if ($id) {
            $product = $this->Products->get($id);
            $product->is_active = $is_active;
            if ($this->Products->save($product)) {
                $this->Flash->success('Product updated');
                return $this->redirect(['action' => 'edit', $id]);
            }
        }
    }

    public function viewStocks ($product_id) {
        if ($product_id) {
            $product = $this->Products->get($product_id, [
                'contain' => [
                    'ProductStocks',
                    'ProductStocks.Sizes'
                ]
            ]);
            $this->set(compact('product'));
        }
    }

    public function addStocks () {
        $this->autoRender = false;
        if ($this->request->is('post')) {
            $pv_id = $this->request->getData('pv_id');
            $quantity = $this->request->getData('quantity');
            if ($pv_id) {
                $pv = $this->Products->ProductStocks->get($pv_id);
                $pv->sku += $quantity;
                if ($this->Products->ProductStocks->save($pv)) {
                    $hist_data = [
                        'product_stock_id' => $pv_id,
                        'action' => 'added ' . $quantity . ' pcs.',
                        'user_id' => $this->Auth->User('id')
                    ];

                    $this->Products->ProductStocks->HistInventory->save($this->Products->ProductStocks->HistInventory->newEntity($hist_data));
                    $this->Flash->success(__('Stock added!'));
                }
            }
        }
        return $this->redirect(['action' => 'viewStocks', $pv->product_id]);
    }

    public function removeStocks () {
        $this->autoRender = false;
        if ($this->request->is('post')) {
            $pv_id = $this->request->getData('rem_pv_id');
            $quantity = $this->request->getData('rem_quantity');
            if ($pv_id) {
                $pv = $this->Products->ProductStocks->get($pv_id);
                $pv->sku -= $quantity;
                if ($this->Products->ProductStocks->save($pv)) {
                    $hist_data = [
                        'product_stock_id' => $pv_id,
                        'action' => 'removed ' . $quantity . ' pcs.',
                        'user_id' => $this->Auth->User('id')
                    ];

                    $this->Products->ProductStocks->HistInventory->save($this->Products->ProductStocks->HistInventory->newEntity($hist_data));
                    $this->Flash->success(__('Stock removed!'));
                }
            }
        }
        return $this->redirect(['action' => 'viewStocks', $pv->product_id]);
    }

    public function stockHistory () {
        $hists = [];
        $this->layout = null;
        if ($this->request->is('post')) {
            $pv_id = $this->request->getData('pv_id');
            if ($pv_id) {
                $query = $this->Products->ProductStocks->HistInventory->find('all', [
                    'conditions' => [
                        'product_stock_id' => $pv_id
                    ],
                    'order' => [
                        'created' => 'DESC'
                    ],
                    'contain' => [
                        'Users'
                    ]
                ]);
                $hists = $this->paginate($query, ['limit' => 5]);
            }
        }
        $this->set(compact('hists', 'pv_id'));
        $this->render('hist_inventory_table');
    }
}
