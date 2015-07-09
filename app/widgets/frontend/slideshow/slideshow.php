<?php

use Phalcon\Tag;
use ZCMS\Core\Cache\ZCache;
use ZCMS\Core\ZWidget;
use ZCMS\Core\Models\SlideShows;
use ZCMS\Core\Models\SlideShowItems;

/**
 * Class SlideShow_Widget
 */
class SlideShow_Widget extends ZWidget
{
    const SLIDE_SHOW_WIDGET_CACHE = 'SLIDE_SHOW_WIDGET_CACHE';

    /**
     * @param int $id
     * @param array $widgetInfo
     * @param array $options
     */
    public function __construct($id = null, $widgetInfo = null, $options = null)
    {
        $options =[
            'title' => '',
            'slide_show_id' => ''
        ];

        parent::__construct($id, $widgetInfo, $options);
    }

    /**
     * @return string
     */
    public function form()
    {
        $title = isset($this->options->title) ? $this->options->title : "";
        $slide_show_id = isset($this->options->slide_show_id) ? $this->options->slide_show_id : "";

        $form = '<p><label for="' . $this->getFieldId('title') . '">' . __('gb_title') . '</label>';
        $form .= Tag::textField([
            $this->getFieldName('title'),
            'class' => 'form-control input-sm',
            'value' => $title
        ]);
        $form .= '</p>';

        $form .= '<p><label for="' . $this->getFieldId('slide_show_id') . '">' . __('w_slide_show_form_id_slide_show') . '</label><br/>';

        //Get all slide show
        $slideShows = SlideShows::find([
            'conditions' => 'published = 1',
            'order' => 'id ASC'
        ]);
        $form .= Tag::select([
            $this->getFieldName('slide_show_id'),
            $slideShows,
            'using' => ['id', 'title'],
            'class' => 'form-control input-sm',
            'value' => $slide_show_id,
        ]);
        $form .= '</p>';
        return $form;
    }

    /**
     * @return mixed|string
     */
    public function widget()
    {
        $html = '';
        if (isset($this->options->slide_show_id)) {
            $cache = ZCache::getInstance();
            $html = $cache->get(self::SLIDE_SHOW_WIDGET_CACHE . $this->options->slide_show_id);
            if ($html === null) {

                /**
                 * @var SlideShowItems[] $slideShowItems
                 */
                $slideShowItems = SlideShowItems::find([
                    'conditions' => 'id_slide_show = ?0 AND published = 1',
                    'bind' => [$this->options->slide_show_id],
                    'order' => 'ordering ASC'
                ]);

                if (count($slideShowItems)) {
                    $html .= '<div class="flexslider"><ul class="slides">';

                    foreach ($slideShowItems as $item) {
                        $html .= '<li><a target="' . $item->target . '" href="' . $item->link . '"><img src="' . $item->image . '"/></a></li>';
                    }

                    $html .= ' </ul></div>';
                    $cache->save(self::SLIDE_SHOW_WIDGET_CACHE . $this->options->slide_show_id, $html);
                }
            }
        }

        return $html;
    }

}

register_widget('SlideShow_Widget');
