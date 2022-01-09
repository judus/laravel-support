<?php

namespace Maduser\Laravel\Support\Traits;

use Throwable;

trait HtmlableTrait
{
    use RenderableTrait;

    /**
     * The HTML representation of this view model
     *
     * @return string
     * @throws Throwable
     */
    public function toHtml()
    {
        return $this->render();
    }
}
