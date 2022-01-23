<?php

namespace common\widgets;

use yii\helpers\Html;

class PageSize extends \yii\base\Widget
{
    /**
     * @var string the label text.
     */
    public $label = 'items';

    /**
     * @var integer the defualt page size. This page size will be used when the $_GET['per-page'] is empty.
     */
    public $defaultPageSize = 20;

    /**
     * @var string the name of the GET request parameter used to specify the size of the page. 
     * This will be used as the input name of the dropdown list with page size options.
     */
    public $pageSizeParam = 'per-page';

    /**
     * @var array the list of page sizes
     */
    public $sizes = [2 => 2, 5 => 5, 10 => 10, 15 => 15, 20 => 20, 25 => 25, 50 => 50, 100 => 100, 200 => 200];

    /**
     * @var string the template to be used for rendering the output.
     */
    public $template = '{list} {label}';

    /**
     * @var array the list of options for the drop down list.
     */
    public $options;

    /**
     * @var array the list of options for the label
     */
    public $labelOptions;

    /**
     * @var boolean whether to encode the label text.
     */
    public $encodeLabel = true;

    /**
     * Runs the widget and render the output
     */
    public function run()
    {
        if(empty($this->options['id'])) {
            $this->options['id'] = $this->id;
        }

        if($this->encodeLabel) {
            $this->label = Html::encode($this->label);
        }

        Html::addCssClass($this->options, 'form-control');

        $perPage = !empty($_GET[$this->pageSizeParam]) ? $_GET[$this->pageSizeParam] : $this->defaultPageSize;

        $listHtml = Html::dropDownList($this->pageSizeParam, $perPage, $this->sizes, $this->options);
        $labelHtml = Html::label($this->label, $this->options['id'], $this->labelOptions);

        $output = str_replace(['{list}', '{label}'], [$listHtml, $labelHtml], $this->template);

        return $output;
    }
}