<?php
/**
 * Description of AdminModel
 *
 * @author leo
 */
class AdminModel extends CI_Model {

    public $tblName = "tb_admin";

    public function __construct() {
        parent::__construct();
    }

    public function hash($string) {
        return hash('sha512', $string . config_item('encryption_key'));
	}

    public function login($data, $isAdmin = false){
        $sha_password = $this->hash($data['password']);
        $result = $this->db->select('*')
                ->from($this->tblName)
                ->where("email", $data["email"])
                ->where("password", $sha_password)
                ->get()->result();

        if(!empty($result))
        {
            $this->db->set("lastLogin", "NOW()")
                    ->where("email", $data["email"])
                    ->update("tb_admin");
                    
            $this->session->set_userdata(array("admin" => $result [0]));
            return true;
        }
        else return false;
    }

    public function checkOldPwd($password) {
        $userdata = $this->session->userdata("admin");
        $id = $userdata->id;
        $sha_password = $this->hash($password);

        $result = $this->db->select("id")
                            ->from($this->tblName)
                            ->where("id", $id)
                            ->where("password", $sha_password)
                            ->get()
                            ->result();
        return !empty($result);
    }

    public function updatePwd($password) {
        $userdata = $this->session->userdata("admin");
        $id = $userdata->id;
        $sha_password = $this->hash($password);

        $result = $this->db->set("password", $sha_password)
                            ->where("id", $id)
                            ->update($this->tblName);
        return !empty($result);
    }
}

?>