<?php

namespace Controller;

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Facebook\WebDriver\Exception\UnexpectedAlertOpenException;
use Facebook\WebDriver\Exception\ElementNotInteractableException;

class WhatsAppController {

    private RemoteWebDriver $webDriver;
    private string $sessionKey = "hiperesp_whatsapp_localstorage";

    public function __construct() {
        $this->webDriver = RemoteWebDriver::create('http://localhost:9515', DesiredCapabilities::chrome(), 5000);
        $this->webDriver->get("https://web.whatsapp.com");
    }
    public function auth(): void {

        # ESPERA O USUARIO FAZER LOGIN
        $this->webDriver->wait(100, 100)->until(WebDriverExpectedCondition::not(WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::cssSelector(".landing-title.VeVN5"))));
        # USUARIO FEZ O LOGIN
    }
    public function sendMessage(string $number, string $text): void {
        $url = "https://web.whatsapp.com/send?".http_build_query([
            "phone" => $number,
            "text" => $text
        ]);
        $this->webDriver->get($url);
        $this->webDriver->wait(100, 100)->until(WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::cssSelector("._1JNuk ._1U1xa")));
        sleep(1);
        $sendButton = $this->webDriver->findElement(WebDriverBy::cssSelector("._1JNuk ._1U1xa"));
        $sendButton->click();
        sleep(1);
    }
    public function sessionStart(): void {
        if(!session_id()) {
            session_start();
        }
        if(!@$_SESSION[$this->sessionKey]) {
            return;
        }
        $localStorage = unserialize($_SESSION[$this->sessionKey]);
        $script = "";
        foreach($localStorage as $localStorageItem) {
            $key = $localStorageItem["key"];
            $value = $localStorageItem["value"];
            $script.= 'localStorage.setItem('.json_encode($key).', '.json_encode($value).');';
        }
        $script.= "window.location.reload();";
        $this->webDriver->executeScript($script);
    }
    public function logout(): void {
        if(!session_id()) {
            return;
        }
        unset($_SESSION[$this->sessionKey]);
    }
    public function close(): void {
        sleep(1);
        if(!session_id()) {
            session_start();
        }
        $localStorage = @$this->webDriver->executeScript("return Object.entries(localStorage)");
        if($localStorage) {
            foreach($localStorage as &$localStorageItem) {
                $localStorageItem = [
                    "key" => $localStorageItem[0],
                    "value" => $localStorageItem[1],
                ];
            }
            $_SESSION[$this->sessionKey] = serialize($localStorage);
        }
        $this->webDriver->close();
    }
}