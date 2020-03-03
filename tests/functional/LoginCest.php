<?php


class LoginCest
{
    public function _before(FunctionalTester $I)
    {
        $I->runSqlQueries('functional/ipn_seed');
    }

    public function _after(FunctionalTester $I)
    {
    }

    public function tryToTest(FunctionalTester $I)
    {
    }
}
