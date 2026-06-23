![](https://heatbadger.now.sh/github/readme/contributte/nextras-orm-query-object/)

<p align=center>
  <a href="https://github.com/contributte/nextras-orm-query-object/actions"><img src="https://badgen.net/github/checks/contributte/nextras-orm-query-object/master?cache=300"></a>
  <a href="https://coveralls.io/r/contributte/nextras-orm-query-object"><img src="https://badgen.net/coveralls/c/github/contributte/nextras-orm-query-object?cache=300"></a>
  <a href="https://packagist.org/packages/contributte/nextras-orm-query-object"><img src="https://badgen.net/packagist/dm/contributte/nextras-orm-query-object"></a>
  <a href="https://packagist.org/packages/contributte/nextras-orm-query-object"><img src="https://badgen.net/packagist/v/contributte/nextras-orm-query-object"></a>
</p>
<p align=center>
  <a href="https://packagist.org/packages/contributte/nextras-orm-query-object"><img src="https://badgen.net/packagist/php/contributte/nextras-orm-query-object"></a>
  <a href="https://github.com/contributte/nextras-orm-query-object"><img src="https://badgen.net/github/license/contributte/nextras-orm-query-object"></a>
  <a href="https://bit.ly/ctteg"><img src="https://badgen.net/badge/support/gitter/cyan"></a>
  <a href="https://bit.ly/cttfo"><img src="https://badgen.net/badge/support/forum/yellow"></a>
  <a href="https://contributte.org/partners.html"><img src="https://badgen.net/badge/sponsor/donations/F96854"></a>
</p>

<p align=center>
Website 🚀 <a href="https://contributte.org">contributte.org</a> | Contact 👨🏻‍💻 <a href="https://f3l1x.io">f3l1x.io</a> | Twitter 🐦 <a href="https://twitter.com/contributte">@contributte</a>
</p>

Query object helpers for Nextras ORM applications, including reusable query objects, executable query objects and a Nette DI manager.

## Versions

| State       | Version | Branch   | Nette | PHP     |
|-------------|---------|----------|-------|---------|
| dev         | `^0.7`  | `master` | 3.2+  | `>=8.2` |
| stable      | `^0.6`  | `master` | 3.2+  | `>=8.2` |

## Installation

To install latest version of `contributte/nextras-orm-query-object` use [Composer](https://getcomposer.org).

```bash
composer require contributte/nextras-orm-query-object
```

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

You can register your own `QueryObjectManager` or set it up via extension.

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

## Development

See [how to contribute](https://contributte.org) to this package. This package is currently maintained by these authors.

<a href="https://github.com/f3l1x">
    <img width="80" height="80" src="https://avatars2.githubusercontent.com/u/538058?v=3&s=80">
</a>

-----

Consider to [support](https://contributte.org/partners) **contributte** development team.
Also thank you for using this package.
