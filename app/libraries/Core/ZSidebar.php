<?php

namespace ZCMS\Core;

use Phalcon\Di as PDI;
use ZCMS\Core\Cache\ZCache;
use ZCMS\Core\Models\CoreWidgetValues;

/**
 * Class helper coder get sidebar in frontend template
 *
 * @package   ZCMS\Core
 * @since     0.0.1
 */
class ZSidebar
{
    const CACHE_KEY = 'SIDEBAR_KEY_';

    /**
     * Get sidebar
     *
     * @param string $sidebar_base_name
     * @return string
     */
    public static function getSidebar($sidebar_base_name)
    {
        /**
         * @var ZCache $cache
         */
        $cache = PDI::getDefault()->get('cache');
        $sidebarKey = self::CACHE_KEY . $sidebar_base_name;

        $html = '';
        $defaultTemplate = PDI::getDefault()->get('config')->frontendTemplate->defaultTemplate;

        $widgets = $cache->get($sidebarKey);
        if ($widgets === null) {
            $widgets = CoreWidgetValues::find([
                'conditions' => 'sidebar_base_name = ?1 AND theme_name = ?2',
                'bind' => [1 => $sidebar_base_name, 2 => $defaultTemplate],
                'order' => 'ordering ASC'
            ])->toArray();
            $cache->save($sidebarKey, $widgets);
        }

        if (count($widgets) > 0) {
            //Get widget html
            foreach ($widgets as $widget) {
                $class_name = str_replace('_widget', '', $widget['class_name']);
                if (!class_exists($widget['class_name'])) {
                    $widget_file = APP_DIR . '/widgets/frontend/' . $class_name . '/' . $class_name . '.php';
                    if (file_exists($widget_file)) {
                        require_once $widget_file;
                    }
                }

                if (class_exists($widget['class_name'])) {
                    /**
                     * @var \ZCMS\Core\ZWidget $ob
                     */
                    $ob = new $widget['class_name']($widget['widget_value_id']);
                    if (method_exists($ob, 'widget')) {
                        $html .= $ob->getWidget();
                    }
                }
            }

        }
        return $html;
    }

}