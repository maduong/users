<?php namespace Edutalk\Base\Users\Http\Controllers;

use Edutalk\Base\Users\Http\Requests\AuthRequest;
use Edutalk\Base\Users\Support\Traits\Auth;

use Edutalk\Base\Http\Controllers\BaseController;
use Edutalk\Base\Users\Repositories\Contracts\UserRepositoryContract;

class AuthController extends BaseController
{
    use Auth;

    /**
     * @var string
     */
    protected $module = 'edutalk-users';

    /**
     * @var string
     */
    public $username = 'username';

    /**
     * @var string
     */
    public $loginPath = 'auth';

    /**
     * @var string
     */
    public $redirectTo;

    /**
     * @var string
     */
    public $redirectPath;

    /**
     * @var string
     */
    public $redirectToLoginPage;

    /**
     * AuthController constructor.
     * @param \Edutalk\Base\Users\Repositories\UserRepository $userRepository
     */
    public function __construct(UserRepositoryContract $userRepository)
    {
        $this->middleware('Edutalk.guest-admin', ['except' => ['getLogout']]);

        parent::__construct();

        $this->repository = $userRepository;

        $this->redirectTo = route('admin::dashboard.index.get');
        $this->redirectPath = route('admin::dashboard.index.get');
        $this->redirectToLoginPage = route('admin::auth.login.get');

        assets_management()->getAssetsFrom('admin');
    }

    /**
     * Show login page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getLogin()
    {
        $this->setBodyClass('login-page');
        $this->setPageTitle(trans('edutalk-users::auth.sign_in'));

        return $this->view('admin.auth.login');
    }

    /**
     * @param AuthRequest $authRequest
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function postLogin(AuthRequest $authRequest)
    {
        return $this->login($authRequest);
    }

    /**
     * Logout and redirect to login page
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getLogout()
    {
        $this->guard()->logout();

        return redirect()->to($this->redirectToLoginPage);
    }
}
