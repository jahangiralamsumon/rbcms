<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Network\Email\Email;
use Mandrill;
use stdClass;
use Exception;
/*
 * jQuery File Upload Plugin PHP Class
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */

class EmailComponent extends Component
{
	public function sendEmail($templateName,$templateContent)
	{
		if(IS_EMAIL_SEND == 'YES'){
			if(EMAIL_TYPE == 'MANDRILL'){	
				try {		
					$mandrill = new Mandrill(MANDRILL_API_KEY);
			
					$message = new stdClass();
					$message->to = $templateContent['to'];
					$message->track_opens = true;
					$message->merge_language = 'handlebars';
					$message->global_merge_vars = $templateContent['data'];
					$response = $mandrill->messages->sendTemplate($templateName, $templateContent['data'], $message);
				} catch (Exception $ex) {
					$this->log($ex);
				}
			} else if(EMAIL_TYPE == 'SMTP'){
				$email = new Email();
				$email->subject($templateContent['subject'])	
    			  ->emailFormat('html')
	    		  ->to($templateContent['to'])
				  ->viewVars(['templateContent' => $templateContent['data']])
	    		  ->template($templateName)
	    		  ->send();
    			return true;
			} 
		} 
	}
}