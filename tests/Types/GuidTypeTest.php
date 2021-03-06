<?php

namespace Doctrine\DBAL\Tests\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;
use Doctrine\DBAL\Types\Type;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class GuidTypeTest extends TestCase
{
    /** @var AbstractPlatform|MockObject */
    private $platform;

    /** @var GuidType */
    private $type;

    protected function setUp(): void
    {
        $this->platform = $this->createMock(AbstractPlatform::class);
        $this->type     = Type::getType('guid');
    }

    public function testConvertToPHPValue(): void
    {
        self::assertIsString($this->type->convertToPHPValue('foo', $this->platform));
        self::assertIsString($this->type->convertToPHPValue('', $this->platform));
    }

    public function testNullConversion(): void
    {
        self::assertNull($this->type->convertToPHPValue(null, $this->platform));
    }

    public function testNativeGuidSupport(): void
    {
        self::assertTrue($this->type->requiresSQLCommentHint($this->platform));

        $this->platform->expects(self::any())
             ->method('hasNativeGuidType')
             ->will(self::returnValue(true));

        self::assertFalse($this->type->requiresSQLCommentHint($this->platform));
    }
}
