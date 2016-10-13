<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\I18n\I18n;
use Cake\ORM\TableRegistry;
use DateTime;
use Cake\ORM\Query;

class FeedbacksController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Email');
        I18n::locale('en_US');
        $this->Auth->allow(['view']);
    }

    public function isAuthorized($user)
    {
        $request_action = $this->request->params['action'];
        if ($request_action == "bulkAction") {
            return true;
        }
        return parent::isAuthorized($user);
    }

    public function index()
    {
    	$company_id = $this->request->session()->read('Auth.User.company_id');
    	$page_limit=10;
    	if (isset($this->request->query['page_limit'])) {
    		$page_limit= $this->request->query('page_limit');
    	}
        $this->paginate = [
            'limit' => $page_limit,
            'order' => [
                'Feedbacks.created_on' => 'desc'
            ]
        ];

        $search = '';
        if (isset($this->request->query['search'])) {
            $search = $this->request->query('search');
        }

        $feedbacks = $this->Feedbacks->find('all')->where([
            'name LIKE' => '%' . $search . '%',
        	'company_id' => $company_id
        ]);
        $this->set('feedbacks', $this->paginate($feedbacks));
        $this->set('_serialize', ['feedbacks']);
        $user_permissions = $this->request->session()->read('user_permissions');
        
        $this->set('bulk_actions', [BULK_ACTION_DELETE => "Move to trash"]);
        $this->set('searchText', $search);
        $this->set('user_permission', $user_permissions);
        $this->set('page_limit', $page_limit);
        $this->viewBuilder()->layout("custom_layout");
    }
    
    public function view(){
		$id = $_POST['id'];
		$feedback = $this->Feedbacks->find()->select ( [
				'subject',
				'message',
				'replied_message'
		])->where ([
				'id' => $id
		])->first();
		$this->set('feedback',$feedback);
    }
    
    public function delete($id = null)
    {
    	$this->request->allowMethod(['post', 'delete']);
    	$company_id = $this->request->session()->read('Auth.User.company_id');
    	$feedback = $this->Feedbacks->get($id);
    		if ($this->Feedbacks->delete($feedback)) {
    			$this->Flash->success(__('The feedback has been deleted.'));
    		} else {
    			$this->Flash->error(__('The feedback could not be deleted. Please, try again.'));
    		} 
    	return $this->redirect(['action' => 'index']);
    }
    
    public function reply($id = null)
    {
    	$feedback = $this->Feedbacks->get($id, [
    			'contain' => []
    	]);
    	if ($this->request->is(['patch', 'post', 'put'])) {
    		$feedback['replied_date'] = new DateTime();
    		$feedback = $this->Feedbacks->patchEntity($feedback, $this->request->data);
    		$query = $this->Feedbacks->query();
    		$update = $query->update()
    		->set(['replied_message'=>$this->request->data['replied_message'],'status'=>1,
    				'replied_date'=>$feedback['replied_date']])
    				->where(['id' => $this->request->data['id']])
    				->execute();
    				if ($update) {
    					$this->Flash->success(__('The Feedback has been replied.'));
    					$template_content = array(
    							'to'=> $feedback->email,
    							'subject'=> 'RE:'.$feedback->subject,
                        		'data'=>array(
                            		'name' => $feedback->name,
                           			'content' => $this->request->data['replied_message']));
    					$this->Email->sendEmail($template_content);
    					return $this->redirect(['action' => 'index']);
    				} else {
    					$this->Flash->error(__('The Feedback could not be replied. Please, try again.'));
    				}
    	}
    	$user_permissions = $this->request->session()->read('user_permissions');
    	$this->set('user_permission', $user_permissions);
    	$this->set(compact('feedback'));
    	$this->set('_serialize', ['feedback']);
    	$this->viewBuilder()->layout("custom_layout");
    }
    
    public function bulkAction()
    {
    	$this->request->allowMethod(['post', 'delete']);
    	$selectedFeedbacks = $this->request->data('selected_content');
    	$bulkAction = $this->request->data('bulk_action');
    	if ($bulkAction == BULK_ACTION_DELETE) {
    		if ($selectedFeedbacks == "") return $this->redirect(['action' => 'index']);
    		$feedbacksToBeDeleted = explode(',', $selectedFeedbacks);
    		$error = $this->deleteAll($feedbacksToBeDeleted);
    		if (!$error) {
    			$this->Flash->success(__('All the selected Feedbacks have been deleted.'));
    		} else {
    			$this->Flash->error($error);
    		}
    	}
    
    	return $this->redirect(['action' => 'index']);
    }
    private function deleteAll($feedbacks)
    {
    	foreach ($feedbacks as &$feedbacksWithIdPrefix) {
    		$feedbacksId = str_replace('content_', '', $feedbacksWithIdPrefix);
    		$feedback = $this->Feedbacks->get($feedbacksId);
    		$this->Feedbacks->delete($feedback);
    	}
    }
    
}