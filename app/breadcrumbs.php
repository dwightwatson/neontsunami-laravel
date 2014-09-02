<?php

// Pages
Breadcrumbs::register('admin.pages.index', function($breadcrumbs)
{
    $breadcrumbs->push('Admin', route('admin.pages.index'));
});

Breadcrumbs::register('admin.pages.reports', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.pages.index');
    $breadcrumbs->push('Reports', route('admin.pages.reports'));
});

// Posts
Breadcrumbs::register('admin.posts.index', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.pages.index');
    $breadcrumbs->push('Posts', route('admin.posts.index'));
});

Breadcrumbs::register('admin.posts.create', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.posts.index');
    $breadcrumbs->push('Create', route('admin.posts.create'));
});

Breadcrumbs::register('admin.posts.show', function($breadcrumbs, Post $post)
{
    $breadcrumbs->parent('admin.posts.index');
    $breadcrumbs->push($post->title, route('admin.posts.show', $post->slug));
});

Breadcrumbs::register('admin.posts.edit', function($breadcrumbs, Post $post)
{
    $breadcrumbs->parent('admin.posts.show', $post);
    $breadcrumbs->push('Edit', route('admin.posts.edit', $post->slug));
});

// Projects
Breadcrumbs::register('admin.projects.index', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.pages.index');
    $breadcrumbs->push('Projects', route('admin.projects.index'));
});

Breadcrumbs::register('admin.projects.create', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.projects.index');
    $breadcrumbs->push('Create', route('admin.projects.create'));
});

Breadcrumbs::register('admin.projects.show', function($breadcrumbs, Project $project)
{
    $breadcrumbs->parent('admin.projects.index');
    $breadcrumbs->push($project->name, route('admin.projects.show', $project->slug));
});

Breadcrumbs::register('admin.projects.edit', function($breadcrumbs, Project $project)
{
    $breadcrumbs->parent('admin.projects.show', $project);
    $breadcrumbs->push('Edit', route('admin.projects.edit', $project->slug));
});

// Series
Breadcrumbs::register('admin.series.index', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.pages.index');
    $breadcrumbs->push('Series', route('admin.series.index'));
});

Breadcrumbs::register('admin.series.create', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.series.index');
    $breadcrumbs->push('Create', route('admin.series.create'));
});

Breadcrumbs::register('admin.series.show', function($breadcrumbs, Series $series)
{
    $breadcrumbs->parent('admin.series.index');
    $breadcrumbs->push($series->name, route('admin.series.show', $series->slug));
});

Breadcrumbs::register('admin.series.edit', function($breadcrumbs, Series $series)
{
    $breadcrumbs->parent('admin.series.show', $series);
    $breadcrumbs->push('Edit', route('admin.series.edit', $series->slug));
});

// Sessions
Breadcrumbs::register('admin.sessions.create', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.pages.index');
    $breadcrumbs->push('Login', route('admin.sessions.create'));
});

// Users
Breadcrumbs::register('admin.users.index', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.pages.index');
    $breadcrumbs->push('Users', route('admin.users.index'));
});

Breadcrumbs::register('admin.users.create', function($breadcrumbs)
{
    $breadcrumbs->parent('admin.users.index');
    $breadcrumbs->push('Create', route('admin.users.create'));
});

Breadcrumbs::register('admin.users.show', function($breadcrumbs, User $user)
{
    $breadcrumbs->parent('admin.users.index');
    $breadcrumbs->push($user->full_name, route('admin.users.show', $user->id));
});

Breadcrumbs::register('admin.users.edit', function($breadcrumbs, User $user)
{
    $breadcrumbs->parent('admin.users.show', $user);
    $breadcrumbs->push('Edit', route('admin.users.edit', $user->id));
});
