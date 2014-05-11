<?hh

class TimeoutEvent extends Event<EventBus> {
    public function __construct(EventBus $event) {
        $this->payload = $event;
    }
}