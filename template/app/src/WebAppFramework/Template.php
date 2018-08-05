<?php
/**
 * User: Tom2017 Date: 8/5/2018 Time: 4:34 AM
 */

namespace WebAppFramework;


class Template
{
    private $phpTemplateFile;

    /**
     * Note that these can be accessed from the template in the case that you need the raw data.
     *
     * @var array
     */
    protected $rawVariables = [];

    public function __construct($phpTemplateFile)
    {
        $this->phpTemplateFile = $phpTemplateFile;
    }

    public function setVariable($name, $value)
    {
        $this->rawVariables[$name] = $value;
    }

    /**
     * Helper method that can be called from within templates so I can use absolute paths for everything
     *
     * @param $templateFileName
     */
    public function insertTemplate($templateFileName)
    {
        require(APP_LOCATION . '/templates/' . $templateFileName);
    }

    public function render()
    {
        // Add normal escaped variables to the template
        foreach ($this->rawVariables as $name => $value) {
            // Yes I want to explode out the variables here by name
            $$name = htmlentities($value);
        }

        require(APP_LOCATION . '/templates/' . $this->phpTemplateFile);
    }
}