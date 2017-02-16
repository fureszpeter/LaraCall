<?php
namespace LaraCall\Infrastructure\Services;

use LaraCall\Domain\Services\PinGeneratorService;
use TestCase;

class SimplePinGeneratorServiceTest extends TestCase
{
    /**
     * @var PinGeneratorService
     */
    private $generator;

    protected function setUp()
    {
        parent::setUp();

        $this->generator = new SimplePinGeneratorService();
    }

    public function testGeneratePin()
    {
        $pin1 = $this->generator->generate();
        $pin2 = $this->generator->generate();

        $this->assertEquals(10, strlen($pin1));
        $this->assertEquals(10, strlen($pin2));
        $this->assertNotEquals($pin1, $pin2);
    }

    public function testGenerateAlias()
    {
        $alias1 = $this->generator->alias();
        $alias2 = $this->generator->alias();

        $this->assertEquals(15, strlen($alias1));
        $this->assertEquals(15, strlen($alias2));
        $this->assertNotEquals($alias1, $alias2);

    }
}

