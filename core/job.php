<?php
    class job{

        private $id;

        public function __construct($nid){
            $this->id = $nid;
        }

        public function __set($name,$value){
            global $db;
            if ($this->id != NULL) {
                switch($name){
                    case "admin":
                        $this->id_admin=$value->id;
                    default :
                        $db->query("update job set ".$name."=".($value===null?"NULL":"'".$db->real_escape_string($value)."'")." where (id='".$this->id."')");
                    break;
                }
            }
        }

        public function __get($name){
            global $db;
            if ($this->id != NULL) {
                switch($name){
                    case "id":
                        return $this->id;
                    break;
                    case "isvalid":
                        $q=$db->query("select count(*) from job where (id='".$this->id."')");
                        $r=$q->fetch_row();
                        return $r[0]==1;
                    break;
                    case "admin":
                        return new user($this->id_admin);
                    break;
                    case "categories":
                        $list = array();
                        $q=$db->query("select id_category from category_children where (id_children='".$this->id."' and children_type='job')");
                        while($r=$q->fetch_row()) $list[] = new category($r[0]);
                        return $list;
                    break;

                    case "is_contracted":
                        $q=$db->query("select count(id) from contract where (id_page='".$this->id."' and page_type='job' and TIMESTAMPDIFF(DAY,NOW(),DATE_ADD(creation_time, INTERVAL duration MONTH)) >= 0)");
                        $r=$q->fetch_row();
                        return $r[0]>0;
                    break;                  
                    case "current_contract":
                        $q=$db->query("select id from contract where (id_page='".$this->id."' and page_type='job' and TIMESTAMPDIFF(DAY,NOW(),DATE_ADD(creation_time, INTERVAL duration MONTH)) >= 0) ORDER BY DATE_ADD(creation_time, INTERVAL duration MONTH) DESC LIMIT 1");
                        if($q->num_rows==0) return null;
                        else{
                            $r=$q->fetch_row();
                            return new contract($r[0]);
                        }
                    break;
                    case "last_contract":
                        $q=$db->query("select id from contract where (id_page='".$this->id."' and page_type='job') ORDER BY DATE_ADD(creation_time, INTERVAL duration MONTH) DESC LIMIT 1");
                        if($q->num_rows==0) return null;
                        else{
                            $r=$q->fetch_row();
                            return new contract($r[0]);
                        }
                    break;
                    case "available_contracts":
                        $q=$db->query("select id from contract where (id_page='".$this->id."' and page_type='job' and TIMESTAMPDIFF(DAY,NOW(),DATE_ADD(creation_time, INTERVAL duration MONTH)) >= 0)");
                        $list = array();
                        while($r=$q->fetch_row()) $list[] = new contract($r[0]);
                        return $list;
                    break;
                    case "all_contracts":
                        $q=$db->query("select id from contract where (id_page='".$this->id."' and page_type='job')");
                        $list = array();
                        while($r=$q->fetch_row()) $list[] = new contract($r[0]);
                        return $list;
                    break;

                    case "has_agent_requests":
                        $q=$db->query("select count(*) from agent_request where (id_for='".$this->id."' and rel_type='job')");
                        $r=$q->fetch_row();
                        return $r[0]>0;
                    break;
                    case "agent_requests":
                        $list = array();
                        $q=$db->query("select id, creation_time from agent_request where (id_for='".$this->id."' and rel_type='job')");
                        while($r=$q->fetch_row()) $list[] = array("id"=>$r[0], "creation_time"=>$r[1]);
                        return $list;
                    break;
                    case "url":
                        return "job/".$this->id;
                    default:
                        $q=$db->query("select ".$name." from job where (id='".$this->id."')");
			            $r=$q->fetch_row();
                        return $r[0];
                    break;
                }
            }else{
                return NULL;
            }
        }

        public static function create($user){
            global $db;
            $db->query("insert into job (id_admin) values('".$user->id."')");
            return new job($db->insert_id);
        }

        public function delete(){
            global $db;
            $db->query("delete from category_children where (id_children='".$this->id."' and children_type='job')");
            $db->query("delete from user_admin where (id_page='".$this->id."')");
            $db->query("delete from job where (id='".$this->id."')");
        }

        public static function get_all(){
            global $db;
            $list = array();
            $q = $db->query("select id from job");
            while($r = $q->fetch_row()){
                $list[] = new job($r[0]);
            }
            return $list;
        }

        public function assign_to_category($category){
            global $db;
            $db->query("replace into category_children (id_category, id_children, children_type) values('".$category->id."', '".$this->id."', 'job')");
        }

        public function unassign_from_category($category){
            global $db;
            $db->query("delete from category_children where (id_category='".$category->id."' and id_children='".$this->id."' and children_type='job')");
        }

        public function unassign_from_all_categories(){
            global $db;
            $db->query("delete from category_children where (id_children='".$this->id."' and children_type='job')");
        }

        public function request_agent(){
            global $db;
            $db->query("insert into agent_request (id_for, rel_type) values('".$this->id."', 'job')");
        }

        public function clear_agent_requests(){
            global $db;
            $db->query("delete from agent_request where (id_for = '".$this->id."' and rel_type = 'job')");
        }

    }
?>
