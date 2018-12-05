<?php

namespace BespokeSupport\SmartWaste;

/**
 * Class SmartWasteCredentials
 * @package BespokeSupport\SmartWaste
 */
class SmartWasteCredentials
{
    /**
     * @var string
     */
    public $private;
    /**
     * @var string
     */
    public $random;
    /**
     * @var string
     */
    public $public;
    /**
     * @var string|null
     */
    public $token;
    /**
     * @var string
     */
    public $user;

    /**
     * SmartWasteCredentials constructor.
     * @param string $user
     * @param string $keyPublic
     * @param string $keyPrivate
     * @param string|null $token
     */
    public function __construct(
        string $user,
        string $keyPublic,
        string $keyPrivate,
        string $token = null
    ) {
        if (!strlen($user)) {
            throw new \RuntimeException('User not valid');
        }

        $this->user = $user;
        $this->public = $keyPublic;
        $this->private = $keyPrivate;
        $this->token = $token;
    }

    /**
     * @return array
     */
    public function paramsForAuthentication(): array
    {
        $this->random = (string) mt_rand();

        $password = md5($this->random . $this->private);

        return [
            'token' => $this->random,
            'password' => $password,
        ];
    }
}
