<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Auth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        // melihat routes level session apa sama dengan argument di route
        //$arguments = "admin";
        $requiredLevel = $arguments[0];
        if($session->level==1){
            $level="admin";
        }else{
            $level="kasir";
        }
        if (!$session->isLoggedIn || $level != $requiredLevel) {
            $data['argumen']= $requiredLevel;
            //return view('/admin/index',$data) ;
            return redirect()->to('/');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
