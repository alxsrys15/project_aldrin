<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * Feeds Controller
 *
 * @property \App\Model\Table\FeedsTable $Feeds
 *
 * @method \App\Model\Entity\Feed[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FeedsController extends AppController
{
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->Auth->allow(['index']);
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
                'created' => 'desc'
            ],
            'contain' => [
                'FeedLikes',
                'FeedDislikes'
            ]
        ]);

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
            'contain' => ['FeedDislikes', 'FeedLikes', 'FeedComments'],
        ]);

        $query = $this->Feeds->FeedComments->find('all', [
            'conditions' => [
                'feed_id' => $id
            ],
            'order' => [
                'created' => 'desc'
            ],
            'contain' => [
                'Users'
            ]
        ]);
        $feed_comments = $this->paginate($query ,[
            'limit' => 5
        ]);

        if ($this->request->is('post')) {
            $data = [
                'user_id' => $this->Auth->User('id'),
                'feed_id' => $id,
                'comment' => $this->request->data['comment']
            ];

            $new_comment = $this->Feeds->FeedComments->newEntity($data);
            if ($this->Feeds->FeedComments->save($new_comment)) {
                $this->Flash->success('Comment added');
                return $this->redirect(['action' => 'view', $id]);
            }
        }

        $this->set(compact('feed', 'feed_comments'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $feed = $this->Feeds->newEntity();
        if ($this->request->is('post')) {
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

    public function react () {
        $return_data = [];
        $this->autoRender = false;
        if ($this->request->is('ajax')) {
            $react = $this->request->data['react'];
            $feed_id = $this->request->data['feed_id'];
            $user_id = $this->Auth->User('id');
            $like_checker = $this->Feeds->FeedLikes->find('all', [
                'conditions' => [
                    'feed_id' => $feed_id,
                    'user_id' => $user_id
                ]
            ])->first();

            $dislike_checker = $this->Feeds->FeedDislikes->find('all', [
                'conditions' => [
                    'feed_id' => $feed_id,
                    'user_id' => $user_id
                ]
            ])->first();

            if ($react === "like") {
                if ($like_checker) { //unlike
                    if ($this->Feeds->FeedLikes->delete($like_checker)) {
                        $return_data = [
                            'react_status' => "unliked",
                            'success' => true
                        ];
                    }
                } else { 
                    if ($dislike_checker) { //undislike then like
                        if ($this->Feeds->FeedDislikes->delete($dislike_checker)) {
                            $data = [
                                'feed_id' => $feed_id,
                                'user_id' => $user_id
                            ];

                            $new_react = $this->Feeds->FeedLikes->newEntity($data);
                            if ($this->Feeds->FeedLikes->save($new_react)) {
                                $return_data = [
                                    'react_status' => "undisliked_then_liked",
                                    'success' => true
                                ];
                            }
                        }
                    } else { //like
                        $data = [
                            'feed_id' => $feed_id,
                            'user_id' => $user_id
                        ];

                        $new_react = $this->Feeds->FeedLikes->newEntity($data);
                        if ($this->Feeds->FeedLikes->save($new_react)) {
                            $return_data = [
                                'react_status' => "new_liked",
                                'success' => true
                            ];
                        }
                    }
                }
            } elseif ($react === "dislike") {
                if ($dislike_checker) { //undislike
                    if ($this->Feeds->FeedDislikes->delete($dislike_checker)) {
                        $return_data = [
                            'react_status' => "undisliked",
                            'success' => true
                        ];
                    }
                } else {
                    if ($like_checker) { //unlike then disliked
                        if ($this->Feeds->FeedLikes->delete($like_checker)) {
                            $data = [
                                'feed_id' => $feed_id,
                                'user_id' => $user_id
                            ];

                            $new_react = $this->Feeds->FeedDislikes->newEntity($data);
                            if ($this->Feeds->FeedDislikes->save($new_react)) {
                                $return_data = [
                                    'react_status' => "unlike_then_disliked",
                                    'success' => true
                                ];
                            }
                        }
                    } else { //dislike
                        $data = [
                            'feed_id' => $feed_id,
                            'user_id' => $user_id
                        ];

                        $new_react = $this->Feeds->FeedDislikes->newEntity($data);
                        if ($this->Feeds->FeedDislikes->save($new_react)) {
                            $return_data = [
                                'react_status' => "new_disliked",
                                'success' => true
                            ];
                        }
                    }
                }
            }

            echo json_encode($return_data);
        }
    }
}
