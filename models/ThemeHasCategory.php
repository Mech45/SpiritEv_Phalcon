<?php
namespace PhalconRest\Models;
use \PhalconRest\Exceptions\HTTPException;

class ThemeHasCategory extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $theme_id;

    /**
     *
     * @var integer
     */
    public $category_id;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('category_id', 'Category', 'id', array('alias' => 'Category'));
        $this->belongsTo('theme_id', 'Theme', 'id', array('alias' => 'Theme'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'theme_has_category';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return ThemeHasCategory[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return ThemeHasCategory
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
