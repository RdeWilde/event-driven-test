<?hh

class RequestEvent extends Event<RequestAble> {
    public function __construct(RequestAble $request) {
        $this->payload = $request;
    }
}