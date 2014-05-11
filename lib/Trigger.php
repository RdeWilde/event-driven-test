<?hh

abstract class Trigger<T> {
    protected   EventBus        $bus;
    protected   Vector<Event<T>>   $events;
    
    public function addEvent(Event<T> $event) {
        $this->events[] = $event;
    }
    
    abstract public /*async*/ function evaluate() : bool;
}