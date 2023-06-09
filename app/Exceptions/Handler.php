<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        //
    }
	
	/*  public function render($request, Throwable $e)
	{
		$userLevelCheck = $e instanceof \jeremykenedy\LaravelRoles\App\Exceptions\RoleDeniedException ||
			$e instanceof \jeremykenedy\LaravelRoles\App\Exceptions\PermissionDeniedException ||
			$e instanceof \jeremykenedy\LaravelRoles\App\Exceptions\LevelDeniedException;
		
		if ($userLevelCheck) {
			
			if ($request->expectsJson()) {
				return Response::json(array(
					'error'    =>  403,
					'message'   =>  'Unauthorized.'
				), 403);
			}
			
			abort(403);
		}
		
		return parent::render($request, $e);
	} */
}
