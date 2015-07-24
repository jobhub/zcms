<?php

use Phalcon\Tag;
use ZCMS\Core\ZWidget;
use ZCMS\Core\Models\MenuTypes;

/**
 * Class Menu_Widget
 */
class Menu_Widget extends ZWidget
{
    /**
     * @param int $id
     * @param array $widgetInfo
     * @param array $options
     */
    public function __construct($id = null, $widgetInfo = null, $options = null)
    {
        $options = [
            'title' => '',
            'menu_type' => '0'
        ];
        parent::__construct($id, $widgetInfo, $options);
    }

    /**
     * Admin widget form
     *
     * @return string
     */
    public function form()
    {
        $menu_type = isset($this->options->menu_type) ? $this->options->menu_type : '';
        $title = isset($this->options->title) ? $this->options->title : '';

        $form = '<p><label for="' . $this->getFieldId('title') . '">' . __('gb_title') . '</label>';
        $form .= Tag::textField([
            $this->getFieldName('title'),
            'class' => 'form-control input-sm',
            'value' => $title
        ]);
        $form .= '</p>';

        $menuTypeAvailable = MenuTypes::find([
            'order' => 'name ASC'
        ]);
        $form .= '<p><label for="' . $this->getFieldId('menu_type') . '">' . __('w_menu_form_label_select_menu_type') . '</label>';
        $form .= Tag::select([
            $this->getFieldName('menu_type'),
            $menuTypeAvailable,
            'using' => ['menu_type_id', 'name'],
            'class' => 'form-control input-sm',
            'value' => $menu_type,
            'usingEmpty' => true
        ]);
        $form .= '</p>';
        return $form;
    }

    /**
     * Front end html
     * @return string
     */
    public function widget()
    {
        if (isset($this->options->menu_type) && $this->options->menu_type != null) {
            $builder = new Phalcon\Mvc\Model\Query\Builder();
            $builder->columns('mi.menu_item_id AS id, mi.name, mi.link, mi.thumbnail, md.parent_id')
                ->addFrom('ZCMS\Core\Models\MenuItems', 'mi')
                ->innerJoin('ZCMS\Core\Models\MenuDetails', 'mi.menu_item_id = md.menu_item_id', 'md')
                ->innerJoin('ZCMS\Core\Models\MenuTypes', 'md.menu_type_id = mt.menu_type_id', 'mt')
                ->where('md.menu_type_id = ?0', [$this->options->menu_type])
                ->orderBy('ordering ASC');
            $menu_items = $builder->getQuery()->execute()->toArray();
            if(count($menu_items)){
                echo '<pre>'; var_dump($this->_repaidMenuItems($menu_items));echo '</pre>'; die();
                return $this->_repaidMenuItems($menu_items);
            }
        }

        return [];
    }

    /**
     * Repaid menu items
     *
     * @param array $menuItems
     * @param int $parent
     * @return array
     */
    private function _repaidMenuItems($menuItems, $parent = 0){
        $result = [];
        foreach ($menuItems as $item) {
            if($item['parent_id'] == $parent){
                $result[] = $item;
            }else{
                foreach ($menuItems as $index => $itemParent) {
                    if($itemParent['id'] == $item['parent_id']){
                        $result[$index]['children'] = $this->_repaidMenuItems($menuItems, $item['parent_id']);
                    }
                }

            }
        }
        return $result;
    }
}

register_widget('Menu_Widget');