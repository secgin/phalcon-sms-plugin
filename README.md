# Phalcon Framework SMS Plugin

Sms gönderimi için kullanılan farklı firmaların api larını ortak bir yapıda uygulayarak phalcon framework de kullanılmak
için eklentidir.

## Desteklenen Sms Api ları

- Netgsm

## Kurulum

```bash
composer require secgin/phalcon-sms-plugin
```

## Kullanım

Config ayarlarını yapılandırınız.

```php
    new \Phalcon\Config([
        'sms' => [
            'username' => '...',
            'password' => '...',
            'defaultMessageHeader' => '...',
            'provider' => 'netgsm'
        ]
    ]);
```

ClientProvider Di Container içine ejekte etme

```php
    $container->register(new \Phalcon\Sms\ClientProvider());
```

Sms Gönderme

```php
    $container->get('sms')->send('5555555555', 'Deneme');
```

Çoklu Sms Gönderme

```php
    $container
        ->get('sms')
        ->sendMultiple(
            [
                '5555555555' => 'Mesaj 1', 
                '5555555556' => 'Mesaj 2'
            ]
        );
```
