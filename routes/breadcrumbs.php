<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

// Breadcrumbs::for('admin.adminDashboard', function (BreadcrumbTrail $trail): void {
//     $trail->push('Dashboard', route('admin.adminDashboard'));
// });
// Breadcrumbs::for('category.index', function (BreadcrumbTrail $trail): void {
//     $trail->parent('category.index');
//     $trail->push('category', route('category.index'));
// });
