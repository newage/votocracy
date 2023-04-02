# Service skeleton

### Logger in handler or middleware
All exceptions logging automatically with default error level ERROR
#### Write custom message to log
```php
$logger = $request->getAttribute(\Psr\Log\LoggerInterface::class);
$logger->log(\Psr\Log\LogLevel::INFO, 'message');
```
#### Write exceptions
* An exception MUST implement ProblemDetailsExceptionInterface
* An exception MUST implement one of interface from Core\Exception\\*ExceptionInterface for detecting correct logging level.
```php
throw RuntimeException::test('Test error message', ['income'=>'data']);
```
#### Set RequestId for logging from headers
```http request
X-Request-Id: 123
```

### Logging for error-handler
Error handler used to log PHP errors and intercept exceptions
Enable error handler logging in config file
```console
config/autoload/logging.global.php
```
```php
'error-handler' => [
    'writer' => Log\Writer\Stream::class,
    'parameters' => ['php://stderr'],
]
```

### Add debugging information to log in middleware/handler
If debug mode is enable debug messages will be add to log automatically.
```php
$logger = $request->getAttribute(\Psr\Log\LoggerInterface::class);
$logger->log(\Psr\Log\LogLevel::DEBUG, 'message');
```
Another way inject logger into constructor
```php
public function __construct(LoggerInterface $logger)
{
    $this->logger = $logger;
}

public function handle(ServerRequestInterface $request): ResponseInterface
{
    ...
    $this->logger->log(LogLevel::DEBUG, 'Test debug message', ['parameters' => 'data']);
    ...
}
```
Response API
```json
{
  "transaction": {
    "income": "data"
  },
  "title": "Example for test exception",
  "type": "https://example.com/api/doc/test-exception",
  "status": 500,
  "detail": "Test error message"
}
```
Response to log
```json
{
  "timestamp":"2021-04-25T11:41:24+00:00",
  "priority":3,
  "priorityName":"ERR",
  "message":"Test error message",
  "extra":{
    "transaction":{
      "income":"data"
    },
    "status":600,
    "detail":"Test error message",
    "title":"Example for test exception",
    "type":"https://example.com/api/doc/test-exception",
    "referenceId":123
  }
}
```

#### Enable/Disable debugging from header
Debugging can enable only from header X-Debugging
```http request
X-Debugging: on
```

### HealthChecks for prometheus
```
/metrics
```

### API documentation
Using swagger
```http request
/api/swagger/
```
Swagger OpenAPI config
```
./swagger/swagger.yml
```
Deploy or update documentation
```
composer swagger:deploy
```

### Routes for testing
Logging
```http request
/test/logging
```
Debugging
```http request
/test/debugging
```
REST HAL User's entity response with nested Application's collection
```http request
/test/api/user/1
```

### Code analysis
One command for all analysis
```bash
composer analyse
```
Separate analysis
```bash
composer test:cs
```
```bash
composer test:loc
```
```bash
composer test:static-analysis
```
Fix code style
```bash
composer fix:cs
```

### Unit testing
Run all tests with testsuite Unit and Integration
```bash
composer test
```
Separate commands
```bash
composer test:unit
```
```bash
composer test:api
```