<?hh

class EventBus {
    public static double $LOOP_TIMEOUT = 0.01; // TODO Replace with MIN_LOOP_TIME
    // TODO MAX_LOOP_TIME?
    
    protected   Map<string, Event>              $events         = Map{}; // Or make Event alias method on Event itself. Less configurable..
    protected   Vector<Trigger>                 $triggers       = Vector{};
    protected   Vector<Watcher>                 $watchers       = Vector{};
    protected   Vector<Subscription>            $subscriptions  = Vector{};
    protected   bool                            $finished       = false;
    
    
    public function __construct() {
        // TODO Check if constructor was called or singleton pattern?
        $this->register('start', new Event<EventBus>());
        $this->register('end', new Event<EventBus>());
    }
    
    
    public function onStart(callable $callable) { // TODO typechecking
        return $this->subscribe('end', new Listener($callable));
    }
    
    public function onEnd() { // TODO typechecking
        return $this->subscribe('start', new Listener($callable));
    }
    
    
    public function watch(Trigger<T> $trigger, Event<T> $event) { // Require Event-object because of Generic typ checking
        if (! $this->events->has($event)) {
            return;
        }
        
        $watchter = new Watcher($trigger, $event);
        $this->watchers[] = $watcher;
        
        return $watchers;
    }
    
    
    public function register(string $alias, Event $event) {
        // TODO check for existing alias
        
        $this->events[$alias] = $event; 
    }
    
    
    protected function subscribe(string $alias, Listener $listener) : ?Subscription { // Event $event
        $event = $this->events->get($alias);
        
        if ($event !== null) {
            $subscription = new Subscription($this, $event, $listener);
            $this->subscriptions[] = $subscription;
            
            return $subscription;
        }
    }
    
    
    protected function getWachtersByTrigger(Trigger $trigger) : Vector<Watcher> {
        return $this->watchers->filter(function($watcher) use ($trigger) {
            return $watcher->getTrigger() === $trigger;
        });
    }
    
    protected function getSubscribtionsByEvent($event) : Vector<Subscription> {
        return $this->subscriptions->filter(function($subscription) use ($event) {
            return $subscription->getEvent() === $event;
        });
    }
    
    
    public function start() {
        foreach ($this->subscriptions as $subscription) {
            $subscription->confirm();
        }
        
        return $this->loop();
    }
    
    
    public function loop() {
        
        $startEvent = $this->events->get('start');
        foreach ($this->subscriptions as $subscription) {
            if ($subscription->getEvent() === $startEvent) {
                $startEvent->fire($subscription. $this);
            }
        }
            
        
        while (!$this->isFinished()) {
            foreach ($this->triggers as $trigger) {
                if ($trigger->evaluate()) {
                    foreach ($this->getWatchersByTrigger($trigger) as $watcher) {
                        $event = $watcher->getEvent();
                        
                        foreach ($this->getSubscribtionsByEvent($event) as $subscription) {
                            $listener = $subscription->getListener();
                            
                            if ($listener !== null) {
                                $event->fire($listener);
                            }
                        }
                    }
                }
            }
            
            // Hold your breath ...
            sleep(static::$LOOP_TIMEOUT);
        }
        
        $endEvent = $this->events->get('end');
        foreach ($this->subscriptions as $subscription) {
            if ($subscription->getEvent() === $endEvent) {
                $endEvent->fire($subscription. $this);
            }
        }
        
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