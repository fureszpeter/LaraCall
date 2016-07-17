<?php

namespace LaraCall\Domain\Services;

use LaraCall\Domain\ValueObjects\TransactionParseResult;

interface TransactionDataParser
{
    /**
     * @param mixed $data
     *
     * @return TransactionParseResult
     */
    public function parse($data);
}
