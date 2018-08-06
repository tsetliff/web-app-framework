<?php
namespace WebAppFramework;

class Response {
    protected $errors = [];
    protected $messages = [];

    public function __construct()
    {
        if (isset($_REQUEST['errors'])) {
            foreach ($_REQUEST['errors'] as $errorMsg) {
                $this->addError($errorMsg);
            }
        }
    }

    public function hasErrors()
    {
        return count($this->errors) > 0;
    }

    public function addError($msg)
    {
        $this->errors[] = $msg;
    }

    public function addMessage($msg)
    {
        $this->messages[] = $msg;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * Return given content to output
     * @param string $content
     */
    public function returnContent($content) {
        echo($content);
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