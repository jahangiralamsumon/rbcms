<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\I18n;
use Cake\ORM\TableRegistry;
use DateTime;
use Cake\ORM\Query;
use Cake\Validation\Validator;

/**
 * Pages Controller
 *
 * @property \App\Model\Table\PagesTable $Pages
 */
class MessageController extends AppController {
	public function initialize() {
		parent::initialize();
		$this->loadComponent('Email');
	}
	public function isAuthorized($user) {
		$request_action = $this->request->params['action'];
        if ($request_action == "bulkAction" || $request_action == "sentbulkAction") {
            return true;
        }
        return parent::isAuthorized($user);
	}
		
	/**
	 * Index method
	 *
	 * @return void
	 */
	public function index() {
		$page_limit = 10;
		if (isset ( $this->request->query ['page_limit'] )) {
			$page_limit = $this->request->query ( 'page_limit' );
		}
		$this->paginate = [ 
				'limit' => $page_limit 
		];
		$search = '';
		if (isset ( $this->request->query ['search'] )) {
			$search = $this->request->query ( 'search' );
		}
		
		$messages = $this->Message->find ( 'all' )->select ( [ 
				'message.msg_id',
				'message.subject',
				'message.msg_date',
				'message.is_read'
		] )->select ( [ 
				'cmsusers.email' 
		] )->join ( [ 
				'table' => 'cmsusers',
				'alias' => 'cmsusers',
				'type' => 'INNER',
				'conditions' => 'message.sender_id=cmsusers.id' 
		] )->where ( [ 
				'subject LIKE' => '%' . $search . '%',
				'user_id' => $this->Auth->user ( 'id' ),
				'is_deleted' => 0 
		] );
		
		$to_email_list = TableRegistry::get ( 'cmsusers' )->find ( 'all' )->select ( [ 
				'id',
				'email',
				'username'
		] )->where ( [ 
				'id !=' => $this->Auth->user ( 'id' ),
				'company_id' => $this->Auth->user ( 'company_id' ) 
		] )->order ( [ 
				'id' => 'ASC' 
		] );
		
		$total_unread_msg = $this->Message->find()->where(['is_read' => 0,'is_deleted'=> 0,'user_id' => $this->Auth->user('id')])->count();
		
		$this->set ('total_unread_msg', $total_unread_msg );
		$this->set ( 'to_email_list', $to_email_list );
		$user_permissions = $this->request->session ()->read ( 'user_permissions' );
		$this->set ( 'user_permission', $user_permissions );
		$this->set ( 'searchText', $search );
		$this->set ( 'bulk_actions', [ 
				BULK_ACTION_DELETE => "Move to trash" 
		] );
		$this->set ( 'messages', $this->paginate ( $messages ) );
		$this->set ( '_serialize', [ 
				'messages' 
		] );
		$this->set ( 'current_module', $this->getModules () );
		$this->set ( 'module_pages', $this->getPages () );
		$this->set ( 'page_list', $this->getPages () );
		$nav_arr [0] = array (
				'action' => 'send',
				'page_id' => '4001',
				'icon' => '<i class="fa  fa-location-arrow"></i>',
				'label' => 'Send Message',
				'id' => 'send_msg' 
		);
		$this->set ( 'nav_arr', $nav_arr );
		$this->set ( 'page_limit', $page_limit );
		$this->viewBuilder ()->layout ( 'custom_layout' );
	}
	public function send() {
		$this->autoRender=false;
		$resp = array();
		$to_email_list = $this->request->data ( 'to_email_list' );
		$subject = $this->request->data ( 'subject' );
		$msg_content = $this->request->data ( 'msg_content' );
		
		$validator = new Validator ();
		$validator->requirePresence ( 'to_email_list' )
		->notEmpty ( 'to_email_list', 'Please specify at least one recipient.' )
		->requirePresence ( 'subject' )
		->notEmpty ( 'subject', 'Subject is Required.' )
		->requirePresence ( 'msg_content' )
		->notEmpty ( 'msg_content', 'Body is Required.' );
		$errors = $validator->errors ( $this->request->data ());
		if (empty ( $errors )) {
			$send_status=true;
			foreach($to_email_list as $user_id){
				$message = $this->Message->newEntity();
				$message['user_id']=$user_id;
				$message['subject']=$subject;
				$message['msg_content']=$msg_content;
				$message['msg_date']=  date("Y-m-d H:i:s");
				$message['sender_id']=$this->Auth->user ( 'id' );
				$this->Message->save($message);
				
				$userinfo = TableRegistry::get ('cmsusers')->find ('all')->select ([
						'email',
						'username'
				])->where ( [
						'id' => $user_id
				])->first();
				
				$template_content = array(
						'to'=> $userinfo->email,
						'subject'=> $subject,
						'data'=>array(
								array(
										'name' => 'username',
										'content' => $userinfo->username
								),
								array(
										'name' => 'message',
										'content' => $msg_content
								)));
			 $this->Email->sendEmail(MANDRILL_TEMPLATE_SEND_MESSAGE, $template_content);
			}	
			$resp['status']=1;
			$resp['msg']='Your message has been sent.';		
		} else {
			$resp['status']=0;
			$resp['msg']='Message not sent.Please provide input data correctly.';
		}
		echo json_encode($resp);
		exit();
	
	}
	
	public function view($id=null) {
		$query = $this->Message->query();
		$update = $query->update()
		->set(['is_read'=>'1'])
				->where(['msg_id' => $id])
				->execute();
		
		$message = $this->Message->find ()->select ( [
				'message.msg_id',
				'message.subject',
				'message.msg_content',
				'message.msg_date'
		] )->select ( [
				'cmsusers.email'
		] )->join ( [
				'table' => 'cmsusers',
				'alias' => 'cmsusers',
				'type' => 'INNER',
				'conditions' => 'message.sender_id=cmsusers.id'
		] )->where ( [
				'msg_id' =>$id,
		] )->first();
		
		$this->set ('message',$message);
		
	}
	
	
	public function delete($id = null)
	{		
		$query = $this->Message->query();
		$update = $query->update()
		->set(['is_deleted'=>'1'])
				->where(['msg_id' => $id])
				->execute();
				if ($update) {
					$this->Flash->success(__('The Message has been moved to the Trash.'));
					return $this->redirect(['action' => 'index']);
				} else {
					$this->Flash->error(__('The Message has not been moved to the Trash.'));
					return $this->redirect(['action' => 'index']);
				}
		
		
	}
	
	public function reply($id=null){
		$message = $this->Message->get($id, [
    			'contain' => []
    	]);
		$message['subject'] = 'RE: '.$message['subject'];
    	if ($this->request->is(['patch', 'post', 'put'])) {
    		$validator = new Validator ();
    		$validator->requirePresence ( 'subject' )
    		->notEmpty ( 'subject', 'Subject is Required.' )
    		->requirePresence ( 'msg_content' )
    		->notEmpty ( 'msg_content', 'Body is Required.' );
    		$errors = $validator->errors ( $this->request->data ());
    		if (empty ( $errors )) {
    			$message = $this->Message->newEntity();
    			unset($message['msg_id']);
	    		$message['ref_msg_id']=  $this->request->data['msg_id'];
	    		$message['subject']=  $this->request->data['subject'];
	    		$message['msg_content']=  $this->request->data['msg_content'];
	    		$message['user_id']=  $this->request->data['user_id'];
	    		$message['msg_date']=  date("Y-m-d H:i:s");
				$message['sender_id']=$this->Auth->user ('id');
				//pr($message);exit;
				$userinfo = TableRegistry::get ('cmsusers')->find ('all')->select ([
						'email',
						'username'
				])->where ( [
						'id' => $this->request->data['user_id']
				])->first();
				$template_content = array(
						'to'=> $userinfo->email,
						'subject'=> $this->request->data['subject'],
						'data'=>array(
								array(
										'name' => 'username',
										'content' => $userinfo->username
								),
								array(
										'name' => 'message',
										'content' => $this->request->data['msg_content']
								)));
				$this->Email->sendEmail(MANDRILL_TEMPLATE_SEND_MESSAGE, $template_content);
    		if ($this->Message->save($message)) {
    			$this->Flash->success(__('Your message has been sent.'));
    			return $this->redirect(['action' => 'sent']);
    		} else {
    			$this->Flash->error(__('The Message could not be replied. Please, try again.'));
    		}
    	} else{
    		foreach ($errors as $key => $value) {
    		foreach ($errors[$key] as $errorKey => $errorValue) {
    			$this->Flash->error($errorValue);
    		}
    		}
    	}
    	}
    	$total_unread_msg = $this->Message->find()->where(['is_read' => 0,'user_id' => $this->Auth->user('id')])->count();
    	
    	$this->set ('total_unread_msg', $total_unread_msg );
    	$user_permissions = $this->request->session()->read('user_permissions');
    	$this->set('user_permission', $user_permissions);
    	$this->set(compact('message'));
    	$this->set('_serialize', ['message']);
    	$this->viewBuilder()->layout("custom_layout");
	}
	
	public function sent(){
		$page_limit = 10;
		if (isset ( $this->request->query ['page_limit'] )) {
			$page_limit = $this->request->query ( 'page_limit' );
		}
		$this->paginate = [
				'limit' => $page_limit
		];
		$search = '';
		if (isset ( $this->request->query ['search'] )) {
			$search = $this->request->query ( 'search' );
		}
		
		$messages = $this->Message->find ( 'all' )->select ( [
				'message.msg_id',
				'message.subject',
				'message.msg_date'
		] )->select ( [
				'cmsusers.email'
		] )->join ( [
				'table' => 'cmsusers',
				'alias' => 'cmsusers',
				'type' => 'INNER',
				'conditions' => 'message.user_id=cmsusers.id'
		] )->where ( [
				'subject LIKE' => '%' . $search . '%',
				'sender_id' => $this->Auth->user ( 'id' ),
				'is_sent_msg_deleted' => 0
		] );
		
		$to_email_list = TableRegistry::get ( 'cmsusers' )->find ( 'all' )->select ( [
				'id',
				'email',
				'username'
		] )->where ( [
				'id !=' => $this->Auth->user ( 'id' ),
				'company_id' => $this->Auth->user ( 'company_id' )
		] )->order ( [
				'id' => 'ASC'
		] );
		$total_unread_msg = $this->Message->find()->where(['is_read' => 0,'user_id' => $this->Auth->user('id')])->count();
		
		$this->set ('total_unread_msg', $total_unread_msg );		
		$this->set ( 'to_email_list', $to_email_list );
		$user_permissions = $this->request->session ()->read ( 'user_permissions' );
		$this->set ( 'user_permission', $user_permissions );
		$this->set ( 'searchText', $search );
		$this->set ( 'bulk_actions', [
				BULK_ACTION_DELETE => "Move to trash"
		] );
		$this->set ( 'messages', $this->paginate ( $messages ) );
		$this->set ( '_serialize', [
				'messages'
		] );
		$this->set ( 'current_module', $this->getModules () );
		$this->set ( 'module_pages', $this->getPages () );
		$this->set ( 'page_list', $this->getPages () );
		$nav_arr [0] = array (
				'action' => 'send',
				'page_id' => '4001',
				'icon' => '<i class="fa  fa-location-arrow"></i>',
				'label' => 'Send Message',
				'id' => 'send_msg'
		);
		$this->set ( 'nav_arr', $nav_arr );
		$this->set ( 'page_limit', $page_limit );
		$this->viewBuilder ()->layout ( 'custom_layout' );
	}
	
	public function sentview($id=null) {
	
		$message = $this->Message->find ()->select ( [
				'message.msg_id',
				'message.subject',
				'message.msg_content',
				'message.msg_date'
		] )->select ( [
				'cmsusers.email'
		] )->join ( [
				'table' => 'cmsusers',
				'alias' => 'cmsusers',
				'type' => 'INNER',
				'conditions' => 'message.user_id=cmsusers.id'
		] )->where ( [
				'msg_id' =>$id,
		] )->first();
	
		$this->set ('message',$message);
	
	}
	
	public function sentdelete($id = null)
	{
		$query = $this->Message->query();
		$update = $query->update()
		->set(['is_sent_msg_deleted'=>'1'])
		->where(['msg_id' => $id])
		->execute();
		if ($update) {
			$this->Flash->success(__('The Message has been moved to the Trash.'));
			return $this->redirect(['action' => 'sent']);
		} else {
			$this->Flash->error(__('The Message has not been moved to the Trash.'));
			return $this->redirect(['action' => 'sent']);
		}
	
	
	}
	
	private function checkAndDisplayEntityErrors($entity)
	{
		$entityErrors = $entity->errors();
		foreach ($entityErrors as $key => $value) {
			foreach ($entityErrors[$key] as $errorKey => $errorValue) {
				$this->Flash->error($errorValue);
			}
		}
		return $entityErrors;
	}
	
	public function bulkAction()
	{
		$selectedMessage = $this->request->data('selected_content');
		$bulkAction = $this->request->data('bulk_action');
		if ($bulkAction == BULK_ACTION_DELETE) {
			if ($selectedMessage == "") return $this->redirect(['action' => 'index']);
			$messagesToBeDeleted = explode(',', $selectedMessage);
			$error = $this->deleteAllInbox($messagesToBeDeleted);
			if (!$error) {
				$this->Flash->success(__('All the selected conversation has been moved to the Trash.'));
			} else {
				$this->Flash->error($error);
			}
		}
	
		return $this->redirect(['action' => 'index']);
	}
	
	private function deleteAllInbox($messages)
	{
		foreach ($messages as &$messagesWithIdPrefix) {
			$id = str_replace('content_', '', $messagesWithIdPrefix);
			$query = $this->Message->query();
			$update = $query->update()
			->set(['is_deleted'=>'1'])
			->where(['msg_id' => $id])
			->execute();
		
		}
	}
	
	public function sentbulkAction()
	{
		$selectedMessage = $this->request->data('selected_content');
		$bulkAction = $this->request->data('bulk_action');
		if ($bulkAction == BULK_ACTION_DELETE) {
			if ($selectedMessage == "") return $this->redirect(['action' => 'sent']);
			$messagesToBeDeleted = explode(',', $selectedMessage);
			$error = $this->sentdeleteAllInbox($messagesToBeDeleted);
			if (!$error) {
				$this->Flash->success(__('All the selected Message has been moved to the Trash.'));
			} else {
				$this->Flash->error($error);
			}
		}
	
		return $this->redirect(['action' => 'sent']);
	}
	
	private function sentdeleteAllInbox($messages)
	{
		foreach ($messages as &$messagesWithIdPrefix) {
			$id = str_replace('content_', '', $messagesWithIdPrefix);
			$query = $this->Message->query();
			$update = $query->update()
			->set(['is_sent_msg_deleted'=>'1'])
			->where(['msg_id' => $id])
			->execute();
	
		}
	}
	
	
}
