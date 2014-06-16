<?hh

class HttpEventBus extends EventBus implements RouteAble, RequestAble, ResponseAble {
    public function __construct() {
        parent::__construct();
        
        $request    = new HttpRequest(fopen('php://input', 'r'));
        $response   = new HttpResponse(fopen('php://output', 'a'));
        
        RequestEvent::observe($this);
        ResponseEvent::observe($this);
        
        parent::onStart()->subscribe(function($bus) use ($request) {
            $bus->onRequest()->fire($request);
        });
        
        parent::onEnd()->subscribe(function($bus) use ($response) {
            $bus->onResponse()->fire($response);
        })
    }
    
    public function onRequest() : RequestEvent {
        return RequestEvent::instance($this);
    }
    
    public function onResponse() : ResponseEvent {
        return RequestEvent::instance($this);
    }
}