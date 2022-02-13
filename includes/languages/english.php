<?php
function lang($phrase){
    static $lang = array(
        //dashboard page
        'HOME_ADMIN' => 'Home',
        'CATEGORIES' => 'Categories',
        'ITEMS'      => 'items',
        'MEMBERS'    => 'Members',
        'COMMENTS'   => 'Comments',
        'STATISTIC'  => 'Statistic',
        'LOGS'       => 'Logs'
    );
    return $lang[$phrase];
}