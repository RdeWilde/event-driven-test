<?hh

class TimeoutEvent extends Event<?mixed> {
    public function fire(Listener $listener, ?mixed $payload) {
        $listener->notify($payload);
    }
}