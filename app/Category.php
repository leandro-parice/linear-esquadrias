<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $dates = ['created_at', 'updated_at'];

    public $width = 800;
    public $height = 600;
    public $path = 'storage/categories/';

 	public function delete()
    {
        $this->removeProducts();
        parent::delete();
    }

	public function products()
    {
        return $this->hasMany('App\Product');
    }

    public function removeProducts()
    {
        $filePath = public_path($this->path.$this->image);
        if(file_exists($filePath)){
            @unlink($filePath);
        }
        
        $products = $this->products;
        foreach ($products as $product) {
            $product->delete();
        }
    }
}
