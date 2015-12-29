<?php

/**
 * @category Atypicalbrands
 * Written by: vyatsyuk@atypicalbrands.com
 * Date: 29.12.15
 *
 */
namespace App\Http\Controllers\User;

use App\User;
use App\Http\Requests;
use Validator;
use App\Http\Controllers\Controller;

class UserController extends Controller {

    public function __construct(){
        //$this->middleware('auth');
    }

    public function index(){
        return view('user.list');
    }

    public function view(){
        return view('user.view');
    }

    public function create(){
        return view('user.create');
    }

    public function update(){
        return 'updated';
    }
}