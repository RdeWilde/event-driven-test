<?hh

class TimeoutTrigger extends Trigger<EventBus> { // ?mixed should just be null or void, possible? TODO
    private double $start;
    private double $timeout;
    private double $end;
    
    public function __construct(double $timeout) {
        $this->start = microtime(true);
    }
    
    public async function evaluate() : bool {
        return (microtime(true) - $this->start > $this->timeout);
    }
}