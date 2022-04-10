<?php


namespace App\Admin\Controllers;


class HomeController extends controller
{
    //首页
    public function index(){
        return view('admin/home/index');
    }

}