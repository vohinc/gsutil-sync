# Gsutil Sync of Laravel

## Install Gsutil
Please follow official guide: [Quick Install](https://cloud.google.com/sdk/docs/quickstarts)

## Setup

### Add Provider
Add provider to `config/app.php`

```php
'providers' => [
    ...
    Vohinc\GsutilSync\Providers\GsutilSyncProvider::class,
    ...
],
```

### Publish Configuration
```shell
php artisan vendor:publish --provider="Vohinc\GsutilSync\Providers\GsutilSyncProvider" --tag="config"
```

## Configure

```php
return [
    // Gsutil bin path 
    'bin' => '/usr/local/bin/gsutil',
    
    // What is the full path to your private key file?
    'key' => env('GSUTIL_KEY_PATH'),
    
    // Please navigate your browser to https://cloud.google.com/console#/project,
    // then find the project you will use, and copy the Project ID string from the
    // second column. Older projects do not have Project ID strings. For such projects,
    // click the project and then copy the Project Number listed under that project.
    'projectId' => '',
    
    // Gsutil config path
    // Allow Gsutil to call api
    'boto' => storage_path('app/gsutil/boto'),
    
    // backup path.
    'paths' => [
    ],
    
    // Bucket name
    'bucket' => '',
    
    // root path.
    'root' => '',
];
```