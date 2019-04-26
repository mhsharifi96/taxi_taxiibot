<?php
require_once("Telegram.php");
require_once("Database.php");

define("_TOKEN", "<-BotToken->");
define("_ADMIN", "<-AdminChatId->");

global $config;
$config['host'] = "127.0.0.1";
$config['user'] = "<-Username->";
$config['pass'] = "<-Password->";
$config['name'] = "<-DatabaseName->";
$config['table'] = "user_data";

$json = file_get_contents('php://input');

$tg = new Telegram($json);
$db = new Database();

$chatId = $tg->getChatId();
$message = $tg->getText();

if ($message == "/start") {
  $db->insertNewUser($chatId);
  $textMessage = "Hi Welcome !\n";
  $textMessage .= "Please send to me your message.";
  $tg->sendMessage($chatId, $textMessage);
} else {
  $textMessage = "Name : " . $tg->getFullName() . "\n";
  $textMessage .= "Counter : " . $db->getUserCounter($chatId) . "\n";
  $textMessage .= "Message : " . $message;
  $tg->sendMessage(_ADMIN, $textMessage);
}