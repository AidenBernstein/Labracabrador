<?php

class user
{
    private $uid;
    private $userName;
    private $userKey;
    private $perm;
    public $valid = false;

    /**
     * @param $uid
     * @param $userName
     * @param $userKey
     * @param $perm
     */
    public function __construct($uid = NULL, $userName = NULL, $userKey = NULL, $perm = NULL, $create = 0)
    {
        $this->uid = $uid;
        $this->userName = $userName;
        $this->userKey = $userKey;
        $this->perm = $perm;


        if($create != 0){
            if($userName){
                $this->createUser();
            } else {
                echo 'need username to create'; //TODO make an error
            }
        } else {
            if(!$userName && !$uid){
                echo 'need uid or name'; //TODO make an error
            } else if($userName) {
                $this->uid = $this->getUID();
            } else if ($uid) {
                $this->userName = $this->getUsername();
            } else { //TODO make an error
                echo 'oopsy daisies';
            }
        }

        if (!$userKey || !($perm === '0' || $perm === '1' || $perm === '2' || $perm === '3')) {
            $result = $this->updateInfo();
            $this->userKey = $result['userKey'];
            $this->perm = $result['perm'];
        }
    }

    public function getUID () {
        $db = connectDB();
        $query = 'SELECT uid FROM users WHERE username = ?';
        $stmt = $db->prepare($query);
        $stmt->bind_param('s', $this->userName);
        $stmt->execute();

        $res = $stmt->get_result();
        $result = $res->fetch_array();
        $res->free();
        $db->close();
        return $result['uid'];
    }

    public function getUsername () {
        $db = connectDB();
        $query = 'SELECT username FROM users WHERE uid = ?';
        $stmt = $db->prepare($query);
        $stmt->bind_param('d', $this->uid);
        $stmt->execute();

        $res = $stmt->get_result();
        $result = $res->fetch_array();
        $res->free();
        $db->close();
        return $result['username'];
    }

    public function updateInfo() {
        $db = connectDB();

        $query = 'SELECT userKey, perm FROM users WHERE uid = ?';

        $stmt = $db->prepare($query);
        $stmt->bind_param('d', $this->uid);
        $stmt->execute();

//$sid = $username = $title = $fileName = '';
        $res = $stmt->get_result();
        $result = $res->fetch_array();
        $res->free();
        $db->close();

        $result['uid'] = $this->uid;
        $result['username'] = $this->userName;

        unset($result[0]);
        unset($result[1]);
        return $result;
    }

    public function getInfo() {
        return ['uid'=>$this->uid, 'userName'=>$this->userName, 'userKey'=>$this->userKey, 'perm'=>$this->perm];
    }

    public function &__get($name){
        return $this->$name;
    }

    private function createUser() {
        $db = connectDB();
        $query = 'INSERT INTO users VALUES(NULL, ?, ?, ?)';
        $stmt = $db->prepare($query);
        $stmt->bind_param('sss', $this->userName, $this->userKey, $this->perm);
        $stmt->execute();

        $db->close();
        $this->uid = $this->getUID();
    }

    public function changeUser($field, $value) {

    }

    public function __toString() {
        $result = ['uid'=>$this->uid, 'userName'=>$this->userName, 'userKey'=>$this->userKey, 'perm'=>$this->perm];
        return implode(', ', $result);
    }

    public function validate($key) {
        $this->valid = ($this->userKey == $key);
    }
}

//include('../include/headerFooter.php');
//
//$billy = new user(NULL, 'KairiHang11', 'ballsmcgee', '3', 1);
//var_dump($billy->getInfo());