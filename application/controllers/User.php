<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	/**
	 * Controller
	 * 
	 * @author Harkirat Singh, harkiratsingh.in
	 */

	function __construct(){
		parent::__construct();

		$this->load->helper('form');

		$this->load->model("user_model");
	}

	public function index(){
		$this->load->view('welcome_message');
	}

	public function notifications(){
		$user_id = $this->session->user_id;
		if($user_id){
			$notifications = $this->user_model->get_notifications($user_id);
			$this->user_model->mark_notifications_as_read($user_id);

			$this->load->view("notifications", array("notifications"=> $notifications));
		}else
			redirect("login");
	}

	public function profile(){
		$user_id = $this->session->user_id;
		$self = True;

		if($user_id){
			$user_data = $this->user_model->get_user_data($user_id);

			if($user_data[0]){
				$user_posts = $this->user_model->get_user_posts($user_data[0]["_id"]);
				$notifications = $this->user_model->get_notifications($user_id);

				$data = array(
					"id"=> $user_id,
					"name"=> $user_data[0]['name'],
					"posts"=> $user_posts ? $user_posts : False,
					"notifications"=> $notifications,
					"self"=> $self
					);
				$this->load->view("profile", $data);
			} else{
				$this->session->unset_userdata("user_id");

				redirect("login");
				// die("Oops, something fishy happened!");
			}
		}else{
			redirect("login");
		}
	}

	public function posts($post_id=False){
		if($post_id && strlen($post_id)>0){
			try{
				$post = $this->user_model->get_post_data($post_id);
			}catch(Exception $e){
				die("Invalid request");
			}

			if($post[0]){
				$post_data = array("post"=> $post[0]);
				$user_data = $this->user_model->get_user_data($post[0]['owner_id']);
				$post_data['comments'] = $this->user_model->get_post_comments($post_id);

				if($user_data[0])
					$post_data['user'] = $user_data[0];

				$this->load->view("post", $post_data);
			} else{
				redirect("login");
			}
		}else{
			echo "Invalid post";
		}
	}

	public function add_comment(){
		if($this->input->post()){
			$post_id = $this->input->post("pid");
			$logged_in_user = $this->session->user_id;
			try{
				$post_data = $this->user_model->get_post_data($post_id);
			} catch(Exception $e){
				die("Fishy fishy fishy!");
			}


			$comment_data = array(
				"post_id"=> new mongoid($post_id),
				"text"=> $this->input->post("comment_text"),
				"by_user_id"=> new mongoid($logged_in_user),
				"created_on"=> strtotime("now")
				);
			$this->user_model->insert_comment($comment_data);

			$to_be_notified_users = $this->user_model->get_users_related_to_post($post_id);

			$user_notifications = array();
			if($logged_in_user != (string)$post_data[0]['owner_id']){
				$user_notifications[] = (string)$post_data[0]['owner_id'];
			}

			foreach ($to_be_notified_users as $key => $value) {
				if(!in_array((string)$value["by_user_id"], $user_notifications) && $logged_in_user != $value["by_user_id"]) {
					$user_notifications[] = (string) $value["by_user_id"];
				}
			}

			$this->insert_notifications_for_users($post_id, $user_notifications, new mongoid($this->session->user_id));

			redirect("posts/".$post_id);
		}else{
			echo "No data";
		}
	}

	private function insert_notifications_for_users($post_id, $user_notifications, $activity_by){
		foreach ($user_notifications as $value) {
			$notification = array(
				"to_user_id"=> new mongoid($value),
				"from_user_id"=> $activity_by,
				"post_id"=> new mongoid($post_id),
				"is_read"=> False,
				"is_fresh"=> True,
				"created_on"=> strtotime("now")
				);

			$this->user_model->insert_notification($notification);
		}
	}

	public function create_post(){
		$post_text = $this->input->post("post_text");
		$user_id = $this->session->user_id;

		if(strlen($post_text) > 0 && $user_id){
			$post_data = array(
				"owner_id"=> new mongoid($user_id),
				"text" => $post_text,
				"created_on"=> strtotime("now")
				);

			$this->user_model->insert_post($post_data);

			redirect("profile");
		}else{
			echo "No";
		}
	}

	public function login(){
		if($this->session->user_id){
			redirect("profile");
		}

		if($this->input->post()){
			$email = $this->input->post("email");
			$password = $this->input->post("password");

			$user = $this->user_model->get_user_with_email_password($email, $password);

			if($user[0]){
				$rand = substr(md5(microtime()),rand(0,26),5);
				$this->user_model->update_current_key_for_user($user[0]["_id"], $rand);

				$session_data = array("user_id"=> (string) $user[0]["_id"], "current_key"=>$rand);
				$this->session->set_userdata($session_data);

				redirect("profile");
			}
		} else{
			$this->load->view("login");
		}
	}

	public function logout(){
		$this->session->unset_userdata("user_id");

		redirect("login");
	}

	public function signup(){
		if($this->session->user_id){
			redirect("profile");
		}

		if($this->input->post()){
			$name = $this->input->post("name");
			$slug = explode("@", $name)[0];

			$user_data = array(
				"name"=> $name,
				"email"=> $this->input->post("email"),
				"password"=> $this->input->post("password"),
				"slug"=> $slug
				);

			$this->user_model->insert_user($user_data);
			redirect("login");
		}else{
			$this->load->view("signup");
		}
	}
}
