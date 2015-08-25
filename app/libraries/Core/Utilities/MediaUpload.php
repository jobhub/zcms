<?php

namespace ZCMS\Core\Utilities;

use ZCMS\Core\Models\Medias;

/**
 * Class MediaUpload
 *
 * @package ZCMS\Core\Utilities
 */
class MediaUpload
{

    /**
     * @var array
     */
    public $msg;

    /**
     * @var array
     */
    public static $accessMediaType = [
        'image',
        'video',
        'pdf'
    ];

    public function __construct($file)
    {
        if (!$this->__checkSize($file)) {
            $this->msg = [
                'code' => 1,
                'msg' => __('Media size is too big')
            ];
        }

        if (!$this->__checkImageType($file)) {
            $this->msg = [
                'code' => 1,
                'msg' => __('File type error')
            ];
        }

        if (!$this->__uploadMedia($file)) {
            $this->msg = [
                'code' => 1,
                'msg' => __('Upload media error')
            ];
        }

        $this->msg = [
            'code' => 0,
            'msg' => __('Upload media successfully')
        ];
    }

    /**
     * Check media type
     *
     * @param \Phalcon\Http\Request\File $file
     * @return bool
     */
    private function __checkImageType($file)
    {
        $type = $file->getType();
        $segment = explode('/', $type);
        if (count($segment) > 2 && in_array($segment[0], self::$accessMediaType) && in_array($file->getExtension(), self::$accessMediaType)) {
            return true;
        }

        return false;
    }

    /**
     * Check media size
     *
     * @param \Phalcon\Http\Request\File $file
     * @return bool
     */
    private function __checkSize($file)
    {
        $size = (int)ini_get("upload_max_filesize") * 1024 * 1024;
        if ($size <= $file->getSize()) {
            return true;
        }

        return false;
    }

    /**
     * Upload media
     *
     * @param \Phalcon\Http\Request\File $file
     * @return bool
     */
    private function __uploadMedia($file)
    {
        $baseDir = '/public/media/upload/' . date('Y/m/d') . '/';
        $dir = ROOT_PATH . $baseDir;
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        $extension = $file->getExtension();
        $segment = explode('.' . $extension, $file->getName());
        if (count($segment)) {
            $fileName = generateAlias($segment[0]);
            $filePath = $dir . $fileName . '.' . $extension;
            $i = 1;
            while (file_exists($filePath)) {
                $fileName = $fileName . '_' . $i;
                $filePath = $dir . $fileName . '.' . $extension;
            }
            if ($file->moveTo($filePath)) {
                $media = new  Medias();
                $media->assign([
                    'title' => ucfirst(str_replace('-', ' ', $fileName)),
                    'mime_type' => $file->getType(),
                    'src' => $baseDir . $fileName . '.' . $extension
                ]);

                if ($media->save()) {
                    return true;
                } else {
                    @unlink($filePath);
                    return false;
                }
            }
        }

        return false;
    }

    private function __getUploadDir()
    {
        return date('Y/m/d');
    }
}