<?php

namespace App\Controllers;

class Pages extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Home | Polinema'
        ];
        return view('pages/home', $data);
    }

    public function about()
    {
        $data = [
            'title' => 'About | Polinema'
        ];
        return view('pages/about', $data);
    }

    public function contact()
    {
        $data = [
            'title' => 'Contact Us | Polinema',
            'alamat' => [
                [
                    'tipe' => 'Rumah',
                    'alamat' => 'Jln. Godean km.01',
                    'kota' => 'Yogyakarta'
                ], [
                    'tipe' => 'Kantor',
                    'alamat' => 'Jln. Sekip UGM km.02',
                    'kota' => 'Yogyakarta'
                ]
            ]
        ];
        return view('pages/contact', $data);
    }
    public function sensor()
    {
        $data = [
            'title' => 'Sensor | Polinema'
        ];
        return view('pages/sensor', $data);
    }
}
