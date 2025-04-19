<?php

namespace App\Services\Blog;

use App\Models\Blog;
use App\Services\BaseService;

class BlogService extends BaseService
{
    /**
     * __construct
     *
     * @param  mixed $model
     * @return void
     */
    public function __construct(Blog $model)
    {
        parent::__construct($model);
    }
}



