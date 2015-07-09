<?php

use Phalcon\Tag;
use ZCMS\Core\Models\MenuTypes;
use ZCMS\Core\ZWidget;

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
        $menu_type = isset($this->options->menu_type) ? $this->options->menu_type : "";
        $title = isset($this->options->title) ? $this->options->title : "";

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
            "using" => ["menu_type_id", "name"],
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

            /**
             * select menu_item.id, menu_item.name, menu_item.link, menu_item.thumbnail, menu_detail.parent_id
             * from menu_item
             * inner join menu_detail
             * on menu_item.id = menu_detail.menu_item_id
             * inner join menu_type on menu_detail.menu_type_id = menu_type.id
             * where menu_detail.menu_type_id = 1
             */
            $builder = new Phalcon\Mvc\Model\Query\Builder();
            $builder->columns("mi.menu_item_id AS id, mi.name, mi.link, mi.thumbnail, md.parent_id")
                ->addFrom("ZCMS\Core\Models\MenuItems", "mi")
                ->innerJoin("ZCMS\Core\Models\MenuDetails", "mi.menu_item_id = md.menu_item_id", "md")
                ->innerJoin("ZCMS\Core\Models\MenuTypes", "md.menu_type_id = mt.menu_type_id", "mt")
                ->where("md.menu_type_id = ?0", [$this->options->menu_type])
                ->orderBy('ordering ASC');
            $menu_items = $builder->getQuery()->execute()->toArray();

            $uri = $_SERVER['REQUEST_URI'];

            $result = "<ul class='nav navbar-nav navbar-right'>";
            foreach ($menu_items as $value) {
                if ($value["parent_id"] == 0) {
                    if ($uri == $value["link"]) {
                        $result .= "<li class='%cls% active'>";
                    } else {
                        $result .= "<li class='%cls%'>";
                    }
                    $linkRoot = "<a href='" . $value["link"] . "' ";
                    $subMenu = $this->getMenuChild($menu_items, $value);
                    if ($subMenu[0] != "") {
                        if ($subMenu[1]) {
                            $result = str_replace('%cls%', 'dropdown active', $result);
                        } else {
                            $result = str_replace('%cls%', 'dropdown', $result);
                        }
                        $linkRoot .= "class='dropdown-toggle' data-toggle='dropdown' data-hover='dropdown'>" . $value['name'] . '<b class="caret"></b></a>';
                    } else {
                        $result = str_replace('%cls%', '', $result);
                        $linkRoot .= ">" . $value['name'] . '</a>';
                    }
                    $result .= $subMenu[0];
                    $result .= $linkRoot;
                    $result .= "</li>";
                }
            }
            $result .= "</ul>";
            return $result;
        }
        return null;
    }

    /**
     * Get child menu
     *
     * @param array $menu_items
     * @param array $item
     * @return array
     */
    private function getMenuChild($menu_items, $item)
    {
        $isActive = false;
        $str = "";
        foreach ($menu_items as $value) {
            if ($value["parent_id"] == $item["id"]) {
                if ($_SERVER['REQUEST_URI'] == $value["link"]) {
                    $isActive = true;
                }
                if ($str == "") $str = "<ul class='dropdown-menu'>";
                $str .= "<li>";
                $str .= "<a href='" . $value["link"] . "'>" . $value["name"] . "</a>";
                $str .= $this->getMenuChild($menu_items, $value)[0];
                $str .= "</li>";
            }
        }
        if ($str != "") {
            $str .= "</ul>";
        }
        return [$str, $isActive];
    }

}

register_widget('Menu_Widget');