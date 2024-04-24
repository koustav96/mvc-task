<?php

require_once(__DIR__. "/database_connection.php");
/**
 * Class Queries
 * 
 * Class to handle database queries.
 */
class Queries {
  /**
   * Database connection object.
   *
   * @var \PDO
   */
  private $conn;
  /**
   * Constructor to initialize the Db Queries object with a database connection.
   */
  public function __construct() {
    $dbConn = new DatabaseConnection();
    $conn = $dbConn->getConnection();
    $this->conn = $conn;
  }
  /**
   * Check if user exists.
   *
   * @param string $mail 
   * The email of the user to check.
   * @return array|false 
   * The user data if found, false otherwise.
   */
  public function checkUser($mail) {
    $chcekQuery = "SELECT * FROM userdata WHERE mail_id = ?";
    $stmt = $this->conn->prepare($chcekQuery);
    $stmt->execute([$mail]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
  }
  /**
   * Insert a new user into the database.
   *
   * @param string $name 
   * The name of the user.
   * @param string $mailId 
   * The email of the user.
   * @param string $password 
   * The password of the user.
   * @return bool 
   * True if insertion successful, false otherwise.
   */
  public function insertUser($name, $mailId, $password) {
    $insertQuery = "INSERT INTO userdata (name, mail_id, password) VALUES (?, ?, ?)";
    $stmt = $this->conn->prepare($insertQuery);
    return $stmt->execute([$name, $mailId, $password]);
  }
  /**
   * Authenticate a user based on email and password.
   *
   * @param string $mailId 
   * The email of the user.
   * @param string $password 
   * The password of the user.
   * @return string|false 
   * The name of the user if authentication successful, false otherwise.
   */
  public function authenticateUser($mailId, $password) {
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
  /**
   * Store the new post data in the database.
   *
   * @param string $email 
   * The email of the user creating the post.
   * @param string $caption 
   * The caption of the post.
   * @param string $img 
   * The image associated with the post.
   * @return bool 
   * True if post creation successful, false otherwise.
   */
  public function createPost($email, $caption, $img) {
    $insertQuery = "INSERT INTO posts (mail_id, caption, img) VALUES (?, ?, ?)";
    $stmt = $this->conn->prepare($insertQuery);
    return $stmt->execute([$email, $caption, $img]);
  }
  /**
   * Load specific number of posts from the database.
   *
   * @param int $para1 
   * The starting index of the posts to load.
   * @param int $para2 
   * The number of posts to load.
   * @return array 
   * An array of post data including name, caption, image, like count, and post ID.
   */
  public function loadPost($para1, $para2) {
    $query = "SELECT name, caption, img, like_count, id FROM posts INNER JOIN userdata ON posts.mail_id = userdata.mail_id ORDER BY ID DESC LIMIT :limit_start, :limit_count";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':limit_start', $para1, PDO::PARAM_INT);
    $stmt->bindParam(':limit_count', $para2, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }
  /**
   * Update the reset token and expiry time for a user in the database.
   *
   * @param string $email 
   * The email address of the user.
   * @param string $token_hash 
   * The hashed reset token.
   * @param string $expiry 
   * The expiry time of the token.
   * @return bool 
   * True if the update was successful, false otherwise.
   */
  public function updateResetToken($email, $token_hash, $expiry) {
    $updateQuery = "UPDATE userdata SET Reset_token_hash = :token_hash, Token_expiry_time = :expiry WHERE mail_id = :email";
    $stmt = $this->conn->prepare($updateQuery);
    $stmt->bindParam(":token_hash", $token_hash);
    $stmt->bindParam(":expiry", $expiry);
    $stmt->bindParam(":email", $email);
    return $stmt->execute();
  }
  /**
   * Validate a reset token against the database.
   *
   * @param string $token 
   * The reset token to validate.
   * @return array|false 
   * The user data associated with the token if valid, false otherwise.
   */
  public function validateToken($token) {
    $query = "SELECT * FROM userdata WHERE Reset_token_hash = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$token]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
  }
  /**
   * Change the password associated with a reset token.
   *
   * @param string $password 
   * The new password to set.
   * @param string $token 
   * The reset token identifying the user.
   * @return bool 
   * True if the password was successfully updated, false otherwise.
   */
  public function changePassword($password, $token) {
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $query = "UPDATE userdata SET password = ? WHERE Reset_token_hash = ?";
    $stmt = $this->conn->prepare($query);
    return $stmt->execute([$hashedPassword, $token]);
  }
  /**
   * Like or unlike a post based on user actions.
   *
   * @param int $post_id 
   * The ID of the post to like or unlike.
   * @param int $user_id 
   * The ID of the user performing the action.
   * @return array 
   * The result of the action.
   */
  public function likePost($post_id, $user_id) {

    // Check if the user has already liked the post.
    $likeQuery = "SELECT * FROM likes WHERE post_id = ? AND user_id = ?";
    $stmt = $this->conn->prepare($likeQuery);
    $stmt->execute([$post_id, $user_id]);
    $alreadyLiked = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // If the user has not liked the post, perform like.
    if (!$alreadyLiked) {
      // Increase the like count in the posts table.
      $updateQuery = "UPDATE posts SET like_count = like_count + 1 WHERE id = :id";
      $stmt = $this->conn->prepare($updateQuery);
      $stmt->bindParam(':id', $post_id, PDO::PARAM_INT);
      $stmt->execute();
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

      // Insert the post_id and user_id into like table.
      $insertQuery = "INSERT INTO likes (post_id, user_id) VALUES (?, ?)";
      $stmt = $this->conn->prepare($insertQuery);
      $stmt->execute([$post_id, $user_id]);

      return $result;
    } 
    // If the user has liked the post, perform unlike.
    else {
      // Decrease the like count in the posts table when a post is liked.
      $updateQuery1 = "UPDATE posts SET like_count = CASE WHEN like_count > 0 THEN like_count - 1 ELSE 0 END WHERE id = :id";
      $stmt = $this->conn->prepare($updateQuery1);
      $stmt->bindParam(':id', $post_id, PDO::PARAM_INT);
      $stmt->execute();
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

      // Delete the post_id and user_id into like table when the unlike is done.
      $deleteQuery = "DELETE FROM likes WHERE post_id = :post_id AND user_id = :user_id";
      $stmt = $this->conn->prepare($deleteQuery);
      $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
      $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
      $stmt->execute();
      return $result;
    }
  }
}
