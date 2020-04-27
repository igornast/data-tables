<?php


namespace Igornast\DataTables\Service;


use Defuse\Crypto\Crypto;
use Defuse\Crypto\Exception\EnvironmentIsBrokenException;
use Defuse\Crypto\Exception\WrongKeyOrModifiedCiphertextException;

class DataTablesCryptoManager
{
    /**
     * @var string
     */
    private $appSecret;

    public function __construct(string $appSecret)
    {
        $this->appSecret = $appSecret;
    }

    /**
     * @param string $entityName
     * @return string
     * @throws EnvironmentIsBrokenException
     */
    public function encrypt(string $entityName): string
    {
        return Crypto::encryptWithPassword($entityName, $this->appSecret);
    }

    /**
     * @param string $entityName
     * @return string
     * @throws EnvironmentIsBrokenException
     * @throws WrongKeyOrModifiedCiphertextException
     */
    public function decrypt(string $entityName): string
    {
        return Crypto::decryptWithPassword($entityName, $this->appSecret);
    }
}