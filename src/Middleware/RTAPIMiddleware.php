<?php


namespace RTMatt\MonthlyService\Middleware;

use Closure;

class RTAPIMiddleware
{

    protected $guard;


    function __construct(\RTMatt\MonthlyService\Contracts\RTGuardContract $guard)
    {
        $this->guard = $guard;
    }


    protected $excluded=[
        
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     *
     * @return mixed
     */
    public function handle(\Illuminate\Http\Request $request, Closure $next)
    {

        if(in_array($request->path(),$this->excluded)){
            return $next($request);
        }
        $authorization_header = $request->header('authorization');

        if ( ! $authorization_header) {
            return response('Get outta here with that unauthenticated crap.', 401);
        }
        if ($client = $this->check($authorization_header)) {
            $request->merge(compact('client'));
            return $next($request);
        }
        return response('You ain\'t provided the correct authentication shits', 403);

    }


    private function check($authorization_header)
    {
        $result = $this->guard->check($authorization_header);
        if($result){
            return $result;
        }
        return false;

    }
}
