<?hh // strict

class EventBus {
    public static double $LOOP_TIMEOUT  = 0.1; // TODO Replace with MIN_LOOP_TIME
    public static double $MAX_LOOP_TIME = 15;
    
    protected   Map<string, Event>              $events         = Map{}; // Or make Event alias method on Event itself. Less configurable..
    protected   Vector<Watcher>                 $watchers       = Vector{};
    protected   bool                            $finished       = false;
    
    
    public function __construct() {
        $this->register('start',    new StartEvent($this));
        $this->register('end',      new EndEvent($this));
        $this->register('timeout',  new TimeoutEvent($this));
        
        parent::onStart(function($bus) { 
            $bus->watch(new TimeoutTrigger(5.0), 'timeout'); // TODO event aliassing usable without loosing type checking
        });
    }
    
    
    public function onStart((function(EventBus) : bool) $callable) { // TODO typechecking
        return $this->subscribe('start', new Listener($callable));
    }
    
    public function onEnd((function(EventBus) : bool) $callable) { // TODO typechecking
        return $this->subscribe('end', new Listener($callable));
    }
    
    
    public function onTimeout((function(EventBus) : bool) $callable) {
        return parent::subscribe('timeout', new Listener<EventBus>($callable));
    }
    
    public function watch(Trigger $trigger, string $alias) { // Require Event-object because of Generic typ checking
        $event = $this->events->get($alias);
        
        if ($event !== null) {
            $watcher = new Watcher($trigger, $event);
            $this->watchers[] = $watcher;
        
            return $watcher;
        }
    }
    
    
    public function register(string $alias, Event $event) {
        // TODO check for existing alias
        
        $this->events[$alias] = $event; 
    }
    
    
    protected function subscribe(string $alias, Listener $listener) { // Event $event
        $event = $this->events->get($alias);

        if ($event !== null) {
            return $event->subscribe($listener);
        }
    }
    
    
    public function fire($alias) {
        $event = $this->events->get($alias);
        
        if ($event !== null) {
            $event->fire();
        }
    }
    
    
    protected function getWatchersByTrigger(Trigger $trigger) : Vector<Watcher> {
        return $this->watchers->filter(function($watcher) use ($trigger) {
            return $watcher->getTrigger() === $trigger;
        });
    }
    
    
    public function start() {
        //foreach ($this->events as $event) {
        //    $event->confirm();
        //}
        
        return $this->loop();
    }
    
    
    public function loop() {
        $start = microtime(true);
        
        $startEvent = $this->events->get('start')->fire();
        
        while (!$this->isFinished()) {
            foreach ($this->watchers as $watcher) {
                $trigger = $watcher->getTrigger();
                if ($trigger->evaluate()) {
                    foreach ($this->getWatchersByTrigger($trigger) as $watcher) {
                        $watcher->getEvent()->fire();
                    }
                }
            }
            
            if (microtime(true) - $start > static::$MAX_LOOP_TIME) {
                $this->end();
            }
            
            // Hold your breath ...
            sleep(static::$LOOP_TIMEOUT);
        }
        
        $endEvent = $this->events->get('end')->fire();
        
        return $this->end();
    }
    
    
    public function end() {
        //foreach ($this->events as $event) {
        //    $event->cancel();
        //}
        
        $this->finished = true;
        
        return true;
    }
    
    public function isFinished() {
        return $this->finished;
    }
}