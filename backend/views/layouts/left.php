<?php

$questionsTemplate = (($qty = \core\entities\Cabinet\Question::getUnAnsweredQuantity()) > 0) ?
    '<a href="{url}">{icon} {label}<span class="pull-right-container"><small class="label pull-right bg-yellow">' . $qty . '</small></span></a>' :
    '<a href="{url}">{icon} {label}</a>';

?>
<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p><?= Yii::$app->user->identity->username ?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->
        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    ['label' => 'Menu', 'options' => ['class' => 'header']],
                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                    ['label' => 'File Manager', 'icon' => 'folder-open', 'url' => ['site/file-manager']],
                    ['label' => 'Banners', 'icon' => 'photo', 'url' => ['banner/index']],
                    ['label' => 'Pages', 'icon' => 'files-o', 'url' => ['category/index']],
                    ['label' => 'Glossary', 'icon' => 'font', 'url' => ['glossary/index']],
                    ['label' => 'Articles', 'icon' => 'newspaper-o', 'url' => ['article/index']],
                    ['label' => 'Vacancies', 'icon' => 'bullhorn', 'url' => ['vacancy/index']],
                    [
                        'label' => 'Company',
                        'icon' => 'building',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Team', 'icon' => 'users', 'url' => ['team/index']],
                            ['label' => 'Partners', 'icon' => 'handshake-o', 'url' => ['partner/index']],
                            ['label' => 'Gallery', 'icon' => 'camera', 'url' => ['gallery/index']],
                            ['label' => 'Success stories', 'icon' => 'smile-o', 'url' => ['success-story/index']],
                        ],
                    ],
                    [
                        'label' => 'Files',
                        'icon' => 'file-text-o',
                        'url' => '#',
                        'items' => [
                            ['label' => 'HR templates', 'icon' => 'id-card-o', 'url' => ['template/index']],
                            ['label' => 'Documents', 'icon' => 'institution', 'url' => ['document/index']],
                        ],
                    ],
                    [
                        'label' => 'Education',
                        'icon' => 'book',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Webinars', 'icon' => 'youtube-play', 'url' => ['webinar/index']],
                            ['label' => 'Trainings', 'icon' => 'graduation-cap', 'url' => ['training/index']],
                            [
                                'label' => 'Online Tests',
                                'icon' => 'braille',
                                'url' => '#',
                                'items' => [
                                    ['label' => 'Tests', 'icon' => 'pencil-square-o', 'url' => ['online-test/index']],
                                    ['label' => 'Questions', 'icon' => 'list', 'url' => ['test-question/index']],
                                ]
                            ],
                            [
                                'label' => 'Questions',
                                'icon' => 'question-circle-o',
                                'url' => ['question/index'],
                                'template' => $questionsTemplate,
                            ],
                        ],
                    ],
                    [
                        'label' => 'Sales',
                        'icon' => 'legal',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Webinars', 'icon' => 'file-movie-o', 'url' => ['sales/webinar/index']],
                        ],
                    ],
                    ['label' => 'Users', 'icon' => 'user', 'url' => ['user/index']],
                    [
                        'label' => 'System',
                        'icon' => 'gear',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii']],
                            ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug']],
                            ['label' => 'Configuration', 'icon' => 'gears', 'url' => ['config/index']],
                        ],
                    ],
                ],
            ]
        ) ?>

    </section>

</aside>
