<?php

namespace CodeBugLab\GoTranslate\Prepare;

class TextPreparation
{
    /**
     * @var string
     */
    public $text;

    /**
     * @var string
     */
    private $htmlEntity = "\&\w+\;";

    /**
     * @var string
     */
    private $laravelVariable = ":\w+";

    /**
     * @var string
     */
    private $stringSpecifier = "%s";

    /**
     * @var array
     */
    private $specialCharacterArray = [];

    /**
     * @var array
     */
    private $hashedArray = ["-1-", "-2-", "-3-", "-4-", "-5-", "-6-", "-7-", "-8-", "-9-", "-10-"];

    public function __construct(string $text)
    {
        $this->text = $text;
    }

    /**
     * Prepare function that will call before translation
     */
    public function prepareBeforeTranslate(): void
    {
        $this->textWithUnderscore();
        $this->saveSpecialContent();
    }

    /**
     * Prepare function that will call after translation
     */
    public function prepareAfterTranslate(): string
    {
        $this->returnSpecialContent();
        return $this->text;
    }

    /**
     * Replace every underscore in the text with space
     */
    private function textWithUnderscore(): void
    {
        $this->text = str_replace("_", " ", $this->text);
    }

    /**
     * If there is special character in the text save them in special character array
     * preg_replace_all
     * str_replace callback
     */
    private function saveSpecialContent(): void
    {
        if (preg_match_all("/($this->htmlEntity)|($this->laravelVariable)|($this->stringSpecifier)/", $this->text, $this->specialCharacterArray) > 0) {
            $this->text = str_replace($this->specialCharacterArray[0], $this->hashedArray, $this->text);
        }
    }

    /**
     * Return all special characters to the text
     */
    private function returnSpecialContent(): void
    {
        $this->text = str_replace($this->hashedArray, $this->specialCharacterArray[0], $this->text);
    }
}
