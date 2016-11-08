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

  public function postMessage($name, $message)
  {
    $name = $this->mMysqli->real_escape_string($name);
    $message = $this->mMysqli->real_escape_string($message);
    $query = 'INSERT INTO user_chats(postedOn, username, message) ' . 'VALUES (NOW(), "' . $name . '" , "' . $message . '")';
    $result = $this->mMysqli->query($query);
  }

  public function retrieveNewMessages($id = 0)
  {
    $id = $this->mMysqli->real_escape_string($id);

    if ($id > 0)
    {
      $query = 'SELECT id, username, message,' . ' DATE_FORMAT(postedOn, "%Y-%m-%d %H:%i:%s") ' . ' AS postedOn ' . ' FROM user_chats WHERE id > ' . $id . ' ORDER BY id ASC';
    }
    else
    {
      $query = 'SELECT id, username, message, postedOn FROM (SELECT id, username, message, DATE_FORMAT(postedOn,"%Y-%m-%d %H:%i:%s") AS postedOn  FROM user_chats ORDER BY id DESC LIMIT 50) AS Last50 ORDER BY id ASC';
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
}

?>
