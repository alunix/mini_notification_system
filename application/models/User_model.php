<?php
class User_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		// Your own constructor code
    }

    public function get_notifications($user_id){
    	$aggregate = [
			['$lookup' => [
	          'from'=> "users",
	          "localField"=> "from_user_id",
	          "foreignField"=> "_id",
	          "as"=> "user_detail"
	          ]
	        ],
			['$match' => ['to_user_id'=> new mongoid($user_id), 'is_read'=>False]],
	        ['$sort' => ['created_on' => -1]]
	    ];

		return $this->mongo_db->aggregate("notifications", $aggregate)['result'];
    }

    public function mark_notifications_as_read($user_id){
    	return $this->mongo_db->where(array('to_user_id'=> new mongoid($user_id), 'is_read'=>False))->set("is_read", True)->set("is_fresh", False)->update_all("notifications");
    }

    public function get_user_posts($user_id){
    	return $this->mongo_db->where("owner_id", $user_id)->order_by(array("created_on"=> "DESC"))->get("posts");
    }

    public function get_user_data($user_id){
    	return $this->mongo_db->where("_id", new mongoid($user_id))->get("users");
    }

    public function get_post_data($post_id){
    	return $this->mongo_db->where("_id", new mongoid($post_id))->get("posts");
    }

    public function get_post_comments($post_id){
    	$aggregate = [
			['$lookup' => [
	          'from'=> "users",
	          "localField"=> "by_user_id",
	          "foreignField"=> "_id",
	          "as"=> "user_detail"
	          ]
	        ],
			['$match' => ['post_id'=> new mongoid($post_id)]],
	        ['$sort' => ['created_on' => 1]
	        ]
	    ];

		return $this->mongo_db->aggregate("comments", $aggregate)['result'];
    }

    public function insert_comment($comment_data){
    	return $this->mongo_db->insert("comments", $comment_data);
    }

    public function get_users_related_to_post($post_id){
    	$aggregate = [
			['$lookup' => [
	          'from'=> "users",
	          "localField"=> "by_user_id",
	          "foreignField"=> "_id",
	          "as"=> "user_data"
	          ]
	        ],
			['$match' => ['post_id'=> new mongoid($post_id)]],
	        ['$sort' => ['created_on' => -1]
	        ]
	    ];

		return $this->mongo_db->aggregate("comments", $aggregate)["result"];
	}

	public function insert_post($post_data){
		return $this->mongo_db->insert("posts", $post_data);
	}

	public function get_user_with_email_password($email, $password){
		return $this->mongo_db->where(array("email"=> $email, "password"=> $password))->get("users");
	}

	public function update_current_key_for_user($user_id, $random_key){
		return $this->mongo_db->where("_id", $user_id)->set("current_key", $random_key)->update("users");
	}

	public function insert_user($user_data){
		return $this->mongo_db->insert("users", $user_data);
	}

	public function insert_notification($notification){
		return $this->mongo_db->insert("notifications", $notification);
	}

}
?>