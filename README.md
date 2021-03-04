# Phaser 3 New Docs

The new documentation system for Phaser 3.

## Laravel Dev Notes

`npm i` + `composer i`

`npm run runhot` = artisan serve + hot reloading, running on http://127.0.0.1:8000

`php artisan serve` = http://127.0.0.1:8000
`npm run watch` or `npm run hot`

## Location Notes

`resources/css` and `resources/sass`

`resources/views` = page layout blades (classes, name spaces, etc)

`app/Http/Controllers/Docs` = various controllers (Classes, Game Objects, etc)
`app/Models/Controllers/Docs` = section specific app models (classes, etc)

`app/Http/Controllers/Docs/ApiPhaserController` = handles controller routing

`PhaserVersionCheckMiddleware` = This middlewre help to know if the route has the correct version (if we have this version inside database)

