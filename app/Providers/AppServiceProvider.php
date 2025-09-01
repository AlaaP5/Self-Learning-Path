<?php

namespace App\Providers;

use App\Repositories\Classes\ConceptRepo;
use App\Repositories\Classes\ExamRepo;
use App\Repositories\Classes\GradeRepo;
use App\Repositories\Classes\StudentRepo;
use App\Repositories\Classes\SubjectRepo;
use App\Repositories\Interfaces\ConceptRepoInterface;
use App\Repositories\Interfaces\ExamRepoInterface;
use App\Repositories\Interfaces\GradeRepoInterface;
use App\Repositories\Interfaces\StudentRepoInterface;
use App\Repositories\Interfaces\SubjectRepoInterface;
use App\Services\Classes\ExamService;
use App\Services\Classes\ExpertSystemService;
use App\Services\Classes\StudentAnalysisService;
use App\Services\Interfaces\ExamServiceInterface;
use App\Services\Interfaces\ExpertSystemServiceInterface;
use App\Services\Interfaces\StudentAnalysisServiceInterface;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Grade Repo
        $this->app->bind(GradeRepoInterface::class, GradeRepo::class);

        // Subject Repo
        $this->app->bind(SubjectRepoInterface::class, SubjectRepo::class);

        // Concept Repo
        $this->app->bind(ConceptRepoInterface::class, ConceptRepo::class);

        // Expert System Service
        $this->app->bind(ExpertSystemServiceInterface::class, ExpertSystemService::class);

        // Student Repo
        $this->app->bind(StudentRepoInterface::class, StudentRepo::class);

        // Student Analysis Service
        $this->app->bind(StudentAnalysisServiceInterface::class, StudentAnalysisService::class);

        // Exam Service
        $this->app->bind(ExamServiceInterface::class, ExamService::class);

        // Exam Repo
        $this->app->bind(ExamRepoInterface::class, ExamRepo::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
