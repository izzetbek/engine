<?php
namespace common\bootstrap;

use core\repositories\Cabinet\AnswerRepository;
use core\repositories\Cabinet\QuestionRepository;
use core\repositories\OnlineTest\OnlineTestRepository;
use core\repositories\Site\ArticleRepository;
use core\repositories\Site\DocumentRepository;
use core\repositories\Site\GalleryRepository;
use core\repositories\Site\BrandRepository;
use core\repositories\Site\CategoryRepository;
use core\repositories\Site\GlossaryRepository;
use core\repositories\Site\HRTemplateRepository;
use core\repositories\Site\PartnerRepository;
use core\repositories\Site\SuccessStoryRepository;
use core\repositories\Site\TagRepository;
use core\repositories\Site\TeamRepository;
use core\repositories\TrainingRepository;
use core\repositories\UserRepository;
use core\repositories\WebinarRepository;
use core\services\auth\AuthService;
use core\services\auth\NetworkService;
use core\services\auth\PasswordResetService;
use core\services\cabinet\QuestionService;
use core\services\ContactService;
use core\services\manager\OnlineTest\TestManageService;
use core\services\manager\Site\ArticleManageService;
use core\services\manager\Site\DocumentManageService;
use core\services\manager\Site\GalleryManageService;
use core\services\manager\Site\BrandManageService;
use core\services\manager\Site\CategoryManageService;
use core\services\manager\Site\GlossaryManageService;
use core\services\manager\Site\HRTemplateManageService;
use core\services\manager\Site\PartnerManageService;
use core\services\manager\Site\StoryManageService;
use core\services\manager\Site\TagManageService;
use core\services\manager\Site\TeamManageService;
use core\services\manager\TrainingManageService;
use core\services\manager\UserManagerService;
use core\services\manager\WebinarManageService;
use yii\base\BootstrapInterface;
use yii\mail\MailerInterface;

class SetUp implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $container = \Yii::$container;

        $container->setSingleton(MailerInterface::class, function() use($app) {
            return $app->mailer;
        });

        $container->setSingleton(UserRepository::class, function() {
            return new UserRepository();
        });
        $container->setSingleton(TagRepository::class, function() {
            return new TagRepository();
        });
        $container->setSingleton(BrandRepository::class, function() {
            return new BrandRepository();
        });
        $container->setSingleton(CategoryRepository::class, function() {
            return new CategoryRepository();
        });
        $container->setSingleton(GalleryRepository::class, function() {
            return new GalleryRepository();
        });
        $container->setSingleton(PartnerRepository::class, function() {
            return new PartnerRepository();
        });
        $container->setSingleton(TeamRepository::class, function() {
            return new TeamRepository();
        });
        $container->setSingleton(GlossaryRepository::class, function() {
            return new GlossaryRepository();
        });
        $container->setSingleton(ArticleRepository::class, function() {
            return new ArticleRepository();
        });
        $container->setSingleton(SuccessStoryRepository::class, function() {
            return new SuccessStoryRepository();
        });
        $container->setSingleton(HRTemplateRepository::class, function() {
            return new HRTemplateRepository();
        });
        $container->setSingleton(DocumentRepository::class, function() {
            return new DocumentRepository();
        });
        $container->setSingleton(WebinarRepository::class, function() {
            return new WebinarRepository();
        });
        $container->setSingleton(OnlineTestRepository::class, function() {
            return new OnlineTestRepository();
        });
        $container->setSingleton(TrainingRepository::class, function() {
            return new TrainingRepository();
        });

        $container->setSingleton(QuestionRepository::class, function() {
            return new QuestionRepository();
        });
        $container->setSingleton(AnswerRepository::class, function() {
            return new AnswerRepository();
        });

        $container->setSingleton(PasswordResetService::class);
        $container->setSingleton(AuthService::class);
        $container->setSingleton(NetworkService::class);
        $container->setSingleton(ContactService::class, [], [
            $app->params['adminEmail'],
        ]);
        $container->setSingleton(QuestionService::class, [], [
            $app->params['adminEmail'],
        ]);
        $container->setSingleton(WebinarManageService::class);
        $container->setSingleton(UserManagerService::class);
        $container->setSingleton(TagManageService::class);
        $container->setSingleton(BrandManageService::class);
        $container->setSingleton(CategoryManageService::class);
        $container->setSingleton(GalleryManageService::class);
        $container->setSingleton(PartnerManageService::class);
        $container->setSingleton(TeamManageService::class);
        $container->setSingleton(GlossaryManageService::class);
        $container->setSingleton(ArticleManageService::class);
        $container->setSingleton(StoryManageService::class);
        $container->setSingleton(HRTemplateManageService::class);
        $container->setSingleton(DocumentManageService::class);

        $container->setSingleton(TestManageService::class);
        $container->setSingleton(TrainingManageService::class);
    }
}