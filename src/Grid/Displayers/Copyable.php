<?php

namespace Encore\Admin\Grid\Displayers;

use Encore\Admin\Facades\Admin;

/**
 * Class Copyable.
 *
 * @see https://codepen.io/shaikmaqsood/pen/XmydxJ
 */
class Copyable extends AbstractDisplayer
{
    protected function addScript()
    {
        $script = <<<SCRIPT
$('#{$this->grid->tableID}').on('click','.grid-column-copyable',(function (e) {
    var content = $(this).data('content');
    
    var temp = $('<input>');
    
    $("body").append(temp);
    temp.val(content).select();
    document.execCommand("copy");
    temp.remove();
    
    $(this).tooltip('show');
}));
SCRIPT;

        Admin::script($script);
    }

    public function display($position = 'left')
    {
        $this->addScript();

        $content = $this->getColumn()->getOriginal();

        $html = '';
        if ($content) {
            $left = $right = '';
            if ($position == 'left') {
                $left = $this->getValue().'&nbsp;';
            } else {
                $right = '&nbsp;'.$this->getValue();
            }
            $html = <<<HTML
            {$left}<a href="javascript:void(0);" class="grid-column-copyable text-muted" data-content="{$content}" title="Copied!" data-placement="bottom">
                <i class="fa fa-copy"></i>
            </a>{$right}
            HTML;
        }
        return $html;
    }
}
