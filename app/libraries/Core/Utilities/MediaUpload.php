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
     *
     *
     * @var array
     */
    public static $accessMediaType = [
        // Image formats.
        'jpg|jpeg|jpe' => 'image/jpeg',
        'gif' => 'image/gif',
        'png' => 'image/png',
        'bmp' => 'image/bmp',
        'tiff|tif' => 'image/tiff',
        'ico' => 'image/x-icon',
        // Video formats.
        'asf|asx' => 'video/x-ms-asf',
        'wmv' => 'video/x-ms-wmv',
        'wmx' => 'video/x-ms-wmx',
        'wm' => 'video/x-ms-wm',
        'avi' => 'video/avi',
        'divx' => 'video/divx',
        'flv' => 'video/x-flv',
        'mov|qt' => 'video/quicktime',
        'mpeg|mpg|mpe' => 'video/mpeg',
        'mp4|m4v' => 'video/mp4',
        'ogv' => 'video/ogg',
        'webm' => 'video/webm',
        'mkv' => 'video/x-matroska',
        '3gp|3gpp' => 'video/3gpp', // Can also be audio
        '3g2|3gp2' => 'video/3gpp2', // Can also be audio
        // Text formats.
        'txt|asc|c|cc|h|srt' => 'text/plain',
        'csv' => 'text/csv',
        'tsv' => 'text/tab-separated-values',
        'ics' => 'text/calendar',
        'rtx' => 'text/richtext',
        'css' => 'text/css',
        'htm|html' => 'text/html',
        'vtt' => 'text/vtt',
        'dfxp' => 'application/ttaf+xml',
        // Audio formats.
        'mp3|m4a|m4b' => 'audio/mpeg',
        'ra|ram' => 'audio/x-realaudio',
        'wav' => 'audio/wav',
        'ogg|oga' => 'audio/ogg',
        'mid|midi' => 'audio/midi',
        'wma' => 'audio/x-ms-wma',
        'wax' => 'audio/x-ms-wax',
        'mka' => 'audio/x-matroska',
        // Misc application formats.
        'rtf' => 'application/rtf',
        'js' => 'application/javascript',
        'pdf' => 'application/pdf',
        'swf' => 'application/x-shockwave-flash',
        'class' => 'application/java',
        'tar' => 'application/x-tar',
        'zip' => 'application/zip',
        'gz|gzip' => 'application/x-gzip',
        'rar' => 'application/rar',
        '7z' => 'application/x-7z-compressed',
        'exe' => 'application/x-msdownload',
        'psd' => 'application/octet-stream',
        'xcf' => 'application/octet-stream',
        // MS Office formats.
        'doc' => 'application/msword',
        'pot|pps|ppt' => 'application/vnd.ms-powerpoint',
        'wri' => 'application/vnd.ms-write',
        'xla|xls|xlt|xlw' => 'application/vnd.ms-excel',
        'mdb' => 'application/vnd.ms-access',
        'mpp' => 'application/vnd.ms-project',
        'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'docm' => 'application/vnd.ms-word.document.macroEnabled.12',
        'dotx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.template',
        'dotm' => 'application/vnd.ms-word.template.macroEnabled.12',
        'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'xlsm' => 'application/vnd.ms-excel.sheet.macroEnabled.12',
        'xlsb' => 'application/vnd.ms-excel.sheet.binary.macroEnabled.12',
        'xltx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.template',
        'xltm' => 'application/vnd.ms-excel.template.macroEnabled.12',
        'xlam' => 'application/vnd.ms-excel.addin.macroEnabled.12',
        'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
        'pptm' => 'application/vnd.ms-powerpoint.presentation.macroEnabled.12',
        'ppsx' => 'application/vnd.openxmlformats-officedocument.presentationml.slideshow',
        'ppsm' => 'application/vnd.ms-powerpoint.slideshow.macroEnabled.12',
        'potx' => 'application/vnd.openxmlformats-officedocument.presentationml.template',
        'potm' => 'application/vnd.ms-powerpoint.template.macroEnabled.12',
        'ppam' => 'application/vnd.ms-powerpoint.addin.macroEnabled.12',
        'sldx' => 'application/vnd.openxmlformats-officedocument.presentationml.slide',
        'sldm' => 'application/vnd.ms-powerpoint.slide.macroEnabled.12',
        'onetoc|onetoc2|onetmp|onepkg' => 'application/onenote',
        'oxps' => 'application/oxps',
        'xps' => 'application/vnd.ms-xpsdocument',
        // OpenOffice formats.
        'odt' => 'application/vnd.oasis.opendocument.text',
        'odp' => 'application/vnd.oasis.opendocument.presentation',
        'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
        'odg' => 'application/vnd.oasis.opendocument.graphics',
        'odc' => 'application/vnd.oasis.opendocument.chart',
        'odb' => 'application/vnd.oasis.opendocument.database',
        'odf' => 'application/vnd.oasis.opendocument.formula',
        // WordPerfect formats.
        'wp|wpd' => 'application/wordperfect',
        // iWork formats.
        'key' => 'application/vnd.apple.keynote',
        'numbers' => 'application/vnd.apple.numbers',
        'pages' => 'application/vnd.apple.pages',

        //Image
        'image/jpeg',
        'image/gif',
        'image/png',
        'image/bmp',
        'image/tiff',
        'image/x-icon',
        //Video
        'video/x-ms-asf',
        'video/x-ms-wmv',
        'video/x-ms-wmx',
        'video/x-ms-wm',
        'video/avi',
        'video/divx',
        'video/x-flv',
        'video/quicktime',
        'video/mpeg',
        'video/mp4',
        'video/ogg',
        'video/webm',
        'video/x-matroska',
        'video/3gpp',
        'video/3gpp2',
        //Text
        'text/plain',
        'text/csv',
        'text/tab-separated-values',
        'text/calendar',
        'text/richtext',
        'text/css',
        'text/html',
        'text/vtt',
        'application/ttaf+xml',
        //Audio
        'audio/mpeg',
        'audio/x-realaudio',
        'audio/wav',
        'audio/ogg',
        'audio/midi',
        'audio/x-ms-wma',
        'audio/x-ms-wax',
        'audio/x-matroska',
        //Misc application
        'application/rtf',
        'application/javascript',
        'application/pdf',
        'application/x-shockwave-flash',
        'application/java',
        'application/x-tar',
        'application/zip',
        'application/x-gzip',
        'application/rar',
        'application/x-compressed-zip',
        'application/x-bzip2',
        'application/x-tar',
        'application/x-rar',
        'application/x-7z-compressed',
        'application/x-msdownload',
        'application/octet-stream',
        'application/octet-stream',
        //MS Office
        'application/msword',
        'application/vnd.ms-powerpoint',
        'application/vnd.ms-write',
        'application/vnd.ms-excel',
        'application/vnd.ms-access',
        'application/vnd.ms-project',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'application/vnd.ms-word.document.macroEnabled.12',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.template',
        'application/vnd.ms-word.template.macroEnabled.12',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'application/vnd.ms-excel.sheet.macroEnabled.12',
        'application/vnd.ms-excel.sheet.binary.macroEnabled.12',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.template',
        'application/vnd.ms-excel.template.macroEnabled.12',
        'application/vnd.ms-excel.addin.macroEnabled.12',
        'application/vnd.openxmlformats-officedocument.presentationml.presentation',
        'application/vnd.ms-powerpoint.presentation.macroEnabled.12',
        'application/vnd.openxmlformats-officedocument.presentationml.slideshow',
        'application/vnd.ms-powerpoint.slideshow.macroEnabled.12',
        'application/vnd.openxmlformats-officedocument.presentationml.template',
        'application/vnd.ms-powerpoint.template.macroEnabled.12',
        'application/vnd.ms-powerpoint.addin.macroEnabled.12',
        'application/vnd.openxmlformats-officedocument.presentationml.slide',
        'application/vnd.ms-powerpoint.slide.macroEnabled.12',
        'application/onenote',
        'application/oxps',
        'application/vnd.ms-xpsdocument',
        //OpenOffice
        'application/vnd.oasis.opendocument.text',
        'application/vnd.oasis.opendocument.presentation',
        'application/vnd.oasis.opendocument.spreadsheet',
        'application/vnd.oasis.opendocument.graphics',
        'application/vnd.oasis.opendocument.chart',
        'application/vnd.oasis.opendocument.database',
        'application/vnd.oasis.opendocument.formula',
        //WordPerfect
        'application/wordperfect',
        //iWork
        'application/vnd.apple.keynote',
        'application/vnd.apple.numbers',
        'application/vnd.apple.pages',
    ];

    public function __construct($file)
    {
        if (!$this->__checkSize($file)) {
            $this->msg = [
                'code' => 1,
                'msg' => __('Media size is too big')
            ];
        }

        if (!$this->__checkMediaType($file)) {
            $this->msg = [
                'code' => 1,
                'msg' => __('Sorry, this file type is not except')
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
    private function __checkMediaType($file)
    {
        if (in_array($file->getType(), self::$accessMediaType)) {
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
            $i = 0;
            while (file_exists($filePath)) {
                $i++;
                $filePath = $dir . $fileName . '_' . $i . '.' . $extension;
            }
            if($i){
                $fileName .= '_' . $i;
            }
            if ($file->moveTo($filePath)) {
                $media = new  Medias();
                $media->assign([
                    'title' => ucfirst(str_replace(['-','_'], ' ', $fileName)),
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
}