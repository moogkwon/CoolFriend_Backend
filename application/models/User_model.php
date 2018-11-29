<?php
class User_model extends CI_Model {
	public $tblName = 'users';
	public $tblAdmin = 'tbl_users';
	public $searchItems = array(
       /* "phoneNumber",*/
        "instagram",
        "email",
        "first_name",
        "last_name",
        "location_city",
        "location_country",
    );
	public function update($info = false){
		if(!empty($info['password'])){
			$sha_password = $this->hash($info['password']);
			$info['password'] = $sha_password;
		}else{
			unset($info['password']);
		}
		$this->db->where('user_id',$info['user_id']);
		$res = $this->db->update($this->tblAdmin,$info);
		return $res;
	}
	public function getUserById($id,$tblName = false){
		$this->db->select('*');
		if($tblName){
			$this->db->from($tblName);
			$this->db->where('id',$id);
		}else{
			$this->db->from($this->tblAdmin);
			$this->db->where('user_id',$id);
		}
		$query 	= $this->db->get();
		$row 	= $query->row();
		return $row;
	}
	public function checkMyUsername($form){
		$this->db->select('user_id');
		$this->db->from($this->tblAdmin);
		$this->db->where('username',$form['username']);
		$this->db->where('user_id != ',$form['user_id']);
		$query 	= $this->db->get();
		return $query->num_rows();
	}
	public function login($info = false){
		$row = $this->isEmailExists($info['email'],$info['role_id']);
		if(!empty($row)){
			$row = $this->doLogin($info);
			return $row;
		}else{
			return false;
		}
	}
	public function register($info = false){
		$sha_password = $this->hash($info['password']);
		$info['password'] = $sha_password;
		$res = $this->db->insert('tbl_users',$info);
		return $res;
	}
	public function isEmailExists($email = false,$role_id = false){
		$this->db->select('*');
		$this->db->from('tbl_users');
		$this->db->where('email',$email);
		$this->db->where('role_id',$role_id);
		$query 	= $this->db->get();
		$row 	= $query->row();
		return $row;
	}
	public function doLogin($info){
		$sha_password = $this->hash($info['password']);
		$this->db->select('*');
		$this->db->from('tbl_users');
		$this->db->where('email',$info['email']);
		$this->db->where('password',$sha_password);
		$this->db->where('role_id',$info['role_id']);
		$query 	= $this->db->get();
		$row 	= $query->row();
		return $row;
	}
	public function getUsers($role_id = false){
		$this->db->select('*');
		$this->db->from($this->tblName);
		$query	= $this->db->get();
		$rows	= $query->result();
		return $rows;
	}
	public function hash($string) {
        return hash('sha512', $string . config_item('encryption_key'));
	}
	 public function getTotalCount() {
        $result = $this->db->select("COUNT(id) AS 'count'")
                            ->from($this->tblName)
                            //->where('role_id',2)
                            ->get()
                            ->result();
        return $result [0]->count;
    }

    public function getFilterCondition($search) {
        if ($search == "")  return "";
        $where = "";
        foreach($this->searchItems as $i => $searchItem) {
            if ($i != 0)    $where .= " OR ";
            $where .= "$searchItem LIKE '%$search%' ";
        }
        return $where;
    }

    public function getFilterCount($search) {
        $where = $this->getFilterCondition($search);

        $this->db->select("COUNT(id) AS 'count'");
        $this->db->from($this->tblName);
		//$this->db->where('role_id',2);
        if ($where != "")
        $this->db->where($where);
		$result	= $this->db->get();
		
        $result = $result->result();

        return $result[0]->count;
    }

    public function getOrder($order) {
		
        $orderItems = array(
							/*"phoneNumber", */
							"id", 
                            "avatar", 
                            "instagram", 
                            "first_name", 
                            "first_name", 
                            "last_name", 
                            "email", 
                            "social", 
                            "birthday", 
                            "gender", 
                            "lgbtq", 
                            "location_city", 
                            "location_state", 
                            "location_country",
                            "activated", 
                            "activated", 
                            "created_at",
                            "video_url");
		 return $orderItems[$order["column"]];
        return $orderItems [$order ["column"] - 1];
    }

    public function getData($search, $order, $start, $length) {
        $where = $this->getFilterCondition($search);

        $this->db->select("users.*,users.video video_url,users.thumbnail video_thumb,user_auth.type social");
        $this->db->from("users");
        $this->db->join('user_auth','users.id = user_auth.user_id','left');
       // $this->db->join('(select max(id) max_id, user_id from user_videos group by user_id) as t1', 't1.user_id = users.id', 'left');
		//$this->db->join('user_videos as e1', 'e1.id = t1.max_id', 'left');
        //$this->db->where('role_id',2);

        if ($where != "")
        $this->db->where($where);
        
        if ($this->getOrder($order) != "")
        $this->db->order_by($this->getOrder($order), $order["dir"]);
		else
        $this->db->order_by('id','desc');
		$this->db->limit($length, $start);
		$result = $this->db->get();
	//echo '<pre>'; print_r($this->db->last_query()); echo '</pre>'; die(__FILE__.' On this line '.__LINE__);
        return  $result->result();  
    }

    public function changeStatus($id, $status) {
        $this->db->set("blocked", $status)
                ->where("id", $id)
                ->update($this->tblName);
    }
    public function deleteUser($id) {
		//$this->deleteUserVideos($id);
		//$this->deleteCallHistroy($id);
		//$this->deleteUserHashes($id);
		//$this->deleteUserAuth($id);
		$this->db->query('SET foreign_key_checks = 0');
		$this->db->where('id',$id);
		$this->db->delete('users');
		$this->db->query('SET foreign_key_checks = 1');
		return true;
    }
	public function deleteCallHistroy($user_id){
		$this->db->where('callee_id',$user_id);
		$this->db->or_where('callee_id',$user_id);
		$this->db->delete('tbl_call_history');
		return true;
	}
	public function deleteUserVideos($user_id){
		$this->db->where('user_id',$user_id);
		$this->db->delete('user_videos');
		return true;
	}
	public function deleteUserHashes($user_id){
		$this->db->where('user_id',$user_id);
		$this->db->delete('user_hashes');
		return true;
	}
	public function deleteUserAuth($user_id){
		$this->db->where('user_id',$user_id);
		$this->db->delete('user_auth');
		return true;
	}
}