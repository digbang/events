<?php namespace Tests;

use Digbang\Events\Dispatcher;
use Illuminate\Events\Dispatcher as LaravelDispatcher;

class DispatcherTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_should_fire_an_array_of_events()
    {
        $dispatcherMock = $this
            ->getMockBuilder(LaravelDispatcher::class)
            ->disableOriginalConstructor()
            ->getMock();


        $dispatcherMock
            ->expects($this->exactly(4))
            ->method('fire')
            ->withConsecutive(
                [Classes\SomeEvent::class],
                [Classes\SomeEvent::class],
                ['some_event'],
                [Classes\SomeOtherEvent::NAME]
            );

        $dispatcher = new Dispatcher($dispatcherMock);

        $events = [
            new Classes\SomeEvent(),
            new Classes\SomeEvent(),
            'some_event',
            new Classes\SomeOtherEvent()
        ];

        $dispatcher->fire($events);
	}
}
