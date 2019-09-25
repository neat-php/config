<?php

namespace Neat\Config\Test\Stubs;

class ConfigB
{
    /**
     * @var string
     */
    private $host;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var int
     */
    private $timeOut;

    public function __construct(string $host, string $username, string $password, int $timeOut = 30)
    {
        $this->host     = $host;
        $this->username = $username;
        $this->password = $password;
        $this->timeOut  = $timeOut;
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return int
     */
    public function getTimeOut(): int
    {
        return $this->timeOut;
    }
}
