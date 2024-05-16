<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $width = 1200;
    public $height = 800;
    public $path = 'storage/products/';

	public function category()
	{
		return $this->belongsTo('App\Category');
	}

	public function images()
	{
		return $this->hasMany('App\ProductImage');
	}

    public function removeImages()
    {
        $images = $this->images;
        foreach ($images as $image)
        {
            $image->delete();
        }
    }

	public function delete()
	{
		$this->removeImages();

		$filePath = public_path($this->path.$this->image);
	    if(file_exists($filePath)){
	        @unlink($filePath);
	    }
	    
	    parent::delete();
	}
}
