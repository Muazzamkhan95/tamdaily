<?php

namespace App\Widgets;

use Illuminate\Support\Str;
use App\DailyDispatchedOrder;
use TCG\Voyager\Facades\Voyager;
use TCG\Voyager\Widgets\BaseDimmer;
use Illuminate\Support\Facades\Auth;

class Orders extends BaseDimmer
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $count = DailyDispatchedOrder::count();
        $string = "Total Shipped Orders";

        return view('voyager::dimmer', array_merge($this->config, [
            'icon'   => 'voyager-archive',
            'title'  => "{$count} {$string}",
            'text'   => __('voyager::dimmer.user_text', ['count' => $count, 'string' => Str::lower($string)]),
            'button' => [
                'text' => "Total Orders Shipped on all platforms till today",
                'link' => route('voyager.daily-dispatched-orders.index'),
            ],
            'image' => 'storage/settings/banner1.jpg',
        ]));
    }

    /**
     * Determine if the widget should be displayed.
     *
     * @return bool
     */
    public function shouldBeDisplayed()
    {
        return Auth::user()->can('browse', Voyager::model('User'));
    }
}
