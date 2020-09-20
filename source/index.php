<?php
require_once "boot.php";

$whatsAppController = (new \Controller\WhatsAppController)
->sessionStart()
->auth()
    ->sendMessage("18456031508", "Mensagem de teste 1")
    ->sendMessage("18456031508", "Mensagem de teste 2")
    ->sendMessage("18456031508", "Mensagem de teste 3")
    ->sendMessage("18456031508", "Mensagem de teste 4")
    ->sendMessage("18456031508", "Mensagem de teste 5")
    ->sendMessage("18456031508", "Mensagem de teste 6")
->close();
