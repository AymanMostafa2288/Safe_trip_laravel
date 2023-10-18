<?php

namespace App\Providers;

use App\Repositories\Eloquent\builder_management\ModuleRepository;
use App\Repositories\Eloquent\builder_management\ModuleFieldsRepository;
use App\Repositories\Eloquent\builder_management\CounterRepository;
use App\Repositories\Eloquent\builder_management\ReportRepository;
use App\Repositories\Eloquent\builder_management\ChartRepository;
use App\Repositories\Eloquent\builder_management\TeansfareRepository;

use App\Repositories\Eloquent\database_management\SettingRepository;
use App\Repositories\Eloquent\database_management\TablesRepository;

use App\Repositories\Eloquent\setting_management\GeneralRepository;
use App\Repositories\Eloquent\setting_management\LanguageRepository;
use App\Repositories\Eloquent\setting_management\CodeRepository;
use App\Repositories\Eloquent\setting_management\SeoRepository;


use App\Repositories\Interfaces\builder_management\ModuleInterface;
use App\Repositories\Interfaces\builder_management\ModuleFieldsInterface;
use App\Repositories\Interfaces\builder_management\CounterInterface;
use App\Repositories\Interfaces\builder_management\ReportInterface;
use App\Repositories\Interfaces\builder_management\ChartInterface;
use App\Repositories\Interfaces\builder_management\TeansfareInterface;
use App\Repositories\Interfaces\builder_management\NotificationInterface;
use App\Repositories\Eloquent\builder_management\NotificationRepository;

use App\Repositories\Interfaces\database_management\SettingInterface;
use App\Repositories\Interfaces\database_management\TablesInterface;

use App\Repositories\Interfaces\setting_management\GeneralInterface;
use App\Repositories\Interfaces\setting_management\LanguageInterface;
use App\Repositories\Interfaces\setting_management\CodeInterface;
use App\Repositories\Interfaces\setting_management\SeoInterface;

use App\Repositories\Interfaces\admin_management\RoleInterface;
use App\Repositories\Eloquent\admin_management\RoleRepository;

use App\Repositories\Interfaces\admin_management\AdminInterface;
use App\Repositories\Eloquent\admin_management\AdminRepository;

use App\Repositories\Interfaces\admin_management\BranchInterface;
use App\Repositories\Eloquent\admin_management\BranchRepository;


use App\Repositories\Interfaces\locations_management\DistrictsInterface;
use App\Repositories\Eloquent\locations_management\DistrictsRepository;

use App\Repositories\Interfaces\locations_management\CitiesInterface;
use App\Repositories\Eloquent\locations_management\CitiesRepository;

use App\Repositories\Interfaces\locations_management\CountriesInterface;
use App\Repositories\Eloquent\locations_management\CountriesRepository;

use App\Repositories\Interfaces\locations_management\StatesInterface;
use App\Repositories\Eloquent\locations_management\StatesRepository;

use App\Repositories\Interfaces\task_management\TasksInterface;
use App\Repositories\Eloquent\task_management\TasksRepository;

use App\Repositories\Interfaces\task_management\BoardsInterface;
use App\Repositories\Eloquent\task_management\BoardsRepository;

use App\Repositories\Interfaces\ticket_support_management\ContactUsInterface;
use App\Repositories\Eloquent\ticket_support_management\ContactUsRepository;



//put Here singleton Path

use App\Repositories\Interfaces\custom_modules_management\Packages\PackageInterface;
use App\Repositories\Eloquent\custom_modules_management\Packages\PackageRepository;


use App\Repositories\Interfaces\custom_modules_management\Routes\RouteInterface;
use App\Repositories\Eloquent\custom_modules_management\Routes\RouteRepository;


use App\Repositories\Interfaces\custom_modules_management\Schools\SchoolInterface;
use App\Repositories\Eloquent\custom_modules_management\Schools\SchoolRepository;


use App\Repositories\Interfaces\custom_modules_management\Buses\BusInterface;
use App\Repositories\Eloquent\custom_modules_management\Buses\BusRepository;


use App\Repositories\Interfaces\custom_modules_management\Supervisors\SupervisorInterface;
use App\Repositories\Eloquent\custom_modules_management\Supervisors\SupervisorRepository;


use App\Repositories\Interfaces\custom_modules_management\Drivers\DriverInterface;
use App\Repositories\Eloquent\custom_modules_management\Drivers\DriverRepository;


use App\Repositories\Interfaces\custom_modules_management\Students\StudentInterface;
use App\Repositories\Eloquent\custom_modules_management\Students\StudentRepository;


use App\Repositories\Interfaces\custom_modules_management\Parents\ParentsInterface;
use App\Repositories\Eloquent\custom_modules_management\Parents\ParentRepository;










//putHere uses
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->singleton(TablesInterface::class, TablesRepository::class);
        $this->app->singleton(SettingInterface::class, SettingRepository::class);


        $this->app->singleton(ModuleFieldsInterface::class, ModuleFieldsRepository::class);
        $this->app->singleton(ModuleInterface::class, ModuleRepository::class);
        $this->app->singleton(CounterInterface::class, CounterRepository::class);
        $this->app->singleton(ReportInterface::class, ReportRepository::class);
        $this->app->singleton(ChartInterface::class, ChartRepository::class);
        $this->app->singleton(NotificationInterface::class, NotificationRepository::class);
        $this->app->singleton(TeansfareInterface::class, TeansfareRepository::class);


        $this->app->singleton(GeneralInterface::class, GeneralRepository::class);
        $this->app->singleton(LanguageInterface::class, LanguageRepository::class);
        $this->app->singleton(CodeInterface::class, CodeRepository::class);
        $this->app->singleton(SeoInterface::class, SeoRepository::class);


        $this->app->singleton(RoleInterface::class, RoleRepository::class);
        $this->app->singleton(AdminInterface::class, AdminRepository::class);
        $this->app->singleton(BranchInterface::class, BranchRepository::class);

        $this->app->singleton(DistrictsInterface::class, DistrictsRepository::class);
        $this->app->singleton(CitiesInterface::class, CitiesRepository::class);
        $this->app->singleton(CountriesInterface::class, CountriesRepository::class);
        $this->app->singleton(StatesInterface::class, StatesRepository::class);

        $this->app->singleton(TasksInterface::class, TasksRepository::class);
        $this->app->singleton(BoardsInterface::class, BoardsRepository::class);

//put Here singleton

$this->app->singleton(PackageInterface::class, PackageRepository::class);

$this->app->singleton(RouteInterface::class, RouteRepository::class);

$this->app->singleton(SchoolInterface::class, SchoolRepository::class);

$this->app->singleton(BusInterface::class, BusRepository::class);

$this->app->singleton(SupervisorInterface::class, SupervisorRepository::class);

$this->app->singleton(DriverInterface::class, DriverRepository::class);

$this->app->singleton(StudentInterface::class, StudentRepository::class);

$this->app->singleton(ParentsInterface::class, ParentRepository::class);

$this->app->singleton(ContactUsInterface::class, ContactUsRepository::class);








    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

    }
}
