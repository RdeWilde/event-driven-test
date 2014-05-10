<?hh

class RequestEvent extends Event<HttpRequest> {
    public function fire(Listener $listener, HttpRequest $payload) {
        $listener->notify($payload);
    }
}