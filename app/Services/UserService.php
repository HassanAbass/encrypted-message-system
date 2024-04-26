<?php

namespace App\Services;

use App\Constants\GeneralConstants;
use App\DTOs\Tenant\Entities\Contract\ContractCustomerDTO;
use App\DTOs\Tenant\Entities\Customer\CustomerDTO;
use App\Enums\Customer\CustomerType;
use App\Enums\EntityTypes;
use App\Enums\Permission\CustomerPermission;
use App\Enums\Permission\UserPermission;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\Tenant\Contract\Contract;
use App\Models\Tenant\Customer\Customer;
use App\Models\Tenant\Users\User;
use App\Repositories\CustomerRepository;
use App\Repository\UserRepository;
use App\Services\TenantServices\EconomicService;
use Carbon\Carbon;
use App\HttpClients\CVR\CVRClient;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;
use function App\Services\TenantServices\Customer\tenantAuth;

readonly class UserService
{
    public function __construct(private UserRepository $userRepository)
    {
    }

    public function getToken(string $email): string
    {
        return $this->userRepository->createUserToken($email);
    }

    public function createUser(RegisterUserRequest $request): void
    {
        $this->userRepository->store($request);
    }


}
