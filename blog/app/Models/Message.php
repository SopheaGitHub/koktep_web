<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Message extends Model
{

	protected $table = 'message';
	protected $fillable = ['parent_id', 'sender_id', 'receiver_id', 'viewed', 'subject', 'text', 'status'];

	public function getMessagesInboxByAutorId($autor_id) {
		$db = DB::table('message as m')
		->select(DB::raw('
				m.id AS message_id,
				CASE
					WHEN parent_id = 0 THEN m. SUBJECT
					ELSE (SELECT `subject` FROM message WHERE id = m.parent_id)
				END AS subject,
				m.viewed AS viewed,
				m.parent_id,
				m.created_at AS message_date,
				m.sender_id,
				m.receiver_id,
				u. NAME AS user_name,
				u.image AS user_profile
			'))
		->join('users as u', 'u.id', '=', 'm.sender_id')
		->where('m.receiver_id', '=', $autor_id)
		->where('m.status', '=', '1')
		->orderBy('m.created_at', 'DESC')
		->limit(10);
		return $db;
	}

	public function getTotalInboxByAutorId($autor_id) {
		$result = DB::select('SELECT COUNT(1) AS total FROM message WHERE receiver_id = "'.$autor_id.'" AND viewed = "0" AND status = "1" ');
		return $result[0];
	}

	public function getTotalSentByAutorId($autor_id) {
		$result = DB::select('SELECT COUNT(1) AS total FROM message WHERE sender_id = "'.$autor_id.'" AND viewed = "0" AND status = "1" ');
		return $result[0];
	}

	public function getTotalDraftByAutorId($autor_id) {
		$result = DB::select('SELECT COUNT(1) AS total FROM message WHERE sender_id = "'.$autor_id.'" AND status = "2" ');
		return $result[0];
	}

	public function getMessage($message_id) {
		$db = DB::table('message as m');
		$db->select('m.id', 'm.sender_id', 'm.receiver_id', 'm.subject', 'm.viewed', 'm.text', 'm.created_at', 'u.name AS author_name', 'u.image AS author_image');
		$db->join('users as u', 'u.id', '=', 'm.sender_id');
		$result = $db->where('m.id', '=', $message_id)->first();
		return $result;
	}

	public function getMessages($filter_data=[]) {

		switch ($filter_data['load']) {
			case 'inbox':
				$column_author = 'receiver_id';
				$status = 1;
				break;

			case 'sent':
				$column_author = 'sender_id';
				$status = 1;
				break;

			case 'draft':
				$column_author = 'sender_id';
				$status = 2;
				break;
			
			case 'trash':
				$column_author = 'sender_id';
				$status = 3;
				break;

			default:
				$column_author = 'sender_id';
				$status = 0;
				break;
		}

		$db = DB::table('message as m');

		$db->select(DB::raw('
			m.id, 
			m.sender_id, 
			m.receiver_id, 
			m.id AS message_id,
			CASE
				WHEN parent_id = 0 THEN m. SUBJECT
				ELSE (SELECT `subject` FROM message WHERE id = m.parent_id)
			END AS subject,
			viewed AS viewed,
			m.parent_id,
			m.text, 
			m.created_at,
			(SELECT COUNT(1) AS total_reply FROM message WHERE parent_id = m.id) AS total_reply,
			u.name AS author_name, 
			u.image AS author_image')
		);

		$db->join('users as u', 'u.id', '=', 'm.sender_id');

		if($filter_data['author_id']!='') {
			$db->where($column_author, '=', $filter_data['author_id']);
		}
		
		$db->where('m.status', '=', $status)->orderBy($filter_data['sort'], $filter_data['order']);
		return $db;
	}

	public function getSubMessages($parent_id) {

		$db = DB::table('message as m');

		$db->select(DB::raw('
			m.id, 
			m.sender_id, 
			m.receiver_id, 
			m.subject, 
			m.viewed, 
			m.text, 
			m.created_at,
			u.name AS author_name, 
			u.image AS author_image')
		);

		$db->join('users as u', 'u.id', '=', 'm.sender_id');
		
		$db->where('m.status', '=', '1')->where('m.parent_id', '=', $parent_id)->orderBy('m.updated_at', 'desc');
		return $db;
	}

	public function validationForm($datas=[]) {
		$error = false;
		$rules = [
            'sender_id'		=> 'required',
            'receiver_id'	=> 'required',
            'subject'		=> 'required',
            'message'		=> 'required',
        ];

        $messages = [
        	'sender_id.required'=> trans('message.sender_id_required'),
        	'receiver_id.required' => trans('message.receiver_id_required'),
        	'subject.required' 	=> trans('message.subject_required'),
        	'message.required' 	=> trans('message.message_required')
        ];

		$validator = \Validator::make($datas['request'], $rules, $messages);
		if ($validator->fails()) {
			$error = ['error'=>'1','success'=>'0','msg'=>trans('message.'.$datas['action'].'_message').' '.trans('text.unsuccessfully').'!','validatormsg'=>$validator->messages()];
        }
		return $error;
	}

}
