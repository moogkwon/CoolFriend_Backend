<?php
/**
 * Description of CallModel
 *
 * @author leo
 */
class CallModel extends CI_Model {

    public $tblName = "tb_call_history";
    public $searchItems = array(
        "caller.firstName AS callerName",
        "caller.phoneNumber AS callerPhone",
        "callee.firstName AS calleeName",
        "callee.phoneNumber AS calleePhone",
        "tb_call_history.connected_at",
        "tb_call_history.end_at"
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

        $result = $this->db->select("COUNT(".$this->tblName.".id) AS 'count'")
                            ->from($this->tblName)
                            ->join("tb_user AS caller", "caller_id = caller.id", "inner")
                            ->join("tb_user AS callee", "callee_id = callee.id", "inner");
        if ($where != "")
            $result = $result->where($where);

        $result = $result->get()
                        ->result();

        return $result [0]->count;
    }

    public function getOrder($order) {
        $orderItems = array("callerName", "callerPhone", "calleeName", "calleePhone", "connected_at", "end_at", "duration");
        if ($order ["column"] == 0) return "";
        return $orderItems [$order ["column"] - 1];
    }

    public function getData($search, $order, $start, $length) {
        $where = $this->getFilterCondition($search);

        $result = $this->db->select(array(
                    "caller.firstName AS callerName",
                    "caller.phoneNumber AS callerPhone",
                    "callee.firstName AS calleeName",
                    "callee.phoneNumber AS calleePhone",
                    "tb_call_history.connected_at",
                    "tb_call_history.end_at",
                    "TIMEDIFF(end_at, connected_at) AS duration"
                ))
                ->from($this->tblName)
                ->join("tb_user AS caller", "caller_id = caller.id", "inner")
                ->join("tb_user AS callee", "callee_id = callee.id", "inner");

        if ($where != "")
            $result = $result->where($where);
        
        if ($this->getOrder($order) != "")
            $result = $result->order_by($this->getOrder($order), $order["dir"]);

        return $result->limit($length, $start)
                        ->get()
                        ->result();
    }
}

?>