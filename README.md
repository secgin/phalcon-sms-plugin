# Phalcon Framework SMS Plugin

Farklı firmaların sms api larını phalcon framework ile kullanılması için eklenti.

## Desteklenen Sms Api ları

- Netgsm
- Telsam

## Kurulum

```bash
composer require secgin/phalcon-sms-plugin
```

## Kullanım

Config ayarlarını yapılandırınız.

```php
    // Netgsm
    new \Phalcon\Config([
        'sms' => [
            'username' => '...',
            'password' => '...',
            'header' => '...',
            'provider' => 'netgsm'
        ]
    ]);

    // Telsam
    new \Phalcon\Config([
        'sms' => [
            'username' => '...',
            'password' => '...',
            'sender' => '...',
            'title' => '...',
            'provider' => 'telsam'
        ]
    ]);
```

Bağlılık kaydı

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
