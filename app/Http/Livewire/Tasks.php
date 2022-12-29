<?php

namespace App\Http\Livewire;

use Exception;
use App\Models\Task;
use Livewire\Component;
use Illuminate\Support\Facades\Log;

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
        foreach ($list as $item) {
            Task::find($item['value'])->update(['display_order' => $item['order']]);
        }
    }

    public function removeTask(Task $task)
    {
        $content = json_decode($task->content, true);
        $answers = isset($content['answers']) ? $content['answers'] : [];

        try {
            if ($task->type == 'column_sorting') {
                $columns = isset($content['columns']) ? $content['columns'] : [];
                foreach ($columns as $column) {
                    if ($column['image']) {
                        unlink(public_path('/' . $column['image']));
                    }
                    if ($column['audio']) {
                        unlink(public_path('/' . $column['audio']));
                    }
                }
            } else {
                foreach ($answers as $answer) {
                    if ($answer['image']) {
                        unlink(public_path('/' . $answer['image']));
                    }
                    if ($answer['audio']) {
                        unlink(public_path('/' . $answer['audio']));
                    }
                }
            }
            $task->delete();
            session()->flash('message', __('Zadatak uspešno obrisan'));
        } catch (Exception $e) {
            Log::channel('errors')->error('Greška prilikom brisanja zadatka: ' . $e->getMessage());
            session()->flash('error', __('Došlo je do greške. Pokušajte ponovo.'));
        }
    }
}
