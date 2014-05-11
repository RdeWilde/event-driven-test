<?hh

class ResponseEvent extends Event<HttpResponse> {
    public function fire(Listener $listener, HttpResponse $payload) {
        $listener->notify($payload);
    }
}