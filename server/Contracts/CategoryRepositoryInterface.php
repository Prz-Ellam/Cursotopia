<?php

namespace Cursotopia\Contracts;

use Cursotopia\Entities\Category;

interface CategoryRepositoryInterface {
    public function create(Category $category);
    public function update(Category $category);
}
