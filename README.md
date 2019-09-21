# Lulu SMS PHP SDK;

## Installation
```bash
composer require osenco/lulu
```

## Usage
### Instantiate class
```php
$lulu = new Lulu($account, $username, $password);
```

### Send SMS
```php
$sms = $lulu->sms($to, $message, $from = 'lulusms.com');
```
