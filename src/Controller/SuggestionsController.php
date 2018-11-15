<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Menus Controller
 *
 * @property \App\Model\Table\MenusTable $Menus
 *
 * @method \App\Model\Entity\Menu[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SuggestionsController extends AppController{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users']
        ];
        $suggestions = $this->paginate($this->Suggestions);

        $this->set(compact('suggestions'));
    }

    /**
     * View method
     *
     * @param string|null $id Menu id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $suggestion = $this->Suggestions->get($id, [
            'contain' => ['Users']
        ]);

        $this->set('suggestion', $suggestion);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $suggestion = $this->Suggestions->newEntity();
        if ($this->request->is('post')) {
            $suggestion = $this->Suggestions->patchEntity($suggestion, $this->request->getData());
            if ($this->Suggestions->save($suggestion)) {
                $this->Flash->success(__('The Suggestion has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The Suggestion could not be saved. Please, try again.'));
        }
        $this->set(compact('suggestion'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Menu id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $menu = $this->Suggestions->get($id);
        if ($this->Suggestions->delete($menu)) {
            $this->Flash->success(__('The Suggestion has been deleted.'));
        } else {
            $this->Flash->error(__('The Suggestion could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
