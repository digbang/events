<?php
namespace Digbang\Events;

trait EventedTrait
{
    /**
     * @type array
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
     * @return array
     */
    public function releaseEvents()
    {
        $events = $this->pendingEvents;
        $this->pendingEvents = [];

        return $events;
    }
}
