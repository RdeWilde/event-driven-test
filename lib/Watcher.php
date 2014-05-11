<?hh

class Watcher {
    protected Trigger   $trigger;
    protected Event     $event;
    
    
    public function __construct(Trigger<T> $trigger, Event<T> $event) {
        $this->trigger  = $trigger;
        $this->event    = $event;
    }
    
    
    public function getTrigger() : Trigger {
        return $this->trigger;
    }
    
    public function getEvent() : Event {
        return $this->event;
    }
}