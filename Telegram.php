<?php

class Telegram {
  private static $jsonData;

  public function __construct($json = null) {
    if ($json != null) {
      self::$jsonData = json_decode($json);
    }
  }

  public function getChatId() {
    return self::$jsonData->message->chat->id;
  }

  public function getFullName() {
    $fullName = "";
    if (isset(self::$jsonData->message->from->first_name))
      $fullName .= self::$jsonData->message->from->first_name;
    elseif (isset(self::$jsonData->message->from->last_name))
      $fullName .= self::$jsonData->message->from->last_name;
    return $fullName;
  }

  public function getText() {
    return self::$jsonData->message->text;
  }

  public function sendMessage($chatId, $message) {
    $message = urlencode($message);
    $url = "https://api.telegram.org/bot" . _TOKEN;
    $url .= "/sendMessage?chat_id=" . $chatId;
    $url .= "&text=" . $message;
    file_get_contents($url);
  }
}
