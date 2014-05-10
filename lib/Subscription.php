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
    
    
    public function isPersistent () : bool {
        return $this->persistent;
    }
    
    
    public function cancel() {
        $this->__destruct();
    }
}