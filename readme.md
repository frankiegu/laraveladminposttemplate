# LaravelAdminPostTemplate

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Build Status][ico-travis]][link-travis]
[![StyleCI][ico-styleci]][link-styleci]

This is where your description should go. Take a look at [contributing.md](contributing.md) to see a to do list.

## Installation

Via Composer

``` bash
$ composer require yangze/laraveladminposttemplate
```

## Usage
run generator command
``` bash
php artisan admin:post-template --module=Crm --post=Post --cat=Category --stat=Statistic --comm=Comment --force
```

and then do like this
``` bash
**************************
*     generator file     *
**************************

ApiController.php OK
CategoryController.php OK
CommentController.php OK
PostController.php OK
2019_12_26_171317_create_crm_category_table.php OK
2019_12_26_171317_create_crm_comment_table.php OK
2019_12_26_171317_create_crm_post_table.php OK
2019_12_26_171317_create_crm_statistic_table.php OK
CategoryModel.php OK
CommentModel.php OK
PostModel.php OK
StatisticModel.php OK
***************************************
*     the next step you should do     *
***************************************

// crm
$router->resource('crm/post', Crm\PostController::class);
$router->resource('crm/category', Crm\CategoryController::class);
$router->resource('crm/comment', Crm\CommentController::class);
```

## Change log

Please see the [changelog](changelog.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Security

If you discover any security related issues, please email zhenyangze@gmail.com instead of using the issue tracker.

## Credits

- [zhenyangze][link-author]
- [All Contributors][link-contributors]

## License

MIT. Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/yangze/laraveladminposttemplate.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/yangze/laraveladminposttemplate.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/yangze/laraveladminposttemplate/master.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/12345678/shield

[link-packagist]: https://packagist.org/packages/yangze/laraveladminposttemplate
[link-downloads]: https://packagist.org/packages/yangze/laraveladminposttemplate
[link-travis]: https://travis-ci.org/yangze/laraveladminposttemplate
[link-styleci]: https://styleci.io/repos/12345678
[link-author]: https://github.com/zhenyangze
[link-contributors]: ../../contributors
