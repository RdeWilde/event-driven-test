<?hh

class TimeoutTrigger extends Trigger<?mixed> { // ?mixed should just be null or void, possible? TODO
    private double $start;
    private double $timeout;
    private double $end;
    
    public function __construct(double $timeout) {
        $this->start = microtime(true);
    }
    
    public async function evaluate() {
        return (microtime(true) - $this->start > $this->timeout);
    }
    
    public function fire(Listener $listener, ?mixed $payload) {
        
    }
}