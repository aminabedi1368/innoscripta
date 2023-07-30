<?php
namespace App\Http\Controllers\Api;

use App\Managers\ReportManager;
use App\Models\AccessTokenModel;
use App\Models\BadLoginModel;
use App\Models\ProjectModel;
use App\Models\UserModel;
use Illuminate\Http\JsonResponse;

/**
 * Class IndexController
 * @package App\Http\Controllers\Api
 */
class IndexController
{
    /**
     * @var ReportManager
     */
    private ReportManager $reportManager;

    /**
     * IndexController constructor.
     * @param ReportManager $reportManager
     */
    public function __construct(ReportManager $reportManager)
    {
        $this->reportManager = $reportManager;
    }

    /**
     * @return JsonResponse
     */
    public function stats(): JsonResponse
    {
        $projectCount = ProjectModel::query()->count();
        $userCount = UserModel::query()->count();
        $loginCount = AccessTokenModel::query()->count();
        $badLoginCount = BadLoginModel::query()->count();

        $userRegisterMonthly = $this->reportManager->userRegisterPerMonth();
        $userRegisterWeekly = $this->reportManager->userRegisterPerWeek();
        $userRegisterDaily = $this->reportManager->userRegisterPerDay();

        return response()->json(compact(
            'projectCount',
            'userCount',
            'loginCount',
            'badLoginCount',
            'userRegisterMonthly',
            'userRegisterWeekly',
            'userRegisterDaily'
        ));
    }

}
