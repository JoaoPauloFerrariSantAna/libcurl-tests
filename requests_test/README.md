# Sending multiple requests

This directory is meant as to test sending POST and GET
requests with libcurl.

## The ideia behind

The ideia was to send information (username and password) to an dictionary
to simulate a database: I know of SQLite, but its way to much code
to use in a test that isn't even about database or sqlite, even.

I've focused on using some other more recent PHP features (namely namespaces)

I could have used Composer's autoload, but i prefer to do things the hard way :v

## Tools used

- Python (backend)
	- Flask (as the backend)
- PHP ("frontend")
	- libcurl

# Runnig the test

To run just follow the steps:

1. Go to the source dir

```SHELL> cd src/```

2. Have Flask installed

```SHELL> pip install flask```

3. Have libcurl installed

4. Run the server

```SHELL> flask --app private/server run```

5. Run the client

```php src/public/client.php```
