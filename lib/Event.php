<?hh

class Event<T> { // Listener<T>?
    //protected   EventBus        $bus;
    //protected   Vector<Trigger> $triggers;
 
    //public function __construct(EventBus $bus) {
    //    $this->bus = $bus;
    //}
 
    public function fire(Listener<T> $listener, T $payload) {
        $listener->notify($payload);
    }
}