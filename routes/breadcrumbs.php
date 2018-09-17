<?php
 
 
Breadcrumbs::for('system', function ($trail) {
    $trail->push('系统管理', route('setting'));
});

Breadcrumbs::for('clients', function ($trail) {
    $trail->push('客户管理', route('client'));
});
 
Breadcrumbs::for('client', function ($trail) {
    $requestAll = Request::all();
    $trail->parent('clients');
    $trail->push('客户列表'.(!empty($requestAll['status']) ? ':'.e($requestAll['status']) : ''), route('client'));
});

Breadcrumbs::for('client.back', function ($trail) {
    $trail->parent('clients');
    $trail->push('客户列表', 'javascript:history.back()');
});

Breadcrumbs::for('client.edit', function ($trail, $client) {
    $trail->parent('client.back');
    if (isset($client->id)) {
        $id = $client->id;
    } else {
        $id = $client;
    }
    $trail->push('编辑客户:'.(isset($client->name) ? $client->name : $client), route('client.edit', $id), compact($client));
});

Breadcrumbs::for('client.create', function ($trail) {
    $trail->parent('client.back');
    $trail->push('添加客户');
});

Breadcrumbs::for('client.import', function ($trail) {
    $trail->parent('clients');
    $trail->push('导入用户', route('client.import'));
});

Breadcrumbs::for('setting', function ($trail) {
    $trail->parent('system');
    $trail->push('系统设置', route('setting'));
});

Breadcrumbs::for('user', function ($trail) {
    $trail->push('用户管理', route('user'));
});

Breadcrumbs::for('user.create', function ($trail) {
    $trail->parent('user');
    $trail->push('创建用户', route('user.create'));
});

Breadcrumbs::for('user.edit', function ($trail, $form) {
    $trail->parent('user');
    $trail->push('编辑用户', route('user.edit', $form));
});

Breadcrumbs::for('role', function ($trail) {
    $trail->parent('user');
    $trail->push('角色管理', route('role'));
});

Breadcrumbs::for('role.create', function ($trail) {
    $trail->parent('role');
    $trail->push('创建角色', route('role.create'));
});

Breadcrumbs::for('role.edit', function ($trail, $form) {
    $trail->parent('role');
    $trail->push('编辑角色', route('role.edit', $form));
});

Breadcrumbs::for('permission', function ($trail) {
    $trail->parent('user');
    $trail->push('权限管理', route('permission'));
});

Breadcrumbs::for('report', function ($trail) {
    $trail->push('查看报表', route('report'));
});

Breadcrumbs::for('permission.create', function ($trail) {
    $trail->parent('permission');
    $trail->push('创建权限', route('permission.create'));
});

Breadcrumbs::for('permission.edit', function ($trail, $form) {
    $trail->parent('permission');
    $trail->push('编辑权限', route('permission.edit', $form));
});

Breadcrumbs::for('system.log', function ($trail) {
    $trail->parent('system');
    $trail->push('系统日志', route('system.log'));
});

// Home > Blog > [Category]
Breadcrumbs::for('category', function ($trail, $category) {
    $trail->parent('blog');
    $trail->push($category->title, route('category', $category->id));
});

// Home > Blog > [Category] > [Post]
Breadcrumbs::for('post', function ($trail, $post) {
    $trail->parent('category', $post->category);
    $trail->push($post->title, route('post', $post->id));
});