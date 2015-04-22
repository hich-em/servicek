<?php
    class category{

        private $id;

        public function __construct($nid){
            $this->id = $nid;
        }

        public function __set($name,$value){
            global $con;
            if ($this->id != NULL) {
                switch($name){
                    default :
                        $con->query("update category set ".$name."='".$db->real_escape_string($value)."' where (id='".$this->id."')");
                    break;
                }
            }
        }

        public function __get($name){
            global $con;
            if ($this->id != NULL) {
                switch($name){
                    case "id":
                        return $this->id;
                    break;
                    /*
                    case "property":
                        $q=$con->query("select property from category where (id='".$this->id."')");
			            $r=$q->fetch_row();
                        return $r[0];
                    */
                    default:
                        $q=$con->query("select ".$name." from category where (id='".$this->id."')");
			            $r=$q->fetch_row();
                        return $r[0];
                    break;
                }
            }else{
                return NULL;
            }
        }

        public static function create($param){
            global $con;
            $nid=newguid();
            $con->query("insert into category (col) values('".$db->real_escape_string($param)."')");
            return new user($nid);
        }

        public function delete(){
            global $con;
            $con->query("delete from category where id='".$this->id."'");
            $con->query("delete from category where id='".$this->id."'");
        }

    }
?>
