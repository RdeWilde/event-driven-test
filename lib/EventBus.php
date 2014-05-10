<?hh

class EventBus {
    protected   Vector<Trigger>         $triggers       = Vector{};
    protected   Vector<Subscription>    $subscriptions  = Vector{};
    protected   Map<string, Event>      $events         = Map{};
    protected   bool                    $finished       = false;
    
    
    public function watch(Trigger $trigger, Event $event) { // ??
        $this->triggers[] = $trigger;
    }
    
    
    public function register(string $alias, Event $event) {
        $this->events->add($alias, $event); 
    }
    
    
    public function subscribe(string $alias, Listener $listener) : ?Subscription { // Event $event
        $event = $this->events->get($alias);
        if ($event !== null) {
            $subscription = new Subscription($this, $event, $listener);
            $this->subscriptions[] = $subscription;
            
            return $subscription;
        }
    }
    
    
    public function start() {
        foreach ($this->subscriptions as $subscription) {
            $subscription->confirm();
        }
        
        return $this->loop();
    }
    
    
    public function loop() {
        $this->events->get('start')->fire($this);
        while ($this->isFinished()) {
            foreach ($this->triggers as $trigger) {
                $trigger->eval();
            }
        }
        $this->events->get('end')->fire($this);
        
        return $this->end();
    }
    
    
    public function end() {
        foreach ($this->subscriptions as $subscription) {
            $subscription->cancel();
        }
        
        $this->finished = true;
        
        return true;
    }
    
    public function isFinished() {
        return $this->finished;
    }
}