<?hh

abstract class Event<T> { // Listener<T>?
    protected Vector<Listener<T>> $subscribers = Vector{};
    protected T $payload;
    
    public function getPayload() : T {
        return $this->payload;
    }
    
    public function subscribe(Listener<T> $listener) {
        $this->subscribers[] = $listener;
    }
 
    public function fire() {
        foreach ($this->subscribers as $listener) {
            $listener->notify(
                    $this->getPayload()
                );
        }
    }
}