<?php

use App\Models\Image;
use App\Models\Post;
use App\Models\Video;

    if(!function_exists('getCommentsModel')){
        function getCommentsModel($type, $id)
        {
            switch($type){
                case 'post':
                    return Post::find($id);
                case 'image':
                    return Image::find($id);
                case 'video':
                    return Video::find($id);
            }
    
        }
    }
