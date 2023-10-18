<?php


//Configuration
$dashboard_route=env('DASHBOARD_ROUTE');
$dashboard_theme=env('DASHBOARD_THEME');
$dashboard_theme_dist=env('APP_URL').'public/backend/themes/'.$dashboard_theme.'/';
$frontend_main=env('APP_URL').'public/frontend/';
$gloable_main=env('APP_URL').'public/gloable/';
$api_route='api';
$rows_table_count = 10;
//Theme Variables
$theme_color= env('theme_color');

// Spasfic Permisssions
$spasfic_permissions=[
    'Admin' => [
        1=>'insert',
        2=>'update',
        3=>'view',
        4=>'show',
        5=>'delete',
    ],
    'Roles' => [
        1=>'insert',
        2=>'update',
        3=>'view',
        4=>'show',
        5=>'delete',
    ],
    'Boards' => [
        1=>'insert',
        2=>'update',
        3=>'view',
        4=>'show',
        5=>'delete',
        8=>'Add New Task',
    ],
    'Branches' => [
        1=>'insert',
        2=>'update',
        3=>'view',
        4=>'show',
        5=>'delete',
    ],
    'Countries' => [
        1=>'insert',
        2=>'update',
        3=>'view',
        4=>'show',
        5=>'delete',
    ],
    'Cities' => [
        1=>'insert',
        2=>'update',
        3=>'view',
        4=>'show',
        5=>'delete',
    ],
    'States' => [
        1=>'insert',
        2=>'update',
        3=>'view',
        4=>'show',
        5=>'delete',
    ],
    'Districts' => [
        1=>'insert',
        2=>'update',
        3=>'view',
        4=>'show',
        5=>'delete',
    ],
    'ContactUs' => [
        3=>'view',
        4=>'show',
        5=>'delete',
    ],
    'Settings' => [
        1=>'Gloable Configrations',
        2=>'SEO Configrations',
        3=>'Email Configrations',
        4=>'Payment Configrations',
        5=>'Translations Configrations',
        6=>'Static Pages Configrations',
        7=>'Sochiel Media Links Configrations',
    ],
];
return[
    'dashboard_route'=>$dashboard_route,
    'dashboard_theme'=>$dashboard_theme,
    'dashboard_theme_dist'=>$dashboard_theme_dist,
    'frontend_main'=>$frontend_main,
    'gloable_main'=>$gloable_main,
    'api_route'=>$api_route,
    'spasfic_permissions'=>$spasfic_permissions,
    'rows_table_count' =>$rows_table_count,
];
