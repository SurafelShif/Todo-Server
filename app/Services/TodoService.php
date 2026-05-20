<?php

namespace App\Services;

use App\HttpStatusEnum;
use App\Models\Todo;
use Illuminate\Support\Facades\Log;

class TodoService{
   public function getTodos(){
        try {
            $todos=Todo::select(["id","name","is_finished","created_at"])->get();
            return $todos;
        } catch (\Exception $th) {
            Log::error($th->getMessage());
            return HttpStatusEnum::INTERNAL_SERVER_ERROR;
        }

   }
   public function createTodo(string $name){
    try {
        $result=Todo::create([
            "name"=> $name,
        ]);
        return $result;
    }
    catch (\Exception $th) {
        Log::error($th->getMessage());
        return HttpStatusEnum::INTERNAL_SERVER_ERROR;
        }
    }
    public function updateTodo(int $id,string | null $name,bool | null $is_finished){
        try {
            $todo=Todo::find($id);
            if(!$todo){
                return HttpStatusEnum::NOT_FOUND;
            }
            if($name !== null){
                $todo->name=$name;
            }
            if($is_finished !== null){
                $todo->is_finished=$is_finished;
            }
            $todo->save();
            return "update todo";
        }
        catch (\Exception $th) {
            Log::error($th->getMessage());
            return HttpStatusEnum::INTERNAL_SERVER_ERROR;
        }

    }
}