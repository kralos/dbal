<?php

namespace Doctrine\DBAL\Tests\Types;

use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;

class TimeTest extends BaseDateTypeTestCase
{
    protected function setUp(): void
    {
        $this->type = Type::getType('time');

        parent::setUp();
    }

    public function testTimeConvertsToPHPValue(): void
    {
        self::assertInstanceOf('DateTime', $this->type->convertToPHPValue('5:30:55', $this->platform));
    }

    public function testDateFieldResetInPHPValue(): void
    {
        $time = $this->type->convertToPHPValue('01:23:34', $this->platform);

        self::assertEquals('01:23:34', $time->format('H:i:s'));
        self::assertEquals('1970-01-01', $time->format('Y-m-d'));
    }

    public function testInvalidTimeFormatConversion(): void
    {
        $this->expectException(ConversionException::class);
        $this->type->convertToPHPValue('abcdefg', $this->platform);
    }
}
