<?php

namespace App\Http\Livewire;

use App\Models\Task;
use Livewire\Component;

class Tasks extends Component
{
    public $lesson_id;

    public function render()
    {
        $tasks = Task::where('lesson_id', $this->lesson_id)->orderBy('display_order')->get();
        return view('livewire.tasks', ['tasks' => $tasks]);
    }

    public function updateOrder($list)
    {
        foreach($list as $item){
            Task::find($item['value'])->update(['display_order' => $item['order']]);
        }
    }

    public function removeTask(Task $task)
    {
        $content = json_decode($task->content, true);
        foreach($content['answers'] as $answer){
            if($answer['image']){
                unlink(public_path('/'.$answer['image']));
            }
            if($answer['audio']){
                unlink(public_path('/'.$answer['audio']));
            }
        }
        $task->delete();
        session()->flash('message', __('Zadatak uspešno obrisan'));
    }
}
