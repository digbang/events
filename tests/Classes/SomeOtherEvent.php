<?php namespace Tests\Classes;

class SomeOtherEvent
{
    const NAME = 'foo.bar.baz';

	public function __toString()
    {
        return self::NAME;
    }
}
