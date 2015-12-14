<?php
namespace Digbang\Events;

trait EventedTrait
{
    /**
     * @var string[]
     */
    protected $pendingEvents = [];

    /**
     * @param mixed $event
     */
    protected function raise($event)
    {
        $this->pendingEvents[] = $event;
    }

    /**
     * @return string[]
     */
    public function releaseEvents()
    {
        $events = $this->pendingEvents;
        $this->pendingEvents = [];

        return $events;
    }
}
