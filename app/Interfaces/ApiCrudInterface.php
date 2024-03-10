<?php 

namespace App\Interfaces;

interface ApiCrudInterface
{
    public function filter($request);
    
    public function store($request);
    
    public function fetch($id);

    public function update($entity);

    public function destroy($id);
}