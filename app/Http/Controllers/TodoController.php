<?php

namespace App\Http\Controllers;

use App\HttpStatusEnum;
use App\Services\TodoService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
class TodoController extends Controller
{
    public function __construct(private TodoService $todo_service){}
    
    public function getTodos(){
            $result = $this->todo_service->getTodos();
            if($result instanceof HttpStatusEnum){
                return match ($result){
                    HttpStatusEnum::INTERNAL_SERVER_ERROR => response()->json(["message"=>"שגיאת שרת"],Response::HTTP_INTERNAL_SERVER_ERROR),
                };
            }
            return response()->json($result,Response::HTTP_OK);
    }
}
