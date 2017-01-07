<?php

namespace Tests\AppBundle\Util;

use AppBundle\Util\PasswordUtil;

class PasswordUtilTest extends \PHPUnit_Framework_TestCase
{

    public function testEncryptPassword()
    {
        // given
        $pw = '123456';

        // when
        $encrypted = PasswordUtil::encrypt($pw);

        // then
        $this->assertEquals('$2y$04$NT1xQDQ3NnVzai0jQDF5UONX4jxcQAwrkGeNF5urukf22t9EbPI9W', $encrypted);
        $this->assertEquals(60, strlen($encrypted));
    }

    public function testEncryptLongPassword()
    {
        // given
        $pw = '48sZ41&01jm%O93s632yr&!r66pj3Z89u^0WZ9e97!8B16h2935V8UEu&G&5';

        // when
        $encrypted = PasswordUtil::encrypt($pw);

        // then
        $this->assertEquals('$2y$04$NT1xQDQ3NnVzai0jQDF5UO.EoMXpcOaDFaHQbUQ0sNHT.CK1krg3K', $encrypted);
        $this->assertEquals(60, strlen($encrypted));
    }

    public function testEncryptEmptyPassword()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Validated object is empty!');
        PasswordUtil::encrypt('');
    }

}