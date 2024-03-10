<?php 

namespace App\Interfaces;

interface ApiCrudInterface
{
    public function filter($request);
    
    public function store($request);
    
    public function update($entity);

    public function destroy($id);
}