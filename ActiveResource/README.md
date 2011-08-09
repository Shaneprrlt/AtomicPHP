#AtomicPHP ActiveResource#

AtomicPHP ActiveResource is the implementation of basic Object-Relational Mapping of RESTful data. It works similarly to ActiveRecord except instead of interacting with a database, it interacts with RESTful data.

CRUD methods are broken down into GET POST PUT DELETE HTTP requests. When you create an object, you use HTTP POST. When you read an object, you use HTTP GET. When you update an object, you use HTTP PUT. And when you delete an object, you use HTTP DELETE.

Heres an example of CRUD using ActiveResource.

```php
class UserResource extends ActiveResource {

	var $site = "http://example.com/users";
}

// Create Record
$user = UserResource::create();
$user->name = "John Doe";
$user->email = "j.doe@example.com";
$user->save();

// Read Record
$user = UserResource::find(1);
echo $user->name; // echos "John Doe";

// Update Record
$user = UserResource::find(1);
$user->email = "john.doe@newsite.com";
$user->save();

// Delete Record
$user = UserResource::find(1)->delete();
```