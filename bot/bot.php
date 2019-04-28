<?php
require_once("Telegram.php");
require_once("Database.php");

ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);

define("_TOKEN", "849660616:AAH6ZT73zIGDZI_opsITMfUUy14DezlejYo");
define("_ADMIN", "197418176");

$txt = "user id date";
$myfile = file_put_contents('logs.txt', $txt.PHP_EOL , FILE_APPEND | LOCK_EX);



global $config;
$config['host'] = "localhost";
$config['user'] = "userdb";
$config['pass'] = "pass";
$config['name'] = "database_name";
$config['table'] = "table_use_name";

$json = file_get_contents('php://input');

$tg = new Telegram($json);
$db = new Database();

$questions = array(
  array("question"=>"سوال اول","number"=>0),
  array("question"=>"سوال دوم","number"=>1),
  array("question"=>"سوال سوم","number"=>2),
  array("question"=>"سوال چهارم","number"=>3)
);
$count_question = 0;

$chatId = $tg->getChatId();
$message = $tg->getText();

if ($message == "/start") {
  $db->insertNewUser($chatId);
  $textMessage = "Hi Welcome !\n";
  $textMessage .= "Please send to me your message.";
  $tg->sendMessage($chatId, $textMessage);
  
}
elseif ($message =="/admin"){
  $textMessage = "سلام خدمت همه دوستان گرامی :)";
  $textMessage .= "جهت ارتباط با ادمین به ایدی @mhs969 پیام بدید .خیلی ممنونم:)";
  $tg->sendMessage($chatId, $textMessage);
}
elseif ($message == "/request"){
  $tg->sendMessage($chatId,$questions[0]["question"] );
  $question_number = $questions[0]["number"];
  $db->insertUserState($chatId);
// create table request(chatid,state)
// insert chatid,state in request
}

 else {
   //get state in request table
  //  check state 
    // if equal
    // send next question
    // state ++
    // else
  // end delete chatid in request

   if ($count_question ==1){
    $tg->sendMessage($chatId,$questions[1]["question"] );
   }
   elseif ($count_question ==2){
    $tg->sendMessage($chatId,$questions[2]["question"] );
   }
   else{
     //send first message
     //delete chatid in state
    $textMessage = "Name : " . $tg->getFullName() . "\n";
    $textMessage .= "Counter : " . $db->getUserCounter($chatId) . "\n";
    $textMessage .= "Message : " . $message;
    // $tg->sendMessage(_ADMIN, $textMessage);
    $tg->sendMessage($chatId,"hi i am in else");
  }
}
