<?hh

abstract class Trigger<T> {
    protected   EventBus $bus;
    
    abstract public /*async*/ function evaluate();
    abstract public function fire(Listener $listener, T $payload); // Drop listener? TODO
}