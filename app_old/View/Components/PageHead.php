<?php

namespace App\View\Components;

use Illuminate\View\Component;

class PageHead extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $title;
    public $url;
    public $type;
    public $addons;
    public function __construct($title,$url=false,$type=false,$addons=array())
    {
        $this->title = $title;
        $this->url = $url;
        $this->type = $type;
        $this->addons = $addons;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.page-head');
    }
}
