<?php
namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * Feeds Controller
 *
 * @property \App\Model\Table\FeedsTable $Feeds
 *
 * @method \App\Model\Entity\Feed[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FeedsController extends AppController
{
    public function initialize () {
        parent::initialize();
        $this->viewBuilder()->setLayout('admin');
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $query = $this->Feeds->find('all', [
            'sort' => [
                'created' => 'DESC'
            ],
            'contain' => [
                'FeedLikes',
                'FeedDislikes'
            ]
        ]);
        // pr($query);die();
        $feeds = $this->paginate($query);

        $this->set(compact('feeds'));
    }

    /**
     * View method
     *
     * @param string|null $id Feed id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $feed = $this->Feeds->get($id, [
            'contain' => ['FeedDislikes', 'FeedLikes'],
        ]);

        $this->set('feed', $feed);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $feed = $this->Feeds->newEntity();
        $upload_status = [
            'success' => false,
            'message' => ""
        ];
        $uploaded_images = [];
        if ($this->request->is('post')) {
            $images = $this->request->data['images'];

            foreach ($images as $image) {
                if (in_array(pathinfo($image['name'], PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png'])) {
                    if (move_uploaded_file($image['tmp_name'], WWW_ROOT . 'img/feed_images/' . $image['name'])) {
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
            $data = [
                'description' => $this->request->data['description'],
                'img_name' => implode(',', $uploaded_images)
            ];
            $feed = $this->Feeds->patchEntity($feed, $data);
            if ($this->Feeds->save($feed)) {
                $this->Flash->success(__('The feed has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The feed could not be saved. Please, try again.'));
        }
        $this->set(compact('feed'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Feed id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $feed = $this->Feeds->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $feed = $this->Feeds->patchEntity($feed, $this->request->getData());
            if ($this->Feeds->save($feed)) {
                $this->Flash->success(__('The feed has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The feed could not be saved. Please, try again.'));
        }
        $this->set(compact('feed'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Feed id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $feed = $this->Feeds->get($id);
        if ($this->Feeds->delete($feed)) {
            $this->Flash->success(__('The feed has been deleted.'));
        } else {
            $this->Flash->error(__('The feed could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
