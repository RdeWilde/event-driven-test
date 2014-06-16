<?hh

class RequestTrigger extends Trigger<RequestAble> {
    public function __construct(HttpEventBus $bus) {
        $this->bus = $bus;
    }
    
    public function evaluate() {
        return false;
    }
}