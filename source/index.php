<?php
require_once "boot.php";

$whatsAppController = new \Controller\WhatsAppController;
$whatsAppController->sessionStart();
$whatsAppController->auth();
$whatsAppController->sendMessage("18456031508", "Mensagem de teste 1");
$whatsAppController->sendMessage("18456031508", "Mensagem de teste 2");
$whatsAppController->sendMessage("18456031508", "Mensagem de teste 3");
$whatsAppController->sendMessage("18456031508", "Mensagem de teste 4");
$whatsAppController->sendMessage("18456031508", "Mensagem de teste 5");
$whatsAppController->sendMessage("18456031508", "Mensagem de teste 6");
$whatsAppController->close();
