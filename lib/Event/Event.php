<?hh

abstract class Event<TAble extends IEventAble, TCallback extends callable> { // Listener<T>?
    static protected Vector<Listener<TCallback>> $subscribers = Vector{};
    protected TAble $payload;
    
    
    static public function subscribe(TCallback $callback) {
        return $this->subscribers->add($callback);
    }
    
    
    static public function fire(TAble $subject, ITrigger $trigger) : this {
        $occurence = new static(); 
        $occurence->subject = $target;
        $occurence->created = $trigger->getCreated();
        
        foreach ($this->subscribers as $subscriber) {
            $subscriber->notify($occurence);
        }
        
        return $occurence;
    }
    
    
    public function getPayload() : TAble {
        return $this->payload;
    }
    
    
}

// Occurence -> Event -> Trigger?