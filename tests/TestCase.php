<?php

namespace Tests;

use Tests\ForeignKeys;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    /**
     * Boot the testing helper traits.
     *
     * @return array
     */
    protected function setUpTraits()
    {
        $uses = parent::setUpTraits();

        if (isset($uses[ForeignKeys::class])) {
            /* @var $this TestCase|ForeignKeys */
            $this->enableForeignKeys();
        }
    }
}
