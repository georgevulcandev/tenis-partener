<?php
declare(strict_types=1);

namespace TenisPartener\Domain\Common;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use TenisPartener\Domain\Model\Common\Level;

final class LevelTest extends TestCase
{

    /**
     * @test
     */
    public function it_can_be_created_from_int(): void
    {
        $level = Level::fromInt(5);
        self::assertEquals(5, $level->asInt());
    }

    /**
     * @test
     * @dataProvider invalidLevel
     * @param int $value
     */
    public function it_requires_a_min_level(int $value): void
    {
        $this->expectException(InvalidArgumentException::class);
        $level = Level::fromInt($value);
    }

    /**
     * @return array<string,array<int,string>>
     */
    public function invalidLevel(): array
    {
        return [
            'less than 4'  => [3],
            'greater than 9' => [10]
        ];
    }


}