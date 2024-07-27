<?php

namespace App\Controllers;
class Home extends BaseController
{
    public function index(): string
    {
        $setting= $this->loadConfigData();
        $data['setting'] = $setting;
        return view('login',$data);
    }
}
