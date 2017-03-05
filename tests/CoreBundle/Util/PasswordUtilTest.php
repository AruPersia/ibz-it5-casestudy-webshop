<?php

namespace Tests\CoreBundle\Util;

use CoreBundle\Util\PasswordHashDoesNotMatchException;
use CoreBundle\Util\PasswordUtil;

class PasswordUtilTest extends \PHPUnit_Framework_TestCase
{

    public function testEncryptPassword()
    {
        // given
        $pw = '123';

        // when
        $encrypted = PasswordUtil::encrypt($pw);

        // then
        PasswordUtil::verify($pw, $encrypted);
        $this->assertEquals(60, strlen($encrypted));
    }

    public function testEncryptLongPassword()
    {
        // given
        $pw = '48sZ41&01jm%O93s632yr&!r66pj3Z89u^0WZ9e97!8B16h2935V8UEu&G&5';

        // when
        $encrypted = PasswordUtil::encrypt($pw);

        //
        PasswordUtil::verify($pw, $encrypted);
        $this->assertEquals(60, strlen($encrypted));
    }

    public function testWrongPasswordShouldThrowAnException()
    {
        // given
        $pw = '123';
        $encrypted = PasswordUtil::encrypt($pw);

        // then
        $this->expectException(PasswordHashDoesNotMatchException::class);
        $this->expectExceptionMessage('Password hash does not match');

        // when
        PasswordUtil::verify('1234', $encrypted);
    }

    public function testEncryptEmptyPassword()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Validated object is empty!');
        PasswordUtil::encrypt('');
    }

}