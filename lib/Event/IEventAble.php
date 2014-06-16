<?hh

interface EventAble<TPayload> {
    public function fire(Listener $listener, TPayload $payload);/* {
        return $listener->onRequest($payload);
    }*/
}