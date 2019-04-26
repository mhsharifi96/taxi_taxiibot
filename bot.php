<?php
require_once("Telegram.php");
require_once("Database.php");

ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);

define("_TOKEN", "849660616:AAH6ZT73zIGDZI_opsITMfUUy14DezlejYo");
define("_ADMIN", "197418176");

global $config;
$config['host'] = "127.0.0.1";
$config['user'] = "galenoos_bot";
$config['pass'] = "mhsshb1252000!";
$config['name'] = "galenoos_bot";
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
