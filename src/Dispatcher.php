<?php
namespace Digbang\Events;

use Illuminate\Contracts\Events\Dispatcher as LaravelDispatcher;

/**
 * Proxy of the laravel event dispatcher.
 * It delegates all methods other than 'fire' to Laravel's Dispatcher.
 *
 * @method listen(mixed $events, mixed $listener, int $priority = 0)
 * @method bool hasListeners(string $eventName)
 * @method void queue(string $event, array $payload = [])
 * @method subscribe(string $subscriber)
 * @method mixed until(string $event, array $payload = [])
 * @method flush(string $event)
 * @method string firing()
 * @method array getListeners(string $eventName)
 * @method mixed makeListener(mixed $listener)
 * @method \Closure createClassListener(mixed $listener)
 * @method forget(string $event)
 * @method forgetQueued()
*/
class Dispatcher
{
    /**
     *
     * @type LaravelDispatcher
     */
	private $laravelDispatcher;

    /**
     * @param LaravelDispatcher $laravelDispatcher
     */
    public function __construct(LaravelDispatcher $laravelDispatcher)
    {
        $this->laravelDispatcher = $laravelDispatcher;
    }

    /**
     * @param array $events
     */
    public function fire(array $events)
    {
        foreach ($events as $event)
        {
            $this->laravelDispatcher->fire(
                $this->parseEventName($event),
                $event
            );
        }
    }

    /**
     * @param mixed $event Should be an object or a string. If the object implements __toString,
     *                     the casted string will be used. Otherwise, the event classname will be
     *                     used.
     *
     * @return string
     * @throws \UnexpectedValueException when given event is not an object or a string.
     */
    private function parseEventName($event)
    {
        switch (true)
        {
            case is_object($event):
                if (method_exists($event, '__toString'))
                {
                    return (string) $event;
                }

                return get_class($event);
            case is_string($event):
                return $event;
        }

        throw new \UnexpectedValueException('Cannot parse event of type ' . gettype($event));
    }

    /**
     * @param string $name
     * @param array $arguments
     *
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return call_user_func_array([$this->laravelDispatcher, $name], $arguments);
    }
}
