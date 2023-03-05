<?php

class Media
{
    private $sid;
    private $username;
    private $title;
    private $desc;
    private $fileName;
    private $type;
    private $uid;

    /**
     * @param $sid
     * @param $username
     * @param $title
     * @param $desc
     * @param $fileName
     * @param $type
     */
    public function __construct($sid = NULL, $username = NULL, $title = NULL, $desc = NULL, $fileName = NULL, $type = NULL)
    {
        $this->sid = $sid;
        $this->username = $username;
        $this->title = $title;
        $this->desc = $desc;
        $this->fileName = $fileName;
        $this->type = $type;

        if($username) {
            $this->uid = $this->getUID();
        }

        if($sid){
            $this->getInfo();
        } else if($username && $title && $desc && $fileName && $type) {
            $this->addToDB();
        } else {
            echo 'error lmao'; //TODO change to an actual error
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

    public function getInfo() {
        $db = connectDB();

        $query = 'SELECT media.sid, users.username, media.title, media.filename, media.type FROM media, users WHERE sid = ?';

        $stmt = $db->prepare($query);
        $stmt->bind_param('s', $this->sid);
        $stmt->execute();

//$sid = $username = $title = $fileName = '';
        $res = $stmt->get_result();
        $result = $res->fetch_array();
        $res->free();
        $db->close();

        $this->uid = $this->getUID();
        $result['uid'] = $this->uid;

        unset($result[0]);
        unset($result[1]);
        unset($result[2]);
        unset($result[3]);
        unset($result[4]);
        return $result;
    }

    private function addToDB() {
        $db = connectDB();

        $query = "INSERT INTO media VALUES(NULL, $this->uid, '$this->title', '$this->desc', '$this->fileName', '$this->type')";
        $stmt = $db->prepare($query);
        $stmt->execute();

        $query = "SELECT sid FROM media WHERE filename = ? AND uid = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('sd', $this->fileName, $this->uid);
        $stmt->execute();

        $res = $stmt->get_result();
        $result = $res->fetch_array();
        $this->sid = $result['sid'];
    }

    public function __get($name){
        return $this->$name;
    }

    public function __toString() {
        $result = $this->getInfo();
        return implode(', ', $result);
    }

    public function drop() {
        $db = connectDB();
        $query = "DELETE FROM media WHERE sid = ?";
        echo '<br/>' . $this->sid . '<br/>';
        $stmt = $db->prepare($query);
        $stmt->bind_param('s', $this->sid);
        $stmt->execute();
        return 'asdasa';
    }
}