<?php
namespace TSetliff\WebAppFramework;


class PhpTemplateWrapper extends TemplateWrapper
{
    public function render($templateName, $params)
    {
        require($templateName);
    }
}