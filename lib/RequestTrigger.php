<?hh

class RequestTrigger extends Trigger<HttpRequest> {
    public function __construct(HttpEventBus $bus) {
        $this->bus = $bus;
    }
    
    public function evaluate() {
        return false;
    }
    
    public function fire(Listener $listener, HttpRequest $payload) {
        return $this->bus->onRequest($payload);
    }
}