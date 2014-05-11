<?hh

class RequestEvent extends Event<HttpRequest> {
    public function __construct(HttpRequest $request) {
        $this->payload = $request;
    }
}