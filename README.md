# Upload Library

A simple and lightweight PHP library for handling file uploads with support for size and extension restrictions. 

## Features
- **Set maximum file size** (in KB).
- **Restrict allowed file extensions**.
- **Handle multiple file uploads**.
- **Easy-to-use static interface**.

## Installation

You can install this package via Composer:

```bash
composer require natilosir/upload
```

## Usage
Basic Example
```php
<?php

require __DIR__ . '/vendor/autoload.php';

use Natilosir\Upload\Upload;

// Set maximum file size (in KB)
Upload::size(2048); // Maximum size: 2MB

// Set allowed file extensions
Upload::extensions(['jpg', 'jpeg', 'png', 'pdf']);

// Define the upload directory
$uploadPath = __DIR__ . '/uploads';

// Upload files
$result = Upload::file($_FILES['files'], $uploadPath);

// Output the results
echo '<pre>';
print_r($result);
echo '</pre>';

```

## Example Results
Successful Upload
```php
Array
(
    [uploaded] => Array
        (
            [0] => 64a8e3b0d1c5b.jpg
            [1] => 64a8e3b0d1c6b.png
        )

    [errors] => Array
        (
        )
)
```

---
Error Example
```php
Array
(
    [uploaded] => Array
        (
        )

    [errors] => Array
        (
            [0] => File example.exe has an invalid extension.
            [1] => File large_image.jpg exceeds the max file size.
        )
)

```

## Methods
Set the maximum file size allowed (in KB). For example:
`Upload::size(int $sizeInKB)` 
```php
Upload::size(2048); // 2MB
```

Set the allowed file extensions. For example:
`Upload::extensions(array $extensions)`
```php
Upload::extensions(['jpg', 'jpeg', 'png', 'pdf']);
```

Handles the file upload. Parameters:
`Upload::file(array $files, string $destination)`
```php
Upload::File($_FILES['files'], $uploadPath);
```
