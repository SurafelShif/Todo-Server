<?php

namespace App\Services;

use App\HttpStatusEnum;
use App\Models\Todo;
use Illuminate\Support\Facades\Log;

class TodoService{

   public function getTodos($filter)
{
    try {
        $query = Todo::query()
            ->where("is_deleted", false)
            ->select(["id", "name", "is_finished", "created_at"]);

        if ($filter === "finished") {
            $query->where("is_finished", true);
        }

        if ($filter === "unfinished") {
            $query->where("is_finished", false);
        }

        return $query->get();

    } catch (\Exception $e) {
        Log::error($e->getMessage());
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
            $todo=Todo::where("is_deleted",false)->find($id);

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
            return $todo;
        }
        catch (\Exception $th) {
            Log::error($th->getMessage());
            return HttpStatusEnum::INTERNAL_SERVER_ERROR;
        }

    }
    public function deleteTodo(int $id){
    try { 
        $todo=Todo::where("is_deleted",false)->find($id);
        if(!$todo){
            return HttpStatusEnum::NOT_FOUND;
        }
        $todo->is_deleted=true;
        $todo->save();
        return $todo;
    } catch (\Exception $th) {
        Log::error($th->getMessage());
        return HttpStatusEnum::INTERNAL_SERVER_ERROR;

    }
}
}