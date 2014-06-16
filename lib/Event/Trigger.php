<?hh

abstract class Trigger<T extends EventAble> {
    protected   EventAble          $subject;
    protected   Vector<Event<T>>   $events;
    
    public function addEvent(Event<T> $event) {
        $this->events[] = $event;
    }
    
    abstract public /*async*/ function evaluate() : bool;
}