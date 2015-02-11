# Digbang Events
Small set of tools to help develop event-oriented architectures.

## Usage
Use the `Digbang\Events\EventedTrait` in your `Entities`:

```php
namespace App\Domain\Entities;

use Digbang\Events\EventedTrait;

class Foo
{
    use EventedTrait;
}
```

Then, create some interesting events for your domain:

```php
namespace App\Domain\Events;

/**
 * Event objects are usually data transfer objects.
 */
class FooCreatedEvent
{
    private $foo;
    
    public function __construct(Foo $foo)
    {
        $this->foo = $foo;
    }
    
    public function getFoo()
    {
        return $this->foo;
    }
}
```


And raise them in your `Entities`:

```php
// in src/Domain/Entities/Foo.php
public function __construct(Bar $bar, $baz = null)
{
    $this->bar = $bar;
    $this->baz = $baz;
    
    $this->raise( new FooCreatedEvent($this) );
}

public function doSomeMagic()
{
    $this->doneMagic = true;
    
    $this->raise( new MagicWasDoneEvent() );
}
```

And finally, dispatch them in your `Services`:

```php 
namespace App\Domain\Services;

class FooService
{
    /** @type Digbang\Events\Dispatcher */
    private $events;
    
    public function startFooing(Bar $bar, $baz = null)
    {
        $foo = new Foo($bar, $baz);
        $this->repository->save($foo);
        
        $this->dispatcher->fire( $foo->releaseEvents() );
    }
}
```

All other logic can listen to your domain events to do extra stuff, like sending emails, saving a log
or even firing more events!