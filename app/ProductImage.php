<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    public $width = 1200;
    public $height = 800;
    public $path = 'storage/product-images/';

    protected $dates = ['create_at', 'updated_at'];

	public function delete()
	{
		$filePath = public_path($this->path.$this->image);
	    if(file_exists($filePath)){
	        @unlink($filePath);
	    }
	    
	    parent::delete();
	}

	public function structure()
	{
		return $this->belongsTo('App\Product');
	}
}
