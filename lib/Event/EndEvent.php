<?hh

class EndEvent extends Event<EventBus> {
    public function __construct(EventBus $bus) {
        $this->payload = $bus;
    }
}