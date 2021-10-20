<?php

namespace App\Http\Controllers;

use App\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function index(Todo $todo)
    {

        $ses_id   = (!empty($_SESSION['user_id'])) ? $_SESSION['user_id'] : null;
        $todoList = $todo->where('ses_id', $ses_id)->where('status', '0')->where('deleted_at',null)->get();
        $completed= $todo->where('ses_id', $ses_id)->where('status', '1')->where('deleted_at',null)->get();
        return view('index', ['todolist'=>$todoList,'completed'=>$completed]);
    }

    public function store(Todo $todo)
    {
        $todo->content = trim($_GET['content']);
        $todo->ses_id = (!empty($_SESSION['user_id'])) ? $_SESSION['user_id'] : null;
        $todo->save();
        return $todo->id;
    }

    public function update(Todo $todo)
    {
        try {
            $ses_id         = (!empty($_SESSION['user_id'])) ? $_SESSION['user_id'] : null;
            $id             = intval($_GET['id']);
            $todo           = $todo->where('id',$id)->where('ses_id',$ses_id)->first();
            if(!empty($todo))
            {
                $todo->content  = trim($_GET['content']);
                $todo->save();
                return $todo->content;
            }
        }catch (\Exception $exception)
        {
            return $exception->getMessage();
        }

    }

    public function complete()
    {
        $id = intval($_GET['id']);
        $todo = new Todo();
        $todo = $todo->where('id',$id)->first();
        if($todo->status == 1)
            $todo->status = 0;
        else
            $todo->status = 1;
        $todo->save();
        return 'ok';
    }

    public function delete()
    {
        $id = intval($_GET['id']);
        $todo = new Todo();
        $todo = $todo->where('id',$id)->first();
        $todo->deleted_at = date('Y-m-d H:i:s');
        $todo->save();
        return 'ok';
    }
}
