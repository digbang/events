<?php namespace Tests;

class EventedTraitTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_should_accumulate_events_and_then_release_them()
    {
        $someEntity = new Classes\SomeEntity();

        $someEntity->shouldRaiseAnEvent();
        $someEntity->shouldRaiseAnEvent();
        $someEntity->shouldntRaiseAnEvent();

        $events = $someEntity->releaseEvents();

        $this->assertCount(2, $events);
        $this->assertCount(0, $someEntity->releaseEvents());
	}
}
