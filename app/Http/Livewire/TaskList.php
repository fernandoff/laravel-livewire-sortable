<?php

namespace App\Http\Livewire;

use Illuminate\Validation\Rule;
use Livewire\Component;
use App\Models\Task;
use App\Models\Project;

class TaskList extends Component
{
    public $projects;
    public $tasks;

    public $task_id;
    public $name;
    public $priority;

    public $project_id;
    public $project_name;

    public $totalTasks;
    public $totalProjects;

    public $isOpenProjectsList = false;
    public $isEditingProject = false;
    public $isEditingTask = false;

    public function mount()
    {
        $this->getProjects();
    }

    public function render()
    {
        return view('livewire.task-list');
    }

    public function getProjects(){
        $query = Project::orderBy('name')
            ->withCount('tasks');

        $this->projects = $query->get();

        $this->totalProjects = $query->count();

        $this->getTasks();
    }

    public function getTasks(){
        $query =
            Task::orderBy('project_id', 'asc')
            ->where('project_id', $this->project_id)
            ->orderBy('priority', 'asc');

        $this->totalTasks = $query->count();

        $this->tasks = $query->get();
    }

    public function createTask()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'priority' => 'nullable|integer',
            'project_id' => 'required|exists:projects,id',
        ]);

        Task::create([
            'name' => $this->name,
            'priority' => empty($this->priority) ? Task::where('project_id', $this->project_id)->max('priority') + 1 : $this->priority,
            'project_id' => $this->project_id,
        ]);

        $this->name = '';
        $this->priority = '';

        $this->getTasks();
        $this->getProjects();
        $this->render();
    }

    public function saveProject()
    {
        $this->validate([
            'project_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('projects', 'name')->whereNull('deleted_at')->ignore($this->project_id),
            ],
        ]);

        if(empty($this->project_id) || $this->isEditingProject == false){
            Project::create([
                'name' => $this->project_name,
            ]);
        } else {
            Project::find($this->project_id)->update([
                'name' => $this->project_name,
            ]);
        }

        $this->isEditingProject = false;
        $this->project_name = null;
        $this->project_id = null;

        $this->getProjects();
        $this->getTasks();
        $this->render();
    }

    public function updateTaskOrder($list){

        $this->validate([
            'tasks.*.id' => 'required|exists:tasks,id',
        ]);

        foreach($list as $task){
            Task::find($task['value'])->update([
                'priority' => $task['order'],
            ]);
        }

        $this->getTasks();

        $this->render();
    }

    public function removeTask($taskId){
        Task::find($taskId)->delete();
        $this->getTasks();
        $this->render();
    }

    public function removeProject($project_id)
    {
        Project::find($project_id)->delete();

        $this->project_id = null;
        $this->getProjects();
        $this->render();
    }

    public function onSelectProjectToFilter()
    {
        if(empty($this->project_id)){
            $this->tasks = null;
        } else {
            $this->getTasks($this->project_id);
        }

        $this->getProjects();
        $this->render();
    }

    public function toggleVisibility()
    {
        $this->getProjects();
        //$this->project_id = null;
        $this->isOpenProjectsList = !$this->isOpenProjectsList;
    }

    public function editProject($project_id)
    {
        $this->project_id = $project_id;
        $this->project_name = $this->projects->find($project_id)->name;
        $this->isEditingProject = true;
    }

    public function debug()
    {
        dump([
            'name' => $this->name,
            'priority' => $this->priority,
            'project_id' => $this->project_id,
            'project_name' => $this->project_name,
            'currentFilteredProject' => $this->project_id,
            'tasks' => $this->tasks?->toArray(),
            'projects' => $this->projects?->toArray(),
            'totalTasks' => $this->totalTasks,
            'totalProjects' => $this->totalProjects,
            'isOpenProjectsList' => $this->isOpenProjectsList,
            'isEditingProject' => $this->isEditingProject,
            'isEditingTask' => $this->isEditingTask

        ]);

        dump([
            'DB Tasks' => Task::orderBy('project_id', 'asc')->get()->toArray(),
        ]);
    }
}

