<?php

//ログイン画面の空チェック

function emptyCheck(&$errors, $check_value, $message){
  if (empty(trim($check_value))) {
      array_push($errors, $message);
  }
}
//最小文字数のチェック（最低限）
function stringMinSizeCheck(&$errors, $check_value, $message, $min_size = 8){
  if (mb_strlen($check_value) < $min_size) {
      array_push($errors, $message);
  }
}
//最大文字数のチェック
function stringMaxSizeCheck(&$errors, $check_value, $message, $max_size = 255) {
  if ($max_size < mb_strlen($check_value)) {
      array_push($errors, $message);
  }   
}  
//メールアドレスのチェック
function mailAddressCheck(&$errors, $check_value, $message) {
  if (filter_var($check_value, FILTER_VALIDATE_EMAIL) == false) {
      array_push($errors, $message);
  }
} 
//半角英数字のチェック
function halfAlphanumericCheck(&$errors, $check_value, $message) {
  if (preg_match("/^[a-zA-Z0-9]+$/", $check_value) == false) {
      array_push($errors, $message);
  }
}

 //メールアドレス重複チェック
function mailAddressDuplicationCheck(&$errors, $check_value, $message) {
  $database_handler = getDatabaseConnection();
  if ($statement = $database_handler->prepare('SELECT id FROM users WHERE email = :user_email')) {
      $statement->bindParam(':user_email', $check_value);
      $statement->execute();
  }

  $result = $statement->fetch(PDO::FETCH_ASSOC);
  if ($result) {
      array_push($errors, $message);
  }
} 