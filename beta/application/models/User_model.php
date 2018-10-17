<?php
class User_model extends CI_Model {
	public $tblName = 'tbl_users';
	public $searchItems = array(
        "phoneNumber",
        "username",
        "email",
        "firstName",
        "city",
        "country",
    );
	public function update($info = false){
		if(!empty($info['password'])){
			$sha_password = $this->hash($info['password']);
			$info['password'] = $sha_password;
		}else{
			unset($info['password']);
		}
		$this->db->where('id',$info['id']);
		$res = $this->db->update($this->tblName,$info);
		return $res;
	}
	public function getUserById($id){
		$this->db->select('*');
		$this->db->from($this->tblName);
		$this->db->where('id',$id);
		$query 	= $this->db->get();
		$row 	= $query->row();
		return $row;
	}
	public function checkMyUsername($form){
		$this->db->select('id');
		$this->db->from($this->tblName);
		$this->db->where('username',$form['username']);
		$this->db->where('id != ',$form['id']);
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
		$this->db->from('tbl_users');
		if($role_id)
		$this->db->where('role_id',$role_id);
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
                            ->where('role_id',2)
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
		$this->db->where('role_id',2);
        if ($where != "")
        $this->db->where($where);
		$result	= $this->db->get();
		
        $result = $result->result();

        return $result[0]->count;
    }

    public function getOrder($order) {
		
        $orderItems = array(
							"id", 
							"phoneNumber", 
                            "firstName", 
                            "email", 
                            "social", 
                            "birthday", 
                            "gender", 
                            "lgbtq", 
                            "city", 
                            "state", 
                            "country",
                            "activated", 
                            "activated", 
                            "created",
                            "video_url");
		 return $orderItems[$order["column"]];
        return $orderItems [$order ["column"] - 1];
    }

    public function getData($search, $order, $start, $length) {
        $where = $this->getFilterCondition($search);

        $this->db->select("*");
        $this->db->from($this->tblName);
        $this->db->where('role_id',2);

        if ($where != "")
        $this->db->where($where);
        
        if ($this->getOrder($order) != "")
        $this->db->order_by($this->getOrder($order), $order["dir"]);
		else
        $this->db->order_by('id','desc');
		$this->db->limit($length, $start);
		$result = $this->db->get();
	
        return  $result->result();  
    }

    public function changeStatus($id, $status) {
        $this->db->set("activated", $status)
                ->where("id", $id)
                ->update($this->tblName);
    }
    public function deleteUser($id) {
		$this->db->where('id',$id);
		$this->db->delete('tbl_users');
		return true;
    }
}