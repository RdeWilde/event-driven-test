<?hh

require 'vendor/autoload.php';
require 'lib/.autoload.php';


$bus = new HttpEventBus();


$bus->onTimeout(function(EventBus $bus) {
    echo 'Timeout!';

    $bus->end();
});


$bus->onRequest(function(HttpRequest $request) {
    echo "Call controller";
});

    
$bus->onResponse(function(HttpResponse $response) use ($bus) {
    echo "Wrote to response..";
    
    $bus->end();
});


$bus->start();


print 
    <html>
        <head>
            <title>XHP test page</title>
            <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" media="screen" rel="stylesheet" />
            <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js" />
        </head>
        <body>
            <bs:page-header>Test page</bs:page-header>
            <bs:button size="sm" block={true}>
                <bs:image responsive={true} shape="thumbnail" />
                <bs:glyphicon icon="star" />
            </bs:button>
            
            <bs:dropdown>
                <bs:dropdown-header>Header</bs:dropdown-header>
                <bs:dropdown-item disabled={true}>{date('Y')}</bs:dropdown-item>
                <bs:dropdown-divider />
            </bs:dropdown>
        </body>
    </html>;
