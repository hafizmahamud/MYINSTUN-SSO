<?php

require __DIR__.'/breadcrumbs/backend/backend.php';
Breadcrumbs::for('admin.auth.announcements.index', function ($trail) {
    $trail->push('Announcement Management', route('admin.auth.announcements.index'));
});
Breadcrumbs::for('admin.auth.announcements.create', function ($trail) {
    $trail->push('Announcement Management', route('admin.auth.announcements.create'));
});
Breadcrumbs::for('admin.auth.announcements.edit', function ($trail) {
    $trail->push('Announcement Management', route('admin.auth.announcements.edit'));
});
Breadcrumbs::for('admin.auth.announcement.update', function ($trail) {
    $trail->push('Title Here', route('admin.auth.announcement.update','$id'));
});

Breadcrumbs::for('search', function ($trail) {
    $trail->push('Title Here', route('search'));
});
