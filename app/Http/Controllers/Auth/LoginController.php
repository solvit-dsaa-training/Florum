<?php
  
namespace App\Http\Controllers\Auth;
   
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Validator;
   
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
  
    use AuthenticatesUsers;
  
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';
   
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
   

    /**
     * @OA\Post(
     *      path="/login",
     *      operationId="User Login",
     *      tags={"Login"},
     *      summary="Login to the platform",
     *      description="Use email and password to login",
     *      @OA\Response(
     *       response=200,
     *       description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden",
     *      ),
     *       @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="Your email",
     *         required=true,
     *      ),
     *      @OA\Parameter(
     *         name="password",
     *         in="query",
     *         description="Your Password",
     *         required=true,
     *      ),
     *   ),
     */
    
    public function login(Request $request)
    {   
        $input = $request->all();
   
        $validator = Validator::make($request->all(), [ 
            'email' => 'required|email',
            'password' => 'required',
        ]);
      
        if ($validator->fails()) {
          return response()->json($validator->errors(), 422);
        }
   
        if(auth()->attempt(array('email' => $input['email'], 'password' => $input['password'])))
        {
            if (auth()->user()->user_role == "admin") {
                // return redirect()->route('admin.home');
                return "welcome Admin user";
            }else{
                // return redirect()->route('home');
                return "Welcome Normal User";
            }
        }else{
            // return redirect()->route('login')
            //     ->with('error','Email-Address And Password Are Wrong.');
            return "Invalid credentials";
        }
          
    }

    public function createToken()
    {
        
    }
}