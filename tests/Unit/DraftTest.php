<?php

namespace Tests\Unit;

use App\Draft;
use PHPUnit\Framework\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class DraftTest extends TestCase
{
    /**
     * Test if getKeyType() return 'string'
     *
     * @return void
     */
    public function test_key_type_is_string(){
        $draft = new Draft();
        $this->assertTrue($draft->getKeyType() === 'string');
    }
}
