<?php
namespace qviox\mentor;
use qviox\mentor\models\rbac\URole;
use qviox\mentor\models\scores\Task;

class Menu{
    public static function getAdminMenu(){
        $role_control=[];
        if(URole::checkUserAccess('RBAC'))
            $role_control=['label' => 'Управление ролями', 'icon' => 'gear', 'url' => ['/mentor/rbac/user-role']];
        $items[]=['label' => 'Участники', 'icon' => 'user', 'url' => ['/mentor/admin/participants']];
        $items[]=['label' => 'Команды', 'icon' => 'users', 'url' => ['/mentor/admin/team']];
        $items[]=['label' => 'Задания', 'icon' => 'book', 'url' => ['/mentor/admin/task']];
        $items[]=['label' => 'Список навыков', 'icon' => 'calendar', 'url' => ['/mentor/admin/skill']];
        $items[]=['label' => 'Список сессий', 'icon' => 'calendar', 'url' => ['/mentor/admin/skill-session']];


        return
            [
                'label' => 'Ментор', 'icon' => 'child',
                'items' =>   [
                        $role_control,
                        ['label' => 'Меню конкурса', 'icon' => 'calendar ', 'items' => $items],
                        ['label' => 'Анкеты Конкурсного отбора', 'icon' => 'certificate', 'url' => ['/mentor/admin/competition-questionnaire']],
                        ['label' => 'Разное', 'icon' => 'gears ', 'items' => Task::getTaskListForMenu() ]
                ]
            ];
    }
}