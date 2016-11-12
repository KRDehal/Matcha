<?PHP

Class ChatModel
{
  private $mMysqli;

  function __construct()
  {
    $this->mMysqli = new mysqli("127.0.0.1", "root", "dc06148b", "db_matcha");
  }

  public function __destruct()
  {
    $this->mMysqli->close();
  }

  public function deleteMessages()
  {
    $query = 'TRUNCATE TABLE user_chats';
    $result = $this->mMysqli->query($query);
  }

  public function postMessage($name, $match, $message)
  {
    $name = $this->mMysqli->real_escape_string($name);
    $match = $this->mMysqli->real_escape_string($match);
    $message = $this->mMysqli->real_escape_string($message);
    $query = 'INSERT INTO user_chats(postedOn, username, matchName, message) ' . 'VALUES (NOW(), "' . $name . '" , "' . $match . '" , "' . $message . '")';
    $result = $this->mMysqli->query($query);
  }

  public function retrieveNewMessages($id = 0, $match)
  {
    $id = $this->mMysqli->real_escape_string($id);
    $match = $this->mMysqli->real_escape_string($match);

    if ($id > 0)
    {
      $query = 'SELECT id, username, matchName, message,' . ' DATE_FORMAT(postedOn, "%Y-%m-%d %H:%i:%s") ' . ' AS postedOn ' . ' FROM user_chats WHERE id > ' . $id . ' ORDER BY id ASC';
    }
    else
    {
      $query = "SELECT id, username, matchName, message, postedOn FROM (SELECT id, username, matchName, message, DATE_FORMAT(postedOn,\"%Y-%m-%d %H:%i:%s\") AS postedOn  FROM user_chats WHERE matchName = '$match' ORDER BY id DESC LIMIT 50) AS Last50 ORDER BY id ASC";
    }

    $result = $this->mMysqli->query($query) or die($query . " " . mysqli_error($this->mMysqli));
    $response = '<?xml version="1.0" encoding="UTF-8" ?>';
    $response .= '<response>';
    $response .= $this->isDatabaseCleared($id);

    if ($result->num_rows)
    {
      while ($row = $result->fetch_array(MYSQLI_ASSOC))
      {
        $id = $row['id'];
        $userName = $row['username'];
        $time = $row['postedOn'];
        $message = $row['message'];
        $response .= '<id>' . $id . '</id>' . '<time>' . $time . '</time>' . '<name>' . $userName . '</name>' . '<message>' . $message . '</message>';
      }

      $result->close();
    }

    $response = $response . '</response>';
    return $response;
  }

  private function isDatabaseCleared($id)
  {
    if ($id > 0)
    {
      $check_clear = 'SELECT count(*) old FROM user_chats where id <=' . $id;
      $result = $this->mMysqli->query($check_clear);
      $row = $result->fetch_array(MYSQLI_ASSOC);

      if ($row['old'] == 0)
        return '<clear>true</clear>';
    }

    return '<clear>false</clear>';
  }

 /* public static function get_matches($userId) {

      $query = "SELECT users.id, users.username FROM matches LEFT JOIN users ON matches.matchedId=users.id WHERE matches.userId=:userId;";

      $db = Db::getConnect()->getInstance();
      $query_find = $db->prepare($query);
      $query_find->execute(array('userId' => $userId));
      $matches = $query_find->fetch_all();
      return $matches;
  }*/

}

?>
