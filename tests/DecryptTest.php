<?php

namespace TmrwLife\NtakGuru\Tests;

use TmrwLife\NtakGuru\Crypt;

class DecryptTest extends TestCase
{
    public function testItReturnsFalseIfTheDataIsNull(): void
    {
        $context = Crypt::decrypt(null);

        $this->assertFalse($context);
    }

    public function testItReturnsFalseIfDecryptFailed(): void
    {
        $encrypted = 'AMb70MRQ3Jr9AqEJzFt1qe+mrwLn03u8JW8KuxTxPExDE6vDyeL3aZFUudw8RzwYNRApZwmP3M';

        $context = Crypt::decrypt($encrypted);

        $this->assertFalse($context);
    }
}
