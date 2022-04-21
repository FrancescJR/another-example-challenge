# Prima assicurazioni random scripting

Trying to add some order on the scripting.
So it will be either via http request with Symfony or via a terminal command also via Symfony.

## Requirements

* Docker.
* PHP composer (Check dockerfile on how to install)

### Usage

Execute `composer install` and then `composer start` at the root of the project. Make sure you don't 
have anything already listening on port 8000.

To stop it execute `composer stop`. `Composer destroy` to remove all the 
docker images.

To execute tests do `bin/phpunit` or `composer tests` if the images are running.
