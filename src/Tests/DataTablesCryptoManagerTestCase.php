<?php


namespace Igornast\DataTables\Tests;

use Igornast\DataTables\Service\DataTablesCryptoManager;
use PHPUnit\Framework\TestCase;

class DataTablesCryptoManagerTestCase extends TestCase
{
    const TEST_APP_SECRET = 'app_secret';
    const TEST_ENTITY_NAME = 'Igornast\DataTables\Entity\SimpleItem';

    public function testEncryptionDecryption()
    {
        $manager = new DataTablesCryptoManager(self::TEST_APP_SECRET);

        $result = $manager->encrypt(self::TEST_ENTITY_NAME);
        $this->assertNotSame(self::TEST_ENTITY_NAME, $result);

        $this->assertSame(self::TEST_ENTITY_NAME, $manager->decrypt($result));
    }
}