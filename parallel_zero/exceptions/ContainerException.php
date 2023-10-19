<?php

namespace ParallelZero\Exceptions;

class ContainerException extends \Exception
{
    /**
     * Custom message for ContainerException
     *
     * @var string
     */
    private $customMessage;

    /**
     * ContainerException constructor.
     *
     * @param string $message The Exception message to throw.
     * @param int $code The Exception code.
     * @param \Throwable|null $previous The previous throwable used for the exception chaining.
     */
    public function __construct($message = "", $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->customMessage = "This is a ContainerException: " . $message;
    }

    /**
     * Function to get custom message.
     *
     * @return string
     */
    public function getCustomMessage(): string
    {
        return $this->customMessage;
    }
}
