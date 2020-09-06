<?php


namespace App\Http\Controllers\v1;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Symfony\Component\HttpFoundation\Response;

class BaseController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function AuthUser()
    {
        try{
            $user = auth()->user();
        } catch (\Exception $e){
            return $e;
        }
        if (!$user){
            return response()->json(['Error' => 'unauthorized'], Response::HTTP_UNAUTHORIZED);
        }

        return $user;
    }
}
