# Nextras\ORM Query Objects

## Toc

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
    nextras.queryobjects: Contibutte\Nextras\Orm\QueryObject\DI\NextrasQueryObjectExtension
```

```php
use Contibutte\Nextras\Orm\QueryObject\QueryObjectManager;

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
