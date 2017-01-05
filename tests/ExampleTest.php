<?php


class ExampleTest extends TestCase
{
    public function setUp()
    {
        $this->markTestSkipped('temporarily disable.');

    }

    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        $this->visit('/')
             ->see('Laravel 5');
    }
}
