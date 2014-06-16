<?hh

class Subscription {
    protected   EventBus    $bus;
    protected   Event       $event;
    protected   Listener    $listener;
    protected   bool        $persistent = false;
    
    public function __construct(EventBus $bus, Event $event, Listener $listener) {
        $this->bus          = $bus;
        $this->event        = $event;
        $this->listener     = $listener;
    }
    
    
    public function getListener() : Listener {
        return $this->listener;
    }
    
    public function getEvent() : Event {
        return $this->event;
    }
    
    public function isPersistent () : bool {
        return $this->persistent;
    }
    
    
    public function cancel() {
        // TODO Selfdestroy
    }
    
    public function confirm() {
        // Init for example
    }
}