<?php
require_once(__DIR__. "/database_connection.php");

class Queries
{
  private $conn;
  // Constructor to initialize the DatabaseQueries object with a database connection.
  public function __construct()
  {
    $dbConn = new DatabaseConnection();
    $conn = $dbConn->getConnection();
    $this->conn = $conn;
  }
  public function checkUser($mail)
  {
    $chcekQuery = "SELECT * FROM userdata WHERE mail_id = ?";
    $stmt = $this->conn->prepare($chcekQuery);
    $stmt->execute([$mail]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
  }
  public function insertUser($name, $mailId, $password)
  {
    $insertQuery = "INSERT INTO userdata (name, mail_id, password) VALUES (?, ?, ?)";
    $stmt = $this->conn->prepare($insertQuery);
    return $stmt->execute([$name, $mailId, $password]);
  }
  public function authenticateUser($mailId, $password)
  {
    $query = "SELECT * FROM userdata WHERE mail_id = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$mailId]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result !== false) {
      if (password_verify($password, $result['password'])) {
        return $result['name'];
      }
    }
    return false;
  }
  public function createPost($email, $caption, $img)
  {
    $insertQuery = "INSERT INTO posts (mail_id, caption, img) VALUES (?, ?, ?)";
    $stmt = $this->conn->prepare($insertQuery);
    return $stmt->execute([$email, $caption, $img]);
  }
  public function showPost()
  {
    $query = "SELECT name, caption, img FROM posts INNER JOIN userdata ON posts.mail_id = userdata.mail_id ORDER BY ID DESC LIMIT 5";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }
  public function loadPost($para1, $para2)
  {
    $query = "SELECT name, caption, img, like_count, id FROM posts INNER JOIN userdata ON posts.mail_id = userdata.mail_id ORDER BY ID DESC LIMIT :limit_start, :limit_count";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':limit_start', $para1, PDO::PARAM_INT);
    $stmt->bindParam(':limit_count', $para2, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }
  public function updateResetToken($email, $token_hash, $expiry) {
    $updateQuery = "UPDATE userdata SET Reset_token_hash = :token_hash, Token_expiry_time = :expiry WHERE mail_id = :email";
    $stmt = $this->conn->prepare($updateQuery);
    $stmt->bindParam(":token_hash", $token_hash);
    $stmt->bindParam(":expiry", $expiry);
    $stmt->bindParam(":email", $email);
    return $stmt->execute();
}
public function validateToken($token) {
  $query = "SELECT * FROM userdata WHERE Reset_token_hash = ?";
  $stmt = $this->conn->prepare($query);
  $stmt->execute([$token]);
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  return $result;
}
public function changePassword($password, $token) {
  $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
  $query = "UPDATE userdata SET password = ? WHERE Reset_token_hash = ?";
  $stmt = $this->conn->prepare($query);
  return $stmt->execute([$hashedPassword, $token]);
}
  public function likePost($post_id, $user_id)
  {
    $likeQuery = "SELECT * FROM likes WHERE post_id = ? AND user_id = ?";
    $stmt = $this->conn->prepare($likeQuery);
    $stmt->execute([$post_id, $user_id]);
    $alreadyLiked = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!$alreadyLiked) {
      $updateQuery = "UPDATE posts SET like_count = like_count + 1 WHERE id = :id";
      $stmt = $this->conn->prepare($updateQuery);
      $stmt->bindParam(':id', $post_id, PDO::PARAM_INT);
      $stmt->execute();
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

      $insertQuery = "INSERT INTO likes (post_id, user_id) VALUES (?, ?)";
      $stmt = $this->conn->prepare($insertQuery);
      $stmt->execute([$post_id, $user_id]);

      return $result;
    } 
    else {
      $updateQuery1 = "UPDATE posts SET like_count = CASE WHEN like_count > 0 THEN like_count - 1 ELSE 0 END WHERE id = :id";
      $stmt = $this->conn->prepare($updateQuery1);
      $stmt->bindParam(':id', $post_id, PDO::PARAM_INT);
      $stmt->execute();
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

      $deleteQuery = "DELETE FROM likes WHERE post_id = :post_id AND user_id = :user_id";
      $stmt = $this->conn->prepare($deleteQuery);
      $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
      $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
      $stmt->execute();
      return $result;
    }
  }
}
