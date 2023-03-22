<?php
include_once('../../user/userClass.php');

//TODO add check when adding to db

class Media
{
    private $sid;
    private $user;
    private $title;
    private $desc;
    private $fileName;
    private $type;

    /**
     * @param $sid
     * @param $user
     * @param $title
     * @param $desc
     * @param $fileName
     * @param $type
     */
    public function __construct($sid = NULL, $user = NULL, $title = NULL, $desc = NULL, $fileName = NULL, $type = NULL)
    {
        $this->sid = $sid;
        $this->user = $user;
        $this->title = $title;
        $this->desc = $desc;
        $this->fileName = $fileName;
        $this->type = $type;


        if($sid){
            $this->getInfo();
        } else if($user && $title && $desc && $fileName && $type) {
            $this->addToDB();
        } else {
            echo 'error lmao <br/> <pre>'; //TODO change to an actual error
            var_dump($this);
            echo '</pre>';
        }

    }

    public function getInfo() {
        $db = connectDB();

        $query = 'SELECT media.sid, users.username, media.title, media.filename, media.type FROM media, users WHERE sid = ?';

        $stmt = $db->prepare($query);
        $stmt->bind_param('s', $this->sid);
        $stmt->execute();

        $res = $stmt->get_result();
        $result = $res->fetch_array();
        $res->free();
        $db->close();

        $result['uid'] = $this->user->uid;

        unset($result[0]);
        unset($result[1]);
        unset($result[2]);
        unset($result[3]);
        unset($result[4]);
        return $result;
    }

    private function addToDB() {
        if (!$this->user->valid) {
            echo 'error'; //TODO make error
        }

        $db = connectDB();

        $query = "INSERT INTO media VALUES(NULL, ?, ?, ?, ?, ?)";
        $stmt = $db->prepare($query);
        $stmt->bind_param('dssss', $this->user->uid, $this->title, $this->desc, $this->fileName, $this->type);
        $stmt->execute();

        $query = "SELECT sid FROM media WHERE filename = ? AND uid = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('sd', $this->fileName, $this->user->uid);
        $stmt->execute();

        $res = $stmt->get_result();
        $result = $res->fetch_array();
        $this->sid = $result['sid'];
        $res->free();
        $db->close();
    }

    public function __get($name){
        return $this->$name;
    }

    public function __toString() {
        $result = $this->getInfo();
        return implode(', ', $result); //TODO fix this to not call getInfo
    }

    public function drop() {
        $db = connectDB();
        $query = "DELETE FROM media WHERE sid = ?";
        echo '<br/>' . $this->sid . '<br/>';
        $stmt = $db->prepare($query);
        $stmt->bind_param('s', $this->sid);
        $stmt->execute();
        $db->close();
    }
}