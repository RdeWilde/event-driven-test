<?hh

class ResponseEvent extends Event<HttpResponse> {
    public function __construct(HttpResponse $response) {
        $this->payload = $response;
    }
}