<?hh

abstract class Trigger<T> {
    protected   EventBus        $bus;
    protected   Vector<Event>   $events;
    
    public function addEvent(Event $event) {
        $this->events[] = $event;
    }
    
    abstract public /*async*/ function evaluate();
    abstract public function fire(Listener $listener, T $payload); // Drop listener? TODO
}