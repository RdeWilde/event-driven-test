<?hh

class HttpEventBus extends EventBus {
    public function __construct() {
        parent::__construct();
        
        parent::register('request', new RequestEvent());
        parent::register('response', new ResponseEvent());
        parent::register('timeout', new TimeoutEvent());
        
        $request    = new HttpRequest(fopen('php://input', 'r'));
        $response   = new HttpResponse(fopen('php://output', 'a'));
        
        parent::onStart(function($bus) use ($request, $response) {
            $bus->watch(new TimeoutTrigger(5), new TimeoutEvent()); // TODO event aliassing usable without loosing type checking
        });
    }
    
    public function onRequest(callable $callable) : Subscription { // Should be (function(HttpRequest) but gives compilation error TODO
        return parent::subscribe('request', new Listener($callable));
    }
    
    public function onResponse(callable $callable) : Subscription { // Should be (function(HttpResponse but gives compilation error TODO
        return parent::subscribe('response', new Listener($callable));
    }
    
    public function onTimeout(callable $callable) : Subscription { // TODO
        return parent::subscribe('timeout', new Listener($callable));
    }
}