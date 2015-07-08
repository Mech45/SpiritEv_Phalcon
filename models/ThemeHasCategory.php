<?php
namespace PhalconRest\Models;
use \PhalconRest\Exceptions\HTTPException;

class ThemeHasCategory extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $theme_id;

    /**
     *
     * @var integer
     */
    protected $category_id;

    /**
     * Method to set the value of field theme_id
     *
     * @param integer $theme_id
     * @return $this
     */
    public function setThemeId($theme_id)
    {
        $this->theme_id = $theme_id;

        return $this;
    }

    /**
     * Method to set the value of field category_id
     *
     * @param integer $category_id
     * @return $this
     */
    public function setCategoryId($category_id)
    {
        $this->category_id = $category_id;

        return $this;
    }

    /**
     * Returns the value of field theme_id
     *
     * @return integer
     */
    public function getThemeId()
    {
        return $this->theme_id;
    }

    /**
     * Returns the value of field category_id
     *
     * @return integer
     */
    public function getCategoryId()
    {
        return $this->category_id;
    }

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
