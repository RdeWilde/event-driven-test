<?hh

class HttpEventBus extends EventBus {
    public function __construct() {
        $request    = new HttpRequest(fopen('php://input', 'r'));
        $response   = new HttpResponse(fopen('php://output', 'a'));
        
        parent::subscribe('start', new Listener(
            function($bus) use ($request, $response) {
                $bus->register('request', new RequestEvent());
                $bus->register('response', new ResponseEvent());
                
                $bus->watch(new TimeoutTrigger(60), function() use ($bus) {
                    $bus->end();
                });
            }
        ));
    }
    
    public function onRequest(callable $callable) : Subscription { // Should be (function(HttpRequest) but gives compilation error TODO
        return parent::subscribe('request', new Listener($callable));
    }
    
    public function onResponse(callable $callable) : Subscription { // Should be (function(HttpResponse but gives compilation error TODO
        return parent::subscribe('response', new Listener($callable));
    }
}