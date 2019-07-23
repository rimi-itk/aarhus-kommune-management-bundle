# Aarhus kommune management

This Symfony 4 bundle does stuff.

See https://github.com/rimi-itk/aarhus-kommune-management-documentation for general documentation.

## Installation

```sh
composer require itk-dev/aarhus-kommune-management
```

Edit `config/bundles.php`:

```php
    …
    ItkDev\AarhusKommuneManagementBundle\AarhusKommuneManagementBundle::class => ['all' => true],
    …
```

Create `config/routes/aarhus_kommune_management.yaml`:

```yaml
aarhus_kommune_management:
    resource: '@AarhusKommuneManagementBundle/Resources/config/routes.xml'
```

Edit `.env.local`:

```sh
# openssl genrsa -out private.key 2048
AARHUS_KOMMUNE_MANAGEMENT_PUBLIC_KEY='%kernel.project_dir%/public.key'
# openssl rsa -in private.key -pubout -out public.key
AARHUS_KOMMUNE_MANAGEMENT_PRIVATE_KEY='%kernel.project_dir%/private.key'
# php -r 'echo base64_encode(random_bytes(32));'
AARHUS_KOMMUNE_MANAGEMENT_ENCRYPTION_KEY='tiaJeWd1i5x3tDrWUG6VfznY706XyDsHk/ZZPOH8eg0='
```

Extend `ItkDev\AarhusKommuneManagementBundle\Management\AbstractUserManager` to
create your custom user manager and override the
`itk_dev_aarhus_kommune_management.management.user_manager` service (e.g. in
`config/packages/aarhus_kommune_management.yaml`):

```yaml
services:
    itk_dev_aarhus_kommune_management.management.user_manager:
        class: 'App\Management\UserManager'
```
