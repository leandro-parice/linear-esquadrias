<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $dates = ['start', 'end', 'created_at', 'updated_at'];

    public $width = 1920;
    public $height = 1080;
    public $path = 'storage/banners/';

	public function delete()
	{
		$filePath = public_path($this->path.$this->image);
	    if(file_exists($filePath)){
	        @unlink($filePath);
	    }
	    
	    parent::delete();
	}
}
