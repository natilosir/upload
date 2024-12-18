<?php

class Upload
{
    private static $maxFileSize = 1024; // پیش‌فرض 1 مگابایت (1024 کیلوبایت)
    private static $allowedExtensions = ['jpg', 'png', 'gif', 'pdf'];

    /**
     * تنظیم حداکثر حجم فایل.
     * 
     * @param int $sizeInKB حجم فایل بر حسب کیلوبایت
     */
    public static function size($sizeInKB)
    {
        self::$maxFileSize = $sizeInKB;
    }

    /**
     * تنظیم پسوندهای مجاز.
     * 
     * @param array $extensions لیست پسوندهای مجاز
     */
    public static function Extensions(array $extensions)
    {
        self::$allowedExtensions = $extensions;
    }

    /**
     * آپلود فایل‌ها.
     * 
     * @param array $files آرایه‌ی فایل‌ها ($_FILES['name'])
     * @param string $destination مسیر ذخیره فایل‌ها
     * @return array لیست فایل‌های آپلود شده و خطاها
     */
    public static function File(array $files, $destination)
    {
        $results = ['uploaded' => [], 'errors' => []];

        foreach ($files['name'] as $index => $name) {
            $tmpName = $files['tmp_name'][$index];
            $size = $files['size'][$index] / 1024; // تبدیل به کیلوبایت
            $error = $files['error'][$index];

            $extension = strtolower(pathinfo($name, PATHINFO_EXTENSION));

            if ($error !== UPLOAD_ERR_OK) {
                $results['errors'][] = "خطا در آپلود فایل $name.";
                continue;
            }

            if ($size > self::$maxFileSize) {
                $results['errors'][] = "فایل $name از حداکثر حجم مجاز ($size KB) بزرگ‌تر است.";
                continue;
            }

            if (!in_array($extension, self::$allowedExtensions)) {
                $results['errors'][] = "پسوند فایل $name ($extension) مجاز نیست.";
                continue;
            }

            $uniqueName = uniqid() . '.' . $extension; // نام یکتا برای فایل
            if (!move_uploaded_file($tmpName, $destination . DIRECTORY_SEPARATOR . $uniqueName)) {
                $results['errors'][] = "انتقال فایل $name به مسیر مقصد ناموفق بود.";
                continue;
            }

            $results['uploaded'][] = $uniqueName;
        }

        return $results;
    }
}
