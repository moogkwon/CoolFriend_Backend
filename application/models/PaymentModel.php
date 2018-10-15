<?php
/**
 * Description of PaymentModel
 *
 * @author leo
 */
class PaymentModel extends CI_Model {

    public $tblName = "tb_payment";
    public $searchItems = array(
        "tb_user.firstName",
        "tb_user.phoneNumber",
        "tb_payment.cup_count",
        "tb_payment.price",
        "tb_payment.created_at"
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
                            ->join("tb_user", "user_id = tb_user.id", "inner");
        if ($where != "")
            $result = $result->where($where);

        $result = $result->get()
                        ->result();

        return $result [0]->count;
    }

    public function getOrder($order) {
        $orderItems = array("firstName", "phoneNumber", "cup_count", "price", "created_at");
        if ($order ["column"] == 0) return "";
        return $orderItems [$order ["column"] - 1];
    }

    public function getData($search, $order, $start, $length) {
        $where = $this->getFilterCondition($search);

        $result = $this->db->select(array(
                    "tb_user.firstName",
                    "tb_user.phoneNumber",
                    "tb_payment.cup_count",
                    "tb_payment.price",
                    "tb_payment.created_at"
                ))
                ->from($this->tblName)
                ->join("tb_user", "user_id = tb_user.id", "inner");

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