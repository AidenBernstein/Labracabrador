<?php

class user
{
    private $uid;
    private $userName;
    private $userKey;
    private $perm;

    /**
     * @param $uid
     * @param $userName
     * @param $userKey
     * @param $perm
     */
    public function __construct($uid = NULL, $userName = NULL, $userKey = NULL, $perm = NULL)
    {
        $this->uid = $uid;
        $this->userName = $userName;
        $this->userKey = $userKey;
        $this->perm = $perm;

        if($userName) {
            $this->uid = getUID();
        } else if ($uid) {
            $this->userName = $this->getUsername();
        } else { //TODO make an error
            echo 'oopsy daisies';
        }

        if (!$userKey || ($perm === '0' || $perm === '1' || $perm === '2' || $perm === '3')) {

        }
    }

    public function getUID () {
        $db = connectDB();
        $query = 'SELECT uid FROM users WHERE username = ?';
        $stmt = $db->prepare($query);
        $stmt->bind_param('s', $this->username);
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

    public function getInfo() {
        $db = connectDB();

        $query = 'SELECT userKey, perm FROM users WHERE uid = ?';

        $stmt = $db->prepare($query);
        $stmt->bind_param('s', $this->uid);
        $stmt->execute();

//$sid = $username = $title = $fileName = '';
        $res = $stmt->get_result();
        $result = $res->fetch_array();
        $res->free();
        $db->close();

        $result['uid'] = $this->uid;

        unset($result[0]);
        unset($result[1]);
        return $result;
    }

}