<?php

class Gateway_User extends Gateway_Base
{
  public function find ( $ids )
  {
    $sql = 'SELECT users.id, 
                   users.email
            FROM   users
            WHERE  users.id IN ';
    $result = $this->findByIds($sql,$ids);

    $users = array();
    foreach ( $result as $row )
      $users[$row['id']] = new User($row['id'],
                                    $row['email']);

    return $users;
  }

  public function authenticate ( $user, $passwordHash )
  {
    $sql = 'SELECT id FROM users WHERE email = ? AND passwort = ?';
    $data = array($user,$passwordHash);
    return $this->findOne($this->getOne($sql,$data));
  }

  public function create ( $email, $passwordHash )
  {
    $sql = 'INSERT INTO users SET email = ?, passwort = ?';
    $this->query($sql,array($email,$passwordHash));
  }
  
}

?>
