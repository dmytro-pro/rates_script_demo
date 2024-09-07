## Refactoring the rates script (demo task)

### Installing:
```
composer install
```

### Usage:
```
export $(grep -v '^#' .env | xargs)
php rates.php input.txt
```
### Tests:
```
./vendor/bin/phpunit tests/
```

### How to launch legacy script to compare outputs:
```
php rates-legacy.php input.txt
```
Note that it will likely produce an error due to API constraints (API key for rates & rate limit for binlist)

### License

See [LICENSE](LICENSE).   
Made for fun ) try to solve it with own style if You dare 🍀
