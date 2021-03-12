# Nextras\ORM Query Objects

## Content

- [Usage - how use it](#usage)
	- [Simple Query Object](#simple-query-object)
	- [Full Query Object](#full-query-object)
	- [Executable Query Object](#executable-query-object)
	- [Query Object Manager](#query-object-manager)

## Usage

### Simple Query Object

```php
final class SimpleQueryObject extends QueryObject
{

	public function doQuery(QueryBuilder $builder)
	{
		return $builder->select('*')->from('foobar');
	}

}
```

```php
$qo = new SimpleQueryObject();
$qom = $container->getByType(QueryObjectManager::class);
$result = $qom->fetch($qo);
```

### Full Query Object

```php

final class FullQueryObject extends QueryObject
{

	public function doQuery(QueryBuilder $builder)
	{
		return $builder->select('*')->from('foobar');
	}

	protected function postQuery(QueryBuilder $builder)
	{
		return $builder;
	}

}
```

```php
$qo = new FullQueryObject();
$qom = $container->getByType(QueryObjectManager::class);
$result = $qom->fetch($qo);
```

### Executable Query Object

```php

final class SimpleExecutableQueryObject extends ExecutableQueryObject
{

	public function doQuery(QueryBuilder $builder)
	{
		return $builder->select('*')->from('foobar');
	}

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

```neon
extensions:
	nextras.queryobjects: Contributte\Nextras\Orm\QueryObject\DI\NextrasQueryObjectExtension
```

```php
use Contributte\Nextras\Orm\QueryObject\QueryObjectManager;

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
