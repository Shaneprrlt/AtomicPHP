#AtomicPHP ActiveRecord#

AtomicPHP ActiveRecord is the implementation of basic Object-Relational Mapping of Relational Database tables to an Object-Oriented format. It includes a simple format of interacting with your database with basic CRUD methods.

Here's an example of how to create a new record into a table using ActiveRecord.

```php
$user = User::create();
$user->name = "John Doe";
$user->email = "j.doe@example.com";
$user->save();
```

How to read a record from a table using ActiveRecord.

```php
$user = User::find(1);
echo $user->name; // prints "John Doe"
```

How to update a record from a table using ActiveRecord.

```php
$user = User::find(1);
$user->email = "john.doe@newsite.com";
$user->save();
```

How to destroy a record from a table using ActiveRecord.

```php
$user = User::find(1)->delete();
```