<?php

namespace LaraCall\Domain\Factories;

use LaraCall\Domain\ValueObjects\PaymentStatus;
use TestCase;

class PaymentStatusFactoryTest extends TestCase
{
    /** @var PaymentStatusFactory */
    private $factory;

    protected function setUp()
    {
        parent::setUp();

        $this->factory = new PaymentStatusFactory();
    }

    /**
     * @dataProvider validStatusProvider
     *
     * @param string $status
     */
    public function test_createFromString_can_create_from_valid_string(string $status)
    {
        $statusVo = $this->factory->createFromString($status);

        $this->assertInstanceOf(PaymentStatus::class, $statusVo);
        $this->assertEquals($status, $statusVo->getStatus());
    }

    /**
     * @expectedException \UnexpectedValueException
     */
    public function test_createFromString_will_throw_exception_with_invalid_string()
    {
        $this->factory->createFromString('invalid');
    }

    /**
     * @expectedException \UnexpectedValueException
     */
    public function test_createFromArray_will_throw_exception_on_missing_key()
    {
        $data = [
            'nothing_relevant' => 'value',
        ];

        $this->factory->createFromArray($data);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function test_createFromArray_will_throw_exception_on_invalid_value()
    {
        $data = [
            'payment_status' => 123,
        ];

        $this->factory->createFromArray($data);
    }

    public function test_createFromArray_can_create_if_data_valid()
    {
        $data = [
            'payment_status' => PaymentStatus::STATUS_CANCEL_REVERSED,
        ];

        $status = $this->factory->createFromArray($data);

        $this->assertEquals(PaymentStatus::STATUS_CANCEL_REVERSED, $status->getStatus());
    }

    /**
     * @return array
     */
    public function validStatusProvider(): array
    {
        return [
            [PaymentStatus::STATUS_COMPLETED],
            [PaymentStatus::STATUS_PENDING],
            [PaymentStatus::STATUS_CANCEL_REVERSED],
            [PaymentStatus::STATUS_REVERSED],
            [PaymentStatus::STATUS_REFUNDED],
            [PaymentStatus::STATUS_FAILED],
        ];
    }
}

