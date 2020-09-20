<?php
namespace App\Controller\Shop;

use App\Controller\AppController;
use PayPal\Api\Payer;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Details;
use PayPal\Api\Amount;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Payment;
use PayPal\Exception\PayPalConnectionException;
use Ahc\Jwt\JWT;
use Cake\Routing\Router;
use Cake\Event\Event;

/**
 * Products Controller
 *
 * @property \App\Model\Table\ProductsTable $Products
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

    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->Auth->allow(['index', 'view', 'cart', 'populateCartTable', 'completeOrder']);
    }

    public function index()
    {
        $categories = $this->Products->Categories->find('all');
        $this->paginate = [
            'contain' => ['Categories'],
        ];
        $query = $this->Products->find('all', [
            'conditions' => !empty($this->request->query['category']) ? ['category_id' => $this->request->query['category']] : []
        ]);
        $products = $this->paginate($this->Products);

        $this->set(compact('products', 'categories'));
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
            'contain' => ['Categories', 'ProductStocks', 'TransactionDetails', 'ProductStocks.Sizes'],
        ]);

        $sizes = [];
        $sku = [];
        $variants = [];

        foreach ($product->product_stocks as $stock) {
            $sizes = [
                $stock->size_id => $stock->size->name
            ];
            $variants = [
                $stock->variant => $stock->variant
            ];
            if (!empty($sku[$stock->size->name])) {
                $sku[$stock->size->id] += $stock->sku;
            } else {
                $sku[$stock->size->id] = $stock->sku;
            } 
        }

        $this->set('product', $product);
        $this->set('sizes', $sizes);
        $this->set('sku', $sku);
        $this->set('variants', $variants);
        $this->set('stocks', $product->product_stocks);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $product = $this->Products->newEntity();
        if ($this->request->is('post')) {
            $product = $this->Products->patchEntity($product, $this->request->getData());
            if ($this->Products->save($product)) {
                $this->Flash->success(__('The product has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The product could not be saved. Please, try again.'));
        }
        $categories = $this->Products->Categories->find('list', ['limit' => 200]);
        $this->set(compact('product', 'categories'));
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
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $product = $this->Products->patchEntity($product, $this->request->getData());
            if ($this->Products->save($product)) {
                $this->Flash->success(__('The product has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The product could not be saved. Please, try again.'));
        }
        $categories = $this->Products->Categories->find('list', ['limit' => 200]);
        $this->set(compact('product', 'categories'));
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

    public function cart () {
        $payment_types = $this->Products->TransactionDetails->Transactions->TransactionTypes->find('list');
        if ($this->request->is('post')) {
            // pr($this->request->data);die();
            $payment_type = $this->request->getData()['payment_type'];
            $items = json_decode($this->request->getData()['items'], true);
            $shipping_address = [
                'street' => $this->request->getData('street_address'),
                'barangay' => $this->request->getData('barangay'),
                'city' => $this->request->getData('city'),
                'province' => $this->request->getData('province')
            ];

            if ($payment_type == "PayPal") {
                $this->processPaypal($items, $shipping_address);
            }
        }
        $this->set(compact('payment_types'));
    }

    public function populateCartTable () {
        if ($this->request->is('post')) {
            $cart = json_decode($this->request->data['data'], true);
            $this->set(compact('cart'));
            $this->render('cart_table');
        }
    }

    private function processPaypal ($items, $shipping_address) {
        $jwt = new JWT('secret', 'HS256', 3600, 10);
        $this->loadModel('ShippingFee');
        if (!empty($items)) {
            $paypalItemList = new ItemList();
            $total_amount = 0;
            foreach ($items as $i) {
                $total_amount += $i['total'];
                $paypalItem = new Item([
                    'name' => $i['name'],
                    'quantity' => $i['count'],
                    'price' => $i['price'],
                    'currency' => 'PHP'
                ]);
                $paypalItemList->addItem($paypalItem);
            }
            // pr($paypalItemList);die();
            $payment = new Payment([
                'intent' => 'sale',
                'redirect_urls' => [
                    'return_url' => Router::url(['prefix' => 'shop','controller' => 'products', 'action' => 'completeOrder', '?' => ['order_details' => $jwt->encode(['items' => $items, 'shipping_address' => $shipping_address]), 'success' => true, 'transaction_type_id' => '1']], true),
                    'cancel_url' => Router::url(['prefix' => 'shop', 'controller' => 'products', 'action' => 'cart'], true)
                ],
                'payer' => ['payment_method' => 'paypal'],
                'transactions' => [
                    [
                        'amount' => [
                            'total' => $total_amount + 100,
                            'currency' => 'PHP',
                            'details' => [
                                'shipping' => 100,
                                'sub_total' => $total_amount
                            ]
                        ],
                        'item_list' => $paypalItemList,
                        'description' => 'Payment',
                        'invoice_number' => uniqid()
                    ]
                ]
            ]);
            try {
                $payment->create($this->apiContext);
            } catch (PayPalConnectionException $ex) {
                pr($ex->getData());die();
            }
            $approvalUrl = $payment->getApprovalLink();
            return $this->redirect($approvalUrl);
        }
    }

    public function completeOrder () {
        $this->loadModel('Transactions');
        $jwt = new JWT('secret', 'HS256', 3600, 10);
        if ($this->request->is('get')) {
            $is_success = $this->request->getQuery()['success'];
            // pr($this->request->query);die();
            $saved = false;
            if ($is_success) {
                $order_details = $jwt->decode($this->request->getQuery()['order_details']);
                $items = json_decode(json_encode($order_details['items']), true);
                $shipping_address = json_decode(json_encode($order_details['shipping_address']), true);
                $token_check = $this->Transactions->exists(['paypal_token' => $this->request->getQuery()['token']]);
                if (!$token_check) {
                    $total = 0;
                    $newOrderDetails = [];
                    foreach ($items as $i) {
                        $total += $i['total'];
                        $newOrderDetails[] = [
                            'product_id' => $i['id'],
                            'product_stocks_id' => $i['stock_id'],
                            'total_qty' => $i['count']
                        ];
                    }

                    $newOrder = [
                        'user_id' => $this->Auth->User('id'),
                        'total' => (int) $total,
                        'transaction_type_id' => $this->request->getQuery()['transaction_type_id'],
                        'status_id' => 2,
                        'paypal_token' => $this->request->getQuery()['token'],
                        'transaction_details' => $newOrderDetails,
                        'shipping_fee' => 100
                    ];
                    $newOrder = array_merge($newOrder, $shipping_address);
                    
                    $newOrder = $this->Transactions->newEntity($newOrder, ['associated' => 'TransactionDetails']);
                    
                    if ($this->Transactions->save($newOrder, ['associated' => 'TransactionDetails'])) {
                        $this->adjustStock($items);
                    } else {
                        pr($newOrder);die();
                    }
                }
                $this->set(compact('items', 'shipping_fee'));
            }
        }
    }

    private function adjustStock($items = []) {
        if (!empty($items)) {
            foreach ($items as $i) {
                $pv = $this->Products->ProductStocks->find('all', [
                    'conditions' => [
                        'id' => $i['stock_id']
                    ]
                ])->first();
                $pv->sku = $pv->sku - $i['count'];
                $this->Products->ProductStocks->save($pv);
            }
        }
    }
}
