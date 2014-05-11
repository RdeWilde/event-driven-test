<?hh

class Listener<T> {
    private callable $callback;
    
    public function __consutruct(callable $callable) {
        $this->callback = $callable;
    }
    
    public function notify (T $payload) : bool {
        $this->callback($payload);
    }
}