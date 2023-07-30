<?php
namespace App\Actions\UserIdentifier;

use App\Entities\UserIdentifierEntity;
use App\Exceptions\CorruptedDataException;
use App\Repos\UserIdentifierRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Class GetUserIdentifierAction
 * @package App\Actions\UserIdentifier
 */
class GetUserIdentifierAction
{

    /**
     * @var UserIdentifierRepository
     */
    private UserIdentifierRepository $userIdentifierRepository;

    /**
     * GetUserIdentifierAction constructor.
     * @param UserIdentifierRepository $userIdentifierRepository
     */
    public function __construct(UserIdentifierRepository $userIdentifierRepository)
    {
        $this->userIdentifierRepository = $userIdentifierRepository;
    }

    /**
     * @param string $type
     * @param string $value
     * @param bool $throwException
     * @return UserIdentifierEntity|null
     * @throws CorruptedDataException
     */
    public function __invoke(string $type, string $value, bool $throwException = false): ?UserIdentifierEntity
    {
        if($throwException) {
            return $this->exec($type, $value);
        }
        else {
            try {
                return $this->exec($type, $value);
            }
            catch (ModelNotFoundException) {
                return null;
            }
        }

    }

    /**
     * @param string $type
     * @param string $value
     * @return UserIdentifierEntity|null
     */
    private function exec(string $type, string $value)
    {
        return $this->userIdentifierRepository->findByTypeAndValue($type, $value);
    }

}
