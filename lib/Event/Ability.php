<?hh

interface Ability<IEventAble> {
    public function subscribe(Listener<TCallback> $listener) {
        $this->subscribers[] = $listener;
    }
 
    public function fire() {
        foreach ($this->subscribers as $listener) {
            $listener->notify(
                    $this->getPayload()
                );
        }
    }
}