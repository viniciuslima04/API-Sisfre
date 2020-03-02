<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Api;
use Http\RelatorioController;

class ApiController extends Controller
{
    
    public function index()
    {
        return RelatorioController::All();

    }

    
    public function create()
    {
       //
    }

   
    public function store(Request $request)
    {
        Api::create($request->all());
    }

   
    public function show($id)
    {
        //
    }

 
    public function edit($id)
    {
        //
    }

  
    public function update(Request $request, $id)
    {
        //
    }

  
    public function destroy($id)
    {
        //
    }
}
