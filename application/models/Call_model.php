<?php
class Call_model extends CI_Model {
	public $tblName = "tbl_call_history";
    public $searchItems = array(
        "caller.username",
        "caller.first_name",
        "caller.last_name",
        "caller.phone",
        "callee.username",
        "callee.first_name",
        "callee.last_name",
        "callee.phone",
        "connected_at",
        "type",
        "end_at"
    );
	public function __construct() {
        parent::__construct();
    }
	public function getCalls(){
		$this->db->select('call.id as id,type,connected_at,end_at,duration,caller.id CallerID,caller.first_name CallerName,caller.email CallerEmail,callee.first_name CalleeName,callee.email CalleeEmail');
		$this->db->from('tbl_call_history as call');
		$this->db->join('users as caller','caller.id = call.caller_id','inner');
		$this->db->join('users as callee','callee.id = call.callee_id','inner');
		$query = $this->db->get();
		return $query->result();
	}
	public function getTotalCount() {
        $result = $this->db->select("COUNT(id) AS 'count'")
                            ->from($this->tblName)
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
        $this->db->select("COUNT(".$this->tblName.".id) AS 'count'");
        $this->db->from($this->tblName);
        $this->db->join("users AS caller", "caller_id = caller.id", "inner");
        $this->db->join("users AS callee", "callee_id = callee.id", "inner");
        if($where != "")
        $this->db->where($where);
		$result = $this->db->get();

        $result = $result->result();

        return $result[0]->count;
    }

    public function getOrder($order) {
        $orderItems = array("callerId","type","callerName", "callerEmail", "calleeName", "calleeEmail", "connected_at", "end_at", "duration");
       // if ($order ["column"] == 0) return "";
        return $orderItems [$order["column"]];
    }

    public function getData($search, $order, $start, $length) {
        $where = $this->getFilterCondition($search);

        $this->db->select('call.id as id,type,connected_at,end_at,duration,caller.id  callerId,caller.first_name callerName,caller.email callerEmail,callee.first_name calleeName,callee.email calleeEmail'
                );
        $this->db->from($this->tblName.' as call');
        $this->db->join("users AS caller", "caller_id = caller.id", "inner");
        $this->db->join("users AS callee", "callee_id = callee.id", "inner");

        if($where != "")
        $this->db->where($where);
        
        if ($this->getOrder($order) != "")
        $this->db->order_by($this->getOrder($order), $order["dir"]);
		else
		$this->db->order_by('id','desc');
		$this->db->limit($length, $start);
		$result = $this->db->get();
		
        return $result->result();
    }
	public function outGoingCall($user_id){
		$this->db->select('*');
		$this->db->from($this->tblName.' as call');
		$this->db->where('caller_id',$user_id);
		$result = $this->db->get();
        return $result->result();
	}
	public function outGoingConnected($user_id){
		$this->db->select('*');
		$this->db->from($this->tblName.' as call');
		$this->db->where('caller_id',$user_id);
		$this->db->where('connected_at !=','');
		$result = $this->db->get();
        return $result->result();
	}
	public function inComingCall($user_id){
		$this->db->select('*');
		$this->db->from($this->tblName.' as call');
		$this->db->where('callee_id',$user_id);
		$result = $this->db->get();
        return $result->result();
	}
	public function inComingConnected($user_id){
		$this->db->select('*');
		$this->db->from($this->tblName.' as call');
		$this->db->where('callee_id',$user_id);
		$this->db->where('connected_at !=','');
		$result = $this->db->get();
        return $result->result();
	}
	public function userAllCalls($user_id){
		$this->db->select('call.id as id,type,connected_at,end_at,duration,caller.first_name CallerName,caller.email CallerEmail,callee.first_name CalleeName,callee.email CalleeEmail');
		$this->db->join('users as caller','caller.id = call.caller_id','inner');
		$this->db->join('users as callee','callee.id = call.callee_id','inner');
		$this->db->from($this->tblName.' as call');
		$this->db->where('call.caller_id',$user_id);
		$this->db->or_where('call.callee_id',$user_id);
		$result = $this->db->get();
        return $result->result();
	}
}