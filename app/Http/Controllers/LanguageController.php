<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function switchLang($lang)
    {
        // ⚡ REVISI: Menambahkan 'zh' ke dalam daftar bahasa yang diizinkan sistem SITOBAT-UP
        if (in_array($lang, ['id', 'en', 'zh'])) {
            Session::put('locale', $lang);
        }
        
        return redirect()->back();
    }
}