# Router
[![Build Status](https://travis-ci.org/Theoduin/Router.svg?branch=master)](https://travis-ci.org/Theoduin/Router)
[![Lines of code](https://sonarqube.com/api/badges/measure?key=Theoduin:Router&metric=lines)](https://sonarqube.com/dashboard/index/Theoduin:Router)
[![Quality Gate](https://sonarqube.com/api/badges/gate?key=Theoduin:Router)](https://sonarqube.com/dashboard/index/Theoduin:Router)
[![Technical debt ratio](https://sonarqube.com/api/badges/measure?key=Theoduin:Router&metric=sqale_debt_ratio)](https://sonarqube.com/dashboard/index/Theoduin:Router)
[![Coverage](https://sonarqube.com/api/badges/measure?key=Theoduin:Router&metric=coverage)](https://sonarqube.com/dashboard/index/Theoduin:Router)
[![Bugs](https://sonarqube.com/api/badges/measure?key=Theoduin:Router&metric=bugs)](https://sonarqube.com/dashboard/index/Theoduin:Router)
[![Vulnerabilities](https://sonarqube.com/api/badges/measure?key=Theoduin:Router&metric=vulnerabilities)](https://sonarqube.com/dashboard/index/Theoduin:Router)
[![Code smells](https://sonarqube.com/api/badges/measure?key=Theoduin:Router&metric=code_smells)](https://sonarqube.com/dashboard/index/Theoduin:Router)
[![Duplicated lines density](https://sonarqube.com/api/badges/measure?key=Theoduin:Router&metric=duplicated_lines_density)](https://sonarqube.com/dashboard/index/Theoduin:Router)

### Usage
```php
$router = new \Theoduin\Router\Router();

$router->get('/', function () { return 'Home'; });
$router->get('/welcome', function () { return 'Welcome'; });
$router->get('/news/{id}/{slug?}', function ($id, $slug = '') { return 'News: id:' . $id . ', slug:' . $slug; });

$router->dispatch();
```
