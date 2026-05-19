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
   public function createTodo(){
    try {
    }
    catch (\Exception $th) {
        Log::error($th->getMessage());
        return HttpStatusEnum::INTERNAL_SERVER_ERROR;
    }
    }
}