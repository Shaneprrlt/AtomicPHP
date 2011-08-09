#AtomicPHP HTTP#

AtomicPHP HTTP is a library that makes it seamless to make external and internal HTTP requests, send HTTP headers in an object-oriented style, and integrate REST into your application very seamlessly and quickly.

Here's an example of a Request being made in AtomicPHP HTTP.

```php
// GET Request
$request = Request::create('http://example.com/user/1');
$data = $request->execute();

// POST Request
$request = Request::create('http://example.com/user/new')
			->method(Request::POST)
			->post(array("name" => "John Doe", "email" => "j.doe@example.com"))
			->execute();
				
// PUT Request
$request = Request::create('http://example.com/user/1')
			->method(Request::PUT)
			->body(json_encode(array("email" => "john.doe@newsite.com")))
			->execute();
			
// DELETE Request
$request = Request::create('http://example.com/user/1')
			->method(Request::DELETE)
			->execute();
```