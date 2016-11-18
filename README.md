# Nextras\ORM QueryObjects

QueryObjects for Nextras\ORM.

-----

[![Build Status](https://img.shields.io/travis/minetro/nextras-orm-query-object.svg?style=flat-square)](https://travis-ci.org/minetro/nextras-orm-query-object)
[![Code coverage](https://img.shields.io/coveralls/minetro/nextras-orm-query-object.svg?style=flat-square)](https://coveralls.io/r/minetro/nextras-orm-query-object)
[![Downloads this Month](https://img.shields.io/packagist/dm/minetro/nextras-orm-query-object.svg?style=flat-square)](https://packagist.org/packages/minetro/nextras-orm-query-object)
[![Downloads total](https://img.shields.io/packagist/dt/minetro/nextras-orm-query-object.svg?style=flat-square)](https://packagist.org/packages/minetro/nextras-orm-query-object)
[![Latest stable](https://img.shields.io/packagist/v/minetro/nextras-orm-query-object.svg?style=flat-square)](https://packagist.org/packages/minetro/nextras-orm-query-object)
[![HHVM Status](https://img.shields.io/hhvm/minetro/nextras-orm-query-object.svg?style=flat-square)](http://hhvm.h4cc.de/package/minetro/nextras-orm-query-object)

## Discussion / Help

[![Join the chat](https://img.shields.io/gitter/room/minetro/nette.svg?style=flat-square)](https://gitter.im/minetro/nette?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)

## Install

```sh
composer require minetro/nextras-orm-query-object
```

## Usage

### Simple Query Object

```php

final class SimpleQueryObject extends QueryObject
{

    /**
     * @param QueryBuilder $builder
     * @return QueryBuilder
     */
    public function doQuery(QueryBuilder $builder)
    {
        return $builder->select('*')->from('foobar');
    }

}
```

```php
$qo = new SimpleQueryObject();
$qom = new QueryObjectManager();
$result = $qom->fetch($qo);
```

### Full Query Object

```php

final class FullQueryObject extends QueryObject
{

    /**
     * @param QueryBuilder $builder
     * @return QueryBuilder
     */
    public function doQuery(QueryBuilder $builder)
    {
        return $builder->select('*')->from('foobar');
    }
    
    /**
     * @param QueryBuilder $builder
     * @return QueryBuilder
     */
    protected function postQuery(QueryBuilder $builder)
    {
        return $builder;
    }

}
```

```php
$qo = new FullQueryObject();
$qom = new QueryObjectManager();
$result = $qom->fetch($qo);
```

### Executable Query Object

```php

final class SimpleExecutableQueryObject extends ExecutableQueryObject
{

    /**
     * @param QueryBuilder $builder
     * @return QueryBuilder
     */
    public function doQuery(QueryBuilder $builder)
    {
        return $builder->select('*')->from('foobar');
    }

    /**
     * @param Result $result
     * @return Result
     */
    protected function postResult(Result $result)
    {
        return $result;
    }

}
```

```php
$qo = new SimpleExecutableQueryObject($connection);
$result = $qo->execute();
```

### Query Object Manager

You can register your own `QueryObjectManager` or setup via extension.

```yaml
extensions:
    nextrasqueryobject: Minetro\Nextras\Orm\QueryObject\DI\NextrasQueryObjectExtension
```

```php
use Minetro\Nextras\Orm\QueryObject\QueryObjectManager;

final class MyFacade1
{

    /** @var QueryObjectManager **/
    private $qom;

    public function foo()
    {
        $qo = $this->qom->create(MyExtraQueryObject::class);
        $qo->setBar(1);
        $qo->setBaz(TRUE);
        $result = $this->qom->fetch($qo);
    }

}
```

```php
final class MyFacade2
{

    /** @var IMyQueryObjectFactory @inject **/
    public $myQueryObjectFactory;

    public function foobar()
    {
        $qo = $this->myQueryObjectFactory->create(1, TRUE);
        $result = $this->qom->fetch($qo);
    }

}
```

-----

Thanks for testing, reporting and contributing.
