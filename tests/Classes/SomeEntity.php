<?php namespace Tests\Classes;

use Digbang\Events\EventedTrait;

class SomeEntity
{
	use EventedTrait;

    public function shouldRaiseAnEvent()
    {
        $this->raise( new SomeEvent );
    }

    public function shouldntRaiseAnEvent()
    {
        // Nothing to see... off you go...
    }
}
