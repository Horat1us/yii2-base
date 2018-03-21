<?php

namespace Horat1us\Yii\Console;

use Horat1us\Yii\Interfaces\ModelExceptionInterface;

use yii\helpers\Console;

class ErrorHandler extends \yii\console\ErrorHandler
{
    protected function renderException($exception)
    {
        parent::renderException($exception);

        $message = '';
        if ($exception instanceof ModelExceptionInterface) {
            $message .= $this->formatMessage("Errors: ");
            foreach ($exception->getModel()->errors as $attribute => $errors) {
                $message .= "\t$attribute\n";
                foreach ($errors as $error) {
                    $message .= "\t\t" . $this->formatMessage($error) . "\n";
                }
            }
        }

        if (PHP_SAPI === 'cli') {
            Console::stderr($message . "\n");
        } else {
            echo $message . "\n";
        }
    }
}
