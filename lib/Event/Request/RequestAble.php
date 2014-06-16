<?hh

interface RequestAble extends EventAble<HttpRequest> {
    public function onRequest() : RequestEvent;
}