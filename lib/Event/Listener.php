<?hh

class Listener<T> {
    private callable $callback;
    
    public function __construct((function(T) : bool) $callable) { // TODO function(T $payload)
        $this->callback = $callable;
    }
    
    public function notify (T $payload) : bool {
        return call_user_func($this->callback, $payload);
    }
}