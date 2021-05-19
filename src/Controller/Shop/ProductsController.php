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
        $categories = $this->Products->Categories->find('all' ,[
            'conditions' => [
                'is_active' => 1
            ]
        ]);
        $query = $this->Products->find('all', [
            'conditions' => [
                'is_active'
            ]
        ]);

        if (isset($this->request->query['category'])) {
            $query->where(['category_id' => $this->request->query['category']]);
        }

        $products = $this->paginate($query);

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
            } else if ($payment_type == "COD") {
                $this->processCOD($items, $shipping_address);
            } else {
                $this->processBankTransfer($items, $shipping_address, $this->request->data['image']);
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

    private function processBankTransfer ($items, $shipping_address, $image) {
        $jwt = new JWT('secret', 'HS256', 3600, 10);
        if (!empty($items)) {
            if (in_array(pathinfo($image['name'], PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png'])) {
                if (move_uploaded_file($image['tmp_name'], WWW_ROOT . 'img/payment_images/' . $image['name'])) {
                    return $this->redirect(['prefix' => 'shop','controller' => 'products', 'action' => 'completeOrder', '?' => ['order_details' => $jwt->encode(['items' => $items, 'shipping_address' => $shipping_address, 'image' => $image['name']]), 'success' => true, 'transaction_type_id' => '3', 'token' => $this->generateToken(3)]]);
                }
            }
        }
    }

    private function processCOD ($items, $shipping_address) {
        $jwt = new JWT('secret', 'HS256', 3600, 10);
        if (!empty($items)) {
            return $this->redirect(['prefix' => 'shop','controller' => 'products', 'action' => 'completeOrder', '?' => ['order_details' => $jwt->encode(['items' => $items, 'shipping_address' => $shipping_address]), 'success' => true, 'transaction_type_id' => '2', 'token' => $this->generateToken(2)]]);
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

    private function generateToken ($transaction_type_id) {
        $prefix = $transaction_type_id == "2" ? "COD" : "BANK";
        $u_id = uniqid($prefix, true);
        $token_exist = $this->Products->TransactionDetails->Transactions->exists(['paypal_token' => $u_id]);
        return $token_exist ? generateToken($transaction_type_id) : $u_id;
    }

    public function completeOrder () {
        $this->loadModel('Transactions');
        $jwt = new JWT('secret', 'HS256', 3600, 10);
        $shipping_fee = 100;
        if ($this->request->is('get')) {
            $is_success = $this->request->getQuery()['success'];
            $saved = false;
            if ($is_success) {
                $order_details = $jwt->decode($this->request->getQuery()['order_details']);
                $items = json_decode(json_encode($order_details['items']), true);
                $shipping_address = json_decode(json_encode($order_details['shipping_address']), true);
                
                $token_check = $this->Transactions->exists(['paypal_token' => $this->request->getQuery()['token']]);
                // pr($token_check);die();
                $image = isset($order_details['image']) ? $order_details['image'] : null;
                $transaction_type = $this->request->getQuery()['transaction_type_id'];
                $token = "";
                if (!$token_check) {
                    
                    $total = 0;
                    $newOrderDetails = [];
                    // pr($items);die();
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
                        'total_price' => (int) $total,
                        'transaction_type_id' => $transaction_type,
                        'status_id' => $transaction_type == "1" ? 2 : 1,
                        'paypal_token' => $this->request->getQuery()['token'],
                        'transaction_details' => $newOrderDetails,
                        'shipping_fee' => $shipping_fee,
                        'payment_image' => $image
                    ];
                    $newOrder = array_merge($newOrder, $shipping_address);

                    $newOrder = $this->Transactions->newEntity($newOrder, ['associated' => ['TransactionDetails']]);
                    if ($t = $this->Transactions->save($newOrder, ['associated' => ['TransactionDetails']])) {
                        $token = $newOrder['paypal_token'];
                        $hist_data = [
                            'transaction_id' => $t->id,
                            'user_id' => $this->Auth->User('id'),
                            'action' => $transaction_type == "1" ? getActionById(2) : getActionById(1)
                        ];
                        $hist_entity = $this->Transactions->HistTransactions->newEntity($hist_data);
                        $this->Transactions->HistTransactions->save($hist_entity);
                        $this->adjustStock($items);
                    } else {
                        pr($newOrder);die();
                    }
                }
                $this->set(compact('items', 'shipping_fee', 'transaction_type', 'token'));
            }
        }
    }

    public function orderTracker () {
        $this->loadModel('Transactions');
        $items = [];
        if ($this->request->is('get')) {
            $token = $this->request->getQuery('token');
            $transaction = $this->Transactions->find('all', [
                'contain' => [
                    'TransactionDetails',
                    'TransactionDetails.Products',
                    'TransactionDetails.ProductStocks',
                    'TransactionDetails.ProductStocks.Sizes',
                    'Statuses',
                    'TransactionTypes'
                ],
                'conditions' => [
                    'paypal_token' => $token
                ]
            ])
            ->first();
            if ($transaction) {
                foreach ($transaction->transaction_details as $detail) {
                    $product_images = explode(',', $detail->product->imgs);
                    $items[] = [
                        'price' => $detail->product->price,
                        'count' => $detail->total_qty,
                        'image' => $product_images[0],
                        'name' => $detail->product->name,
                        'size_name' => $detail->product_stock->size->name
                    ];
                }
            }
        }

        $this->set(compact('items', 'transaction'));
    }

    private function adjustStock($items = []) {
        if (!empty($items)) {
            $hist_data = [];
            foreach ($items as $i) {
                $pv = $this->Products->ProductStocks->find('all', [
                    'conditions' => [
                        'id' => $i['stock_id']
                    ]
                ])->first();
                $pv->sku = $pv->sku - $i['count'];
                $hist_data[] = [
                    'user_id' => $this->Auth->User('id'),
                    'product_stock_id' => $i['stock_id'],
                    'action' => 'bought ' . $i['count'] . ' pcs.',
                ];
                $this->Products->ProductStocks->save($pv);
                $hist = $this->Products->ProductStocks->HistInventory->newEntities($hist_data);
                $this->Products->ProductStocks->HistInventory->saveMany($hist);
            }
        }
    }
}
