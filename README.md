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
    $container->get('sms')->send(Deneme', ['0000000000']);
```

```php
    $container->get('sms')->send(Deneme', ['0000000000', '0000000000']);
```

Çoklu Sms Gönderme

```php
    $container
        ->get('sms')
        ->sendMultiple(
            [
                '0000000000' => 'Mesaj 1', 
                '0000000000' => 'Mesaj 2'
            ]
        );
```
