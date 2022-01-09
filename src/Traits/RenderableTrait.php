<?php

namespace Maduser\Laravel\Support\Traits;

use Illuminate\Support\HtmlString;
use Maduser\Laravel\ViewModel\ViewFinder;
use Throwable;

trait RenderableTrait
{
    /**
     * The view to use
     *
     * @var string
     */
    protected $view;

    /**
     * The name of the variable representing $this in the view
     * Per default it is the class base name of $this lcFirst()
     *
     * @var string
     */
    protected $exposedAs = 'view';

    /**
     * Setter for view
     *
     * @param string|null $view
     *
     * @return $this
     */
    public function view(string $view = null): self
    {
        $this->view = $view ? $view : $this->view;

        return $this;
    }

    /**
     * Render the blade template
     *
     * @param string $view
     *
     * @return HtmlString
     * @throws Throwable
     */
    public function render(string $view = null)
    {
        $view = $view ?: $this->view;

//        return new HtmlString(
//            view($view, [$this->exposedAs => $this])->render()
//        );

        $str = ViewFinder::create($this, $view ?: $this->view, $this->exposedAs)
            ->render(function ($view, $exposedAs) {
                return view($view, [$exposedAs => $this])->render();
            }, $view);

        return new HtmlString($str);
    }
}
