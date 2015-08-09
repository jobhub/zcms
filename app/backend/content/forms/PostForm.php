<?php

namespace ZCMS\Backend\Content\Forms;

use ZCMS\Core\Models\Behavior\SEOTable;

/**
 * Class PostForm
 *
 * @package ZCMS\Backend\Content\Forms
 */
class PostForm
{
    use SEOTable;

    /**
     * Title column for SEO
     *
     * @var string
     */
    public $_titleColumn = 'title';

    /**
     * @var string
     */
    public $_formName = 'm_content_form_post_form';

    /**
     * Init form
     *
     * @param \ZCMS\Core\Models\Posts $post
     * @param array $options
     */
    public function initialize($post = null, $options = []){

    }
}