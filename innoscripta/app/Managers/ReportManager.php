<?php
namespace App\Managers;

use App\Models\UserModel;
use Illuminate\Database\Connection;

/**
 * Class ReportManager
 * @package App\Managers
 */
class ReportManager
{
    /**
     * @var Connection
     */
    private Connection $connection;

    /**
     * ReportManager constructor.
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @return array
     */
    public function userRegisterPerMonth(): array
    {
         return UserModel::query()
            ->select('year_month', $this->connection->raw('count(*) as total'))
            ->groupby('year_month')
            ->get()->toArray();
    }

    public function userRegisterPerDay(): array
    {
        return UserModel::query()
            ->select('year_month_day', $this->connection->raw('count(*) as total'))
            ->groupby('year_month_day')
            ->get()->toArray();
    }

    public function userRegisterPerWeek(): array
    {
        return UserModel::query()
            ->select('year_week', $this->connection->raw('count(*) as total'))
            ->groupby('year_week')
            ->get()->toArray();
    }

}
