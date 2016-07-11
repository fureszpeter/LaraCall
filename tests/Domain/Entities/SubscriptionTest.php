<?php

use Carbon\Carbon;
use LaraCall\Domain\Entities\Subscription;
use LaraCall\Domain\Entities\User;
use LaraCall\Domain\ValueObjects\Pin;

class SubscriptionTest extends TestCase
{
    const MOCK_DATE_FORMAT = 'Y-m-d H:i:s';
    const MOCK_DATE = '2010-01-01 1:00:00';

    protected function setUp()
    {
        parent::setUp();

        Carbon::setTestNow(Carbon::createFromFormat(self::MOCK_DATE_FORMAT, self::MOCK_DATE));
    }

    public function testJsonSerialize()
    {
        $mockUser = $this->getMockBuilder(User::class)->disableOriginalConstructor()->getMock();
        $pin = new Pin('1234567890');

        $subscription = new Subscription($mockUser, $pin);

        $expectedJsonArray = [
            'expiration_date' => Carbon::createFromFormat(self::MOCK_DATE_FORMAT, self::MOCK_DATE)->addYear(1),
            'last_refill_date' => null,
            'last_refill_amount' => null,
            'created_at' => Carbon::createFromFormat(self::MOCK_DATE_FORMAT, self::MOCK_DATE),
            'updated_at' => Carbon::createFromFormat(self::MOCK_DATE_FORMAT, self::MOCK_DATE),
            'pin' => '1234567890',
            'subscription_creation_date' => Carbon::createFromFormat(self::MOCK_DATE_FORMAT, self::MOCK_DATE),
        ];
        $this->assertJsonStringEqualsJsonString(json_encode($expectedJsonArray), json_encode($subscription));
    }

    public function testEqualsReturnsTrueIfEquals()
    {
        $mockUser = $this->getMockBuilder(User::class)->disableOriginalConstructor()->getMock();
        $pin = new Pin('1234567890');

        $subscription1 = new Subscription($mockUser, $pin);
        $subscription2 = new Subscription($mockUser, $pin);

        $this->assertTrue($subscription1->equals($subscription2));
    }

    public function testEqualsReturnsFalseIfNotEquals()
    {
        $mockUser = $this->getMockBuilder(User::class)->disableOriginalConstructor()->getMock();
        $pin = new Pin('1234567890');
        $pin2 = new Pin('2345678901');

        $subscription1 = new Subscription($mockUser, $pin);
        $subscription2 = new Subscription($mockUser, $pin2);

        $this->assertFalse($subscription1->equals($subscription2));
    }

}

