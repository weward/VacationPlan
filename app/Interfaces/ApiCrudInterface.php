<?php 

namespace App\Interfaces;

interface ApiCrudInterface
{
    public function filter($request);
    
    public function store($request);
    
    public function update($request, $entity);

    public function destroy($id);
}