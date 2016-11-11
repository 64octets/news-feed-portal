## Install project ##

- Install libs

```bash
    composer install
    bower install
```

- Run project

```bash
    cp etc/app-conf.php.demo etc/app-conf.php
    cp etc/propel.php.demo etc/propel.php
```

*Inside propel.php change username and password on your*

```bash
    mysqladmin -uroot -ppassword create news_feed_db
    bash deploy/multi_propel_migrate up
    php -S localhost:8000 -t public/
```

Import RSS data to your local DB:

- By specific URL:

```bash
    php bin/syncFeed.php --url http://95.138.171.232/dmwd/showbiz-de/mrss.xml
    php bin/syncFeed.php -u http://95.138.171.232/dmwd/showbiz-de/mrss.xml
```
- Or direct from file

```bash
    php bin/syncFeed.php --file bin/mrss.xml
    php bin/syncFeed.php -f bin/mrss.xml
```

- Open 'http://localhost:8000' on your web browser



-----------------------------------------------------------------------


## Development level ##

- Create propel schema.xml (if not exists)

```bash
    php vendor/bin/propel database:reverse --output-dir deploy 'pgsql:host=<HOST>;dbname=<DBNAME>;user=<USER>;password=<PASS>'
```

- Add model namespase if need

Open schema.xml config and add namespace="<NAMESPACE>" attribute to the database tag

- Build model

```bash
    php vendor/bin/propel model:build --schema-dir ./deploy --output-dir ./lib --config-dir ./etc -vv
```

- Build sql schema from xml schema (if need)

```bash
    ./vendor/bin/propel sql:build --config-dir ./etc --schema-dir ./deploy
```

- Create migration file

```bash
    ./vendor/bin/propel diff --config-dir ./etc --schema-dir ./deploy
```

- Execute migration files

```bash
    ./vendor/bin/propel up --config-dir ./etc
```


***


## Run CodeSniffer ##

```bash
    php vendor/bin/phpcs --encoding=utf8
```

## Run JS CodeSniffer ##

```bash
    npm install
    npm test
```

## Run tests ##

```bash
    cp etc/app-conf.php.demo etc/app-conf.php
    cp tests/etc/propel.php.demo tests/etc/propel.php
```

*Inside propel.php change username and password on your*

```bash
    mysqladmin -uroot -ppassword create news_feed_db_test
    bash deploy/multi_propel_migrate up test
    php vendor/bin/phpunit
```


***


## Tests ##

1. Create config

```bash
    cp tests/etc/propel.php.demo tests/etc/propel.php
```

2. Create database (if need)

```bash
    mysql -u <USER> -p <PASSWORD> --host <HOST> -e 'create database <DBNAME>;'
```

3. Upgrade tables

```bash
    ./vendor/bin/propel up --config-dir ./tests/etc
```

4. Run tests

```bash
    ./vendor/bin/phpunit
```
