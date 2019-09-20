<?php

namespace App\Admin\Controllers;

use Encore\Admin\Controllers\AdminController as AController;
use Encore\Admin\Layout\Content;


class AdminController extends AController
{
    public function edit($id, Content $content)
    {
        return $content
            ->title($this->title())
            ->description($this->description['edit'] ?? trans('admin.edit'))
            ->body($this->form($id)->edit($id));
    }

    public function update($id)
    {
        return $this->form($id)->update($id);
    }

    public function create(Content $content)
    {
        return $content
            ->title($this->title())
            ->description($this->description['create'] ?? trans('admin.create'))
            ->body($this->form($id=0));
    }

    public function store()
    {
        return $this->form($id=0)->store();
    }

    public function destroy($id)
    {
        return $this->form($id)->destroy($id);
    }

}
