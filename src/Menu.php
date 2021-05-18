<?php
namespace qviox\mentor;
use qviox\mentor\models\rbac\URole;

class Menu{
    public function getAdminMenu(){

        if(URole::checkUserAccess('RBAC'))
            $items[]=['label' => 'Управление ролями', 'icon' => 'user', 'url' => ['/mentor/rbac/user-role']];
        $items[]=['label' => 'Участники', 'icon' => 'user', 'url' => ['/mentor/admin/participants']];
        $items[]=['label' => 'Команды', 'icon' => 'users', 'url' => ['/mentor/admin/team']];
        $items[]=['label' => 'Задания', 'icon' => 'book', 'url' => ['/mentor/admin/task']];
        $items[]=['label' => 'Список навыков', 'icon' => 'calendar', 'url' => ['/mentor/admin/skill']];
        $items[]=['label' => 'Список сессий', 'icon' => 'calendar', 'url' => ['/mentor/admin/skill-session']];

        return
            ['label' => 'Меню конкурса', 'icon' => 'calendar ',
            'items' => $items];
    }
}