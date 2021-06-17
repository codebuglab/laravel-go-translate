<?php

namespace CodeBugLab\GoTranslate\Prepare;

class TextPreparation
{
    public string $text;

    private string $htmlEntity = "\&\w+\;";
    private string $laravelVariable = ":\w+";
    private string $stringSpecifier = "%s";
    private array $specialCharacterArray = [];
    private array $hashedArray = ["-1-", "-2-", "-3-", "-4-", "-5-", "-6-", "-7-", "-8-", "-9-", "-10-"];

    public function __construct(string $text) {
        $this->text = $text;
    }

    /**
    * Prepare function that will call before translation
    */
    public function prepareBeforeTranslate() {
        $this->textWithUnderscore();
        $this->saveSpecialContent();
    }

    /**
    * Prepare function that will call after translation
    */
    public function prepareAfterTranslate() {
        $this->returnSpecialContent();
        return $this->text;
    }

    /**
    * Replace every underscore in the text with space
    */
    private function textWithUnderscore() {
        $this->text = str_replace("_", " ", $this->text);
    }

    /**
    * If there is special character in the text save them in special character array
    * preg_replace_all
    * str_replace callback
    */
    private function saveSpecialContent() {
        if (preg_match_all("/($this->htmlEntity)|($this->laravelVariable)|($this->stringSpecifier)/", $this->text, $this->specialCharacterArray) > 0) {
            $this->text = str_replace($this->specialCharacterArray[0], $this->hashedArray, $this->text);
        }
    }

    /**
    * Return all special characters to the text
    */
    private function returnSpecialContent() {
        $this->text = str_replace($this->hashedArray, $this->specialCharacterArray[0], $this->text);
    }
}
