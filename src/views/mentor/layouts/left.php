<?php
$tasks = \qviox\mentor\models\scores\Task::getNewTaskForQuestionnaire();


foreach ($tasks as $task) {
    $menuItems[] = [
        'label' => $task->name,
        'icon' => 'users',
        'url' => ['/mentor/task-questionnaire/task', 'taskId' => $task->id]
    ];
}

?>

<aside class="main-sidebar">

    <section class="sidebar">

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget' => 'tree'],
                'items' => [
                    ['label' => 'Участники', 'icon' => 'user', 'url' => ['/mentor/participants']],
                    ['label' => 'Команды', 'icon' => 'users', 'url' => ['/mentor/team']],

                    ['label' => 'Ответы на задания', 'icon' => 'gears',
                        'items' => $menuItems
                    ],
                ],
            ]
        ) ?>

    </section>
</aside>


<style>
    .treeview-menu > li {
        white-space: normal !important;
    }
</style>