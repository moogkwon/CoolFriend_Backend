<?php
/**
 * Description of UserModel
 *
 * @author leo
 */
class UserModel extends CI_Model {

    public $tblName = "tb_user";
    public $searchItems = array(
        "phoneNumber",
        "firstName",
        "location"
    );

    public function __construct() {
        parent::__construct();
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

        $result = $this->db->select("COUNT(id) AS 'count'")
                            ->from($this->tblName);
        if ($where != "")
            $result = $result->where($where);

        $result = $result->get()
                        ->result();

        return $result [0]->count;
    }

    public function getOrder($order) {
        $orderItems = array("phoneNumber", 
                            "firstName", 
                            "birthday", 
                            "gender", 
                            "country",
                            "city", 
                            "activated", 
                            "activated", 
                            "photoUrl",
                            "created_at");
        if ($order ["column"] == 0) return "";
        return $orderItems [$order ["column"] - 1];
    }

    public function getData($search, $order, $start, $length) {
        $where = $this->getFilterCondition($search);

        $result = $this->db->select("*")
                ->from($this->tblName);

        if ($where != "")
            $result = $result->where($where);
        
        if ($this->getOrder($order) != "")
            $result = $result->order_by($this->getOrder($order), $order["dir"]);

        return $result->limit($length, $start)
                        ->get()
                        ->result();
    }

    public function changeStatus($id, $status) {
        $this->db->set("activated", $status)
                ->where("id", $id)
                ->update($this->tblName);
    }
}

?>