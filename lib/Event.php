<?hh

abstract class Event<T> {
    protected   EventBus        $bus;
    protected   Vector<Trigger> $triggers;
 
    public function __construct(EventBus $bus) {
        $this->bus = $bus;
    }
 
    abstract public function fire(Listener $listener, T $payload);
}