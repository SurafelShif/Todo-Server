<?php

namespace App\Http\Controllers;

use App\Http\Requests\createTodoRequest;
use App\Http\Requests\TodoRequest;
use App\Http\Requests\updateTodoRequest;
use App\HttpStatusEnum;
use App\Services\TodoService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
class TodoController extends Controller
{
    public function __construct(private TodoService $todo_service){}
    
    public function getTodos($filter){
        $result = $this->todo_service->getTodos($filter);
            if($result instanceof HttpStatusEnum){
                return match ($result){
                    HttpStatusEnum::INTERNAL_SERVER_ERROR => response()->json(["message"=>"שגיאת שרת"],Response::HTTP_INTERNAL_SERVER_ERROR),
                };
            }
            return response()->json($result,Response::HTTP_OK);
    }
    public function createTodo(createTodoRequest $request){
        $result=$this->todo_service->createTodo($request->name);
         if($result instanceof HttpStatusEnum){
                return match ($result){
                    HttpStatusEnum::INTERNAL_SERVER_ERROR => response()->json(["message"=>"שגיאת שרת"],Response::HTTP_INTERNAL_SERVER_ERROR),
                };
            }
            return response()->json($result,Response::HTTP_CREATED);
    }
    public function updateTodo($id,updateTodoRequest $request){
        $result =$this->todo_service->updateTodo($id,$request->name,$request->is_finished);
            if($result instanceof HttpStatusEnum){
                return match ($result){
                    HttpStatusEnum::INTERNAL_SERVER_ERROR => response()->json(["message"=>"שגיאת שרת"],Response::HTTP_INTERNAL_SERVER_ERROR),
                    HttpStatusEnum::NOT_FOUND => response()->json(["message"=>"מטלה לא נמצאה"],Response::HTTP_NOT_FOUND),
                };
            }
            return response()->json($result,Response::HTTP_OK);
    }
    public function deleteTodo($id){
        $result=$this->todo_service->deleteTodo($id);
        if($result instanceof HttpStatusEnum){
            return match ($result){
                HttpStatusEnum::INTERNAL_SERVER_ERROR => response()->json(["message"=>"שגיאת שרת"],Response::HTTP_INTERNAL_SERVER_ERROR),
                HttpStatusEnum::NOT_FOUND => response()->json(["message"=>"מטלה לא נמצאה"],Response::HTTP_NOT_FOUND),
            };
        }
        return response()->json("מטלה נמחקה",Response::HTTP_OK);

    }


}
