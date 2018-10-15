<?php
/**
 * Description of ReportModel
 *
 * @author leo
 */
class ReportModel extends CI_Model {

    public $tblName = "tb_report";
    public $searchItems = array(
        "report",
        "tb_report.created_at"
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
        $orderItems = array("userName", 
                            "userPhone", 
                            "reporterName", 
                            "reporterPhone", 
                            "report", 
                            $this->tblName.".created_at");
        if ($order ["column"] == 0) return "";
        return $orderItems [$order ["column"] - 1];
    }

    public function getData($search, $order, $start, $length) {
        $where = $this->getFilterCondition($search);

        $result = $this->db->select(array(
                    $this->tblName.".id",
                    "user.firstName AS userName",
                    "user.phoneNumber AS userPhone",
                    "user.photoUrl AS photoUrl_user",
                    "reporter.firstName AS reporterName",
                    "reporter.phoneNumber AS reporterPhone",
                    "reporter.photoUrl AS photoUrl_reporter",
                    "report",
                    $this->tblName.".created_at"
                ))
                ->from($this->tblName)
                ->join("tb_user AS user", "user_id = user.id", "inner")
                ->join("tb_user AS reporter", "reporter_id = reporter.id", "inner");

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