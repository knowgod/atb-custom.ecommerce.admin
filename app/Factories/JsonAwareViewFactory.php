<?php

/**
 * @category Atypicalbrands
 * Written by: vyatsyuk@atypicalbrands.com
 * Date: 06.01.16
 *
 */
namespace App\Factories;

use Illuminate\View\Factory;
use Illuminate\Http\Request;

class JsonAwareViewFactory extends Factory {
    public function make($view, $data = array(), $mergeData = array()){
        //check for view is a hack, need to find another solution
        if (Request::capture()->wantsJson() && $view != 'invite.email'){
            return json_encode($data, JSON_HEX_TAG | JSON_HEX_APOS);
        }
        return parent::make($view, $data, $mergeData);
    }
}
