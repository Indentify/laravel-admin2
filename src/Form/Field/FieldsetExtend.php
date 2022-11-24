<?php

namespace Encore\Admin\Form\Field;

use Encore\Admin\Admin;

class FieldsetExtend
{
    protected $name = '';
    protected $params = [];

    public function __construct()
    {
        $this->name = uniqid('fieldset-ext-');
    }

    public function start($title,$params = [])
    {
        $this->params = $params;
        $script = <<<SCRIPT
$('.{$this->name}-title').click(function () {
    $("i", this).toggleClass("fa-angle-double-down fa-angle-double-up");
});
SCRIPT;

        Admin::script($script);

        $intro = '';
        if (isset($this->params['memo'])) {
            $intro = <<<INTRO
            <div>
            <p class="bg-info" style="padding:15px;margin-bottom:20px;border-radius:5px">{$this->params['memo']}</p>
            </div>
    INTRO;
        }


        return <<<HTML
<div>
    <div style="height: 20px; border-bottom: 1px solid #eee; text-align: center;margin-top: 20px;margin-bottom: 20px;">
      <span style="font-size: 16px; background-color: #ffffff; padding: 0 10px;">
        <a data-toggle="collapse" href="#{$this->name}" class="{$this->name}-title">
          <i class="fa fa-angle-double-down"></i>&nbsp;&nbsp;{$title}
        </a>
      </span>
    </div>
    <div class="collapse" id="{$this->name}">
    {$intro}
HTML;
    }

    public function end()
    {
        return '</div></div>';
    }

    public function collapsed()
    {
        $script = <<<SCRIPT
$("#{$this->name}").removeClass("in");
$(".{$this->name}-title i").toggleClass("fa-angle-double-down fa-angle-double-up");
SCRIPT;

        Admin::script($script);

        return $this;
    }
}
