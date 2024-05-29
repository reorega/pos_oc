<?php

namespace App\Controllers;
use App\Models\SettingModel;
class Home extends BaseController
{
    public function index(): string
    {
        $settingModel = new SettingModel();
        $data['setting'] = $settingModel->findAll();
        return view('login',$data);
    }
}
