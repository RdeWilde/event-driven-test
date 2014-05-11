<?hh

class HttpEventBus extends EventBus {
    public function __construct() {
        parent::__construct();
        
        $request    = new HttpRequest(fopen('php://input', 'r'));
        $response   = new HttpResponse(fopen('php://output', 'a'));
        
        parent::register('request',     new RequestEvent($request));
        parent::register('response',    new ResponseEvent($response));
        parent::register('timeout',     new TimeoutEvent($this));
        
        parent::onStart(function($bus) {
            $bus->watch(new TimeoutTrigger(5.0), 'timeout'); // TODO event aliassing usable without loosing type checking
            $bus->fire('request');
            $bus->fire('response');
        });
    }
    
    public function onRequest((function(HttpRequest) : bool) $callable) {
        return parent::subscribe('request', new Listener<HttpRequest>($callable));
    }
    
    public function onResponse((function(HttpResponse) : bool) $callable) {
        return parent::subscribe('response', new Listener<HttpResponse>($callable));
    }
    
    public function onTimeout((function(EventBus) : bool) $callable) {
        return parent::subscribe('timeout', new Listener<EventBus>($callable));
    }
}