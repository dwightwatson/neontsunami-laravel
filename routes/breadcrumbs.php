<?php

use App\Post;
use App\Project;
use App\Series;
use App\User;

// Pages
Breadcrumbs::for('admin.pages.index', function ($breadcrumbs) {
    $breadcrumbs->add('Admin', route('admin.pages.index'));
});

Breadcrumbs::for('admin.pages.reports', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.pages.index');
    $breadcrumbs->add('Reports', route('admin.pages.reports'));
});

// Posts
Breadcrumbs::for('admin.posts.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.pages.index');
    $breadcrumbs->add('Posts', route('admin.posts.index'));
});

Breadcrumbs::for('admin.posts.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.posts.index');
    $breadcrumbs->add('Create', route('admin.posts.create'));
});

Breadcrumbs::for('admin.posts.show', function ($breadcrumbs, Post $post) {
    $breadcrumbs->parent('admin.posts.index');
    $breadcrumbs->add($post->title, route('admin.posts.show', $post));
});

Breadcrumbs::for('admin.posts.edit', function ($breadcrumbs, Post $post) {
    $breadcrumbs->parent('admin.posts.show', $post);
    $breadcrumbs->add('Edit', route('admin.posts.edit', $post));
});

// Projects
Breadcrumbs::for('admin.projects.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.pages.index');
    $breadcrumbs->add('Projects', route('admin.projects.index'));
});

Breadcrumbs::for('admin.projects.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.projects.index');
    $breadcrumbs->add('Create', route('admin.projects.create'));
});

Breadcrumbs::for('admin.projects.show', function ($breadcrumbs, Project $project) {
    $breadcrumbs->parent('admin.projects.index');
    $breadcrumbs->add($project->name, route('admin.projects.show', $project));
});

Breadcrumbs::for('admin.projects.edit', function ($breadcrumbs, Project $project) {
    $breadcrumbs->parent('admin.projects.show', $project);
    $breadcrumbs->add('Edit', route('admin.projects.edit', $project));
});

// Series
Breadcrumbs::for('admin.series.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.pages.index');
    $breadcrumbs->add('Series', route('admin.series.index'));
});

Breadcrumbs::for('admin.series.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.series.index');
    $breadcrumbs->add('Create', route('admin.series.create'));
});

Breadcrumbs::for('admin.series.show', function ($breadcrumbs, Series $series) {
    $breadcrumbs->parent('admin.series.index');
    $breadcrumbs->add($series->name, route('admin.series.show', $series));
});

Breadcrumbs::for('admin.series.edit', function ($breadcrumbs, Series $series) {
    $breadcrumbs->parent('admin.series.show', $series);
    $breadcrumbs->add('Edit', route('admin.series.edit', $series));
});

// Sessions
Breadcrumbs::for('admin.sessions.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.pages.index');
    $breadcrumbs->add('Login', route('admin.sessions.create'));
});

// Users
Breadcrumbs::for('admin.users.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.pages.index');
    $breadcrumbs->add('Users', route('admin.users.index'));
});

Breadcrumbs::for('admin.users.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.users.index');
    $breadcrumbs->add('Create', route('admin.users.create'));
});

Breadcrumbs::for('admin.users.show', function ($breadcrumbs, User $user) {
    $breadcrumbs->parent('admin.users.index');
    $breadcrumbs->add($user->full_name, route('admin.users.show', $user->id));
});

Breadcrumbs::for('admin.users.edit', function ($breadcrumbs, User $user) {
    $breadcrumbs->parent('admin.users.show', $user);
    $breadcrumbs->add('Edit', route('admin.users.edit', $user->id));
});
