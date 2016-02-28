<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 2/28/2016
 * Time: 12:52 PM
 */

namespace TSetliff\WebAppFramework;


class Response
{
    private $errors = [];
    private $messages = [];
    /**
     * @var TemplateWrapper
     */
    private $templateWrapper;

    /**
     * Response constructor.
     * @param TemplateWrapper|null $templateWrapper
     */
    public function __construct(TemplateWrapper $templateWrapper = null)
    {
        if (isset($_REQUEST['errors'])) {
            foreach ($_REQUEST['errors'] as $errorMsg) {
                $this->addError($errorMsg);
            }
        }
        $this->templateWrapper = $templateWrapper;
    }

    public function hasErrors()
    {
        return count($this->errors) > 0;
    }

    public function addError($msg)
    {
        $this->errors[] = $msg;
    }

    public function addHappyMessage($msg)
    {
        $this->messages[] = $msg;
    }

    /**
     * Add the results of a rendered twig template to the output
     *
     * @param $template
     * @param array $params
     */
    public function returnTemplate($template, $params = []) {
        $params['lastRequest'] = $_REQUEST;
        $params['errors'] = $this->errors;
        $params['messages'] = $this->messages;

        echo((new TwigWrapper())->render($template, $params));
        exit(0);
    }

    /**
     * @param string $path
     */
    public function redirect($path = '')
    {
        $errors = '';
        // Allow errors to be passed through redirect for things like expiring account
        if (count($this->errors)) {
            $errors = http_build_query(['errors' => $this->errors]);
        }

        $messages = '';
        // Allow messages to be passed through redirect for things like account successfully created
        if (count($this->messages)) {
            $messages = http_build_query(['messages' => $this->messages]);
        }

        $queryIndicator = ($errors || $messages) ? '?' : '';

        header("Location: https://{$_SERVER['HTTP_HOST']}$path$queryIndicator$errors$messages");
        exit(0);
    }

    public function returnJson($out = [])
    {
        $out['errors'] = $this->errors;
        $out['messages'] = $this->messages;
        echo(json_encode($out));
        header('Content-Type: application/json');
        exit(0);
    }
}