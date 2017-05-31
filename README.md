# API Silex Skeleton

Skeleton using [Silex](http://silex.sensiolabs.org) and [Json Web Token](http://jwt.io) to create a RESTFull API

## Install

With Docker and Composer installed in your system just run the following command on project root:

```bash
./bin/minion start

```

## Usage

### Postman

Import [Postman](api-silex-skeleton.postman_collection.json) Collection

### Minion (shell task manager)

Usage: ./bin/minion [OPTION]

```bash
Options:
   console         Initializes bash command line on PHP server
   start           Initializes development servers
   stop            Finish development servers
   restart         Force reboot of development servers
   destroy         Stop and remove containers, networks, images, and volumes
   help, -h        Display this help and exit
```

Or run `./bin/minion` without option and you will see this options:

1) Help     
2) Console  
3) Start
4) stop
5) Restart 
6) Destroy
7) Quit     

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

```shell
composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.
