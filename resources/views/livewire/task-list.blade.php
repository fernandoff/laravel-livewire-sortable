
<div class="pt-4 pb-6">

    <!-- LIST PROJECTS -->
    <div class="mb-5">
        <div class="flex items-center justify-between">
            <h3 class="text-2xl font-semibold mt-2 mb-2">
                Project List
                <span class="text-sm text-gray-500 font-normal">({{ $projects->count() }})</span>
            </h3>
            <button wire:click="toggleVisibility" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
                {{ $isOpenProjectsList ? 'Hide' : 'Show' }}
            </button>
        </div>

        @if ($isOpenProjectsList)
            <div class="mt-5">
                <ol class="list-inside space-y-2">
                    @foreach($projects as $project)
                        <li><hr class="opacity-25" /></li>
                        <li class="text-gray-300">
                            <div class="flex justify-between items-center">
                                <span class="block">{{ $project->name }}</span>
                                <div>
                                    <button wire:click="editProject({{ $project->id }})" class="bg-blue-500 text-white py-2 px-2 hover:bg-blue-600 rounded-full">
                                       <svg width="16" height="16" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                                           <rect width="16" height="16" fill="white" fill-opacity="0.01"/>
                                           <path d="M42 26V40C42 41.1046 41.1046 42 40 42H8C6.89543 42 6 41.1046 6 40V8C6 6.89543 6.89543 6 8 6L22 6"
                                                 stroke="#FFFFFF"
                                                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <path d="M14 26.7199V34H21.3172L42 13.3081L34.6951 6L14 26.7199Z"
                                                fill="none" stroke="#FFFFFF" stroke-width="2" stroke-linejoin="round"/></svg>
                                    </button>

                                    <button wire:click="removeProject({{ $project->id }})" class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-2 rounded-full">
                                        <svg style="color: white" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" fill="white"></path>
                                            <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" fill="white"></path>
                                        </svg>

                                    </button>

                                </div>
                            </div>
                        </li>

                    @endforeach
                </ol>
            </div>


        @endif
    </div>

    <hr/>

    <h2 class="text-2xl font-semibold mt-10 mb-4">
        @if($isEditingProject)
            <span>Save</span>
        @else
            <span>Create</span>
        @endif
        Project
    </h2>

    <!-- CREATE PROJECT -->
    <form wire:submit.prevent="saveProject" class="mb-10">
        <div class="flex space-x-4">
            <div class="flex-1">
                <input wire:model="project_name" wire:ignore type="text" id="project_name" class="w-full border border-gray-300 rounded px-3 py-2" placeholder="Project Name">
                @error('project_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            <div class="flex-shrink-0">
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                    @if($isEditingProject)
                        <span>Save</span>
                    @else
                        <span>Create</span>
                    @endif
                    Project</button>
            </div>
        </div>
    </form>

    <hr/>

    <!-- CREATE TASK -->
    <h3 class="text-2xl font-semibold mt-10 mb-4">Create Task</h3>

    <form wire:submit.prevent="createTask" class="mb-10">

        <div class="flex space-x-6">
            <div class="flex-1">
                <input wire:model="name" wire:ignore type="text" id="name" class="w-full border border-gray-300 rounded px-3 py-2" placeholder="Name">

            </div>
            <div class="flex-1">
                <input wire:model="priority" wire:ignore type="number" id="priority" class="w-full border border-gray-300 rounded px-3 py-2" placeholder="Priority">

            </div>
            <div class="flex-3">
                <select wire:model="project_id" wire:change="onSelectProjectToFilter" id="project_id" class="w-full border border-gray-300 rounded px-3 py-2">
                    <option value="">--- select a project ---</option>
                    @foreach($projects as $project)
                        <option value="{{ $project->id }}">{{ $project->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex-shrink-0">
{{--                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Create Task</button>--}}
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Create Task</button>
            </div>
        </div>

        <div class="mt-5">
            @error('name') <span class="text-red-500 text-sm block">{{ $message }}</span> @enderror
            @error('priority') <span class="text-red-500 text-sm block">{{ $message }}</span> @enderror
            @error('project_id') <span class="text-red-500 text-sm block">{{ $message }}</span> @enderror
        </div>
    </form>

    <hr/>

    <!-- TASK LIST -->
    <div class="mt-10">
        <h2 class="text-2xl font-semibold mb-4">
            Task List
            @if(!empty($project_id)) - {{ $projects->where('id', $project_id)->first()?->name ?? '' }} @endif
            @if(!empty($totalTasks)) <span class="text-sm text-gray-500 font-normal">({{ $totalTasks }})</span> @endif
        </h2>
        <div class="flex-3">
            <select wire:model="project_id" wire:change="onSelectProjectToFilter" id="project_id" class="w-full border border-gray-300 rounded px-3 py-2">
                <option value="">--- select a project ---</option>
                @foreach($projects as $project)
                    <option value="{{ $project->id }}">{{ $project->name }} </option>
                @endforeach
            </select>
        </div>

        <ul wire:sortable="updateTaskOrder">

            @if(!empty($project_id) && !empty($tasks) && $tasks->count() == 0)

                <li class="text-gray-400 text-lg pt-4"> No tasks on this project yet</li>

            @elseif($tasks?->count() > 0)

                <li class="py-4 flex items-center font-semibold">
                    <div class="w-1/5">Sort</div>
                    <div class="w-1/5">Priority</div>
                    <div class="w-2/5">Name</div>
                    <div class="w-1/5 text-center">Actions</div>
                </li>
                <li>
                    <hr class="mb-5">
                </li>
                <!-- Task Rows -->
                @foreach($tasks as $task)
                    <li wire:sortable.item="{{ $task->id }}" wire:key="task-{{ $task->id }}" class="py-1 flex items-center">
                        <div wire:sortable.handle class="w-1/5 hover:cursor-pointer">
                            <span class="px-4 py-1 inline-block">
                                <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg"> <path fill-rule="evenodd" clip-rule="evenodd" d="M1.5 5.5C1.5 4.94772 1.94772 4.5 2.5 4.5C3.05228 4.5 3.5 4.94772 3.5 5.5C3.5 6.05228 3.05228 6.5 2.5 6.5C1.94772 6.5 1.5 6.05228 1.5 5.5ZM6.5 5.5C6.5 4.94772 6.94772 4.5 7.5 4.5C8.05228 4.5 8.5 4.94772 8.5 5.5C8.5 6.05228 8.05228 6.5 7.5 6.5C6.94772 6.5 6.5 6.05228 6.5 5.5ZM11.5 5.5C11.5 4.94772 11.9477 4.5 12.5 4.5C13.0523 4.5 13.5 4.94772 13.5 5.5C13.5 6.05228 13.0523 6.5 12.5 6.5C11.9477 6.5 11.5 6.05228 11.5 5.5ZM1.5 9.5C1.5 8.94772 1.94772 8.5 2.5 8.5C3.05228 8.5 3.5 8.94772 3.5 9.5C3.5 10.0523 3.05228 10.5 2.5 10.5C1.94772 10.5 1.5 10.0523 1.5 9.5ZM6.5 9.5C6.5 8.94772 6.94772 8.5 7.5 8.5C8.05228 8.5 8.5 8.94772 8.5 9.5C8.5 10.0523 8.05228 10.5 7.5 10.5C6.94772 10.5 6.5 10.0523 6.5 9.5ZM11.5 9.5C11.5 8.94772 11.9477 8.5 12.5 8.5C13.0523 8.5 13.5 8.94772 13.5 9.5C13.5 10.0523 13.0523 10.5 12.5 10.5C11.9477 10.5 11.5 10.0523 11.5 9.5Z" fill="white"/> </svg>
                            </span>
                        </div>
                        <div class="w-1/5">
                            <span class="px-4 py-1 inline-block">{{ $task->priority }}</span>
                        </div>
                        <div class="w-2/5">
                            <span class="px-4 py-1 inline-block">{{ $task->name }}</span>
                        </div>
                        <div class="w-1/5 flex justify-center">

                            <button wire:click="editTask({{ $task->id }})" class="mr-1 bg-blue-500 text-white py-2 px-2 hover:bg-blue-600 rounded-full">
                                <svg width="16" height="16" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="16" height="16" fill="white" fill-opacity="0.01"/>
                                    <path d="M42 26V40C42 41.1046 41.1046 42 40 42H8C6.89543 42 6 41.1046 6 40V8C6 6.89543 6.89543 6 8 6L22 6"
                                          stroke="#FFFFFF"
                                          stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M14 26.7199V34H21.3172L42 13.3081L34.6951 6L14 26.7199Z"
                                          fill="none" stroke="#FFFFFF" stroke-width="2" stroke-linejoin="round"/></svg>
                            </button>

                            <button wire:click="removeTask({{ $task->id }})" class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-2 rounded-full">
                                <svg style="color: white" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" fill="white"></path>
                                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" fill="white"></path>
                                </svg>
                            </button>
                        </div>
                    </li>
                @endforeach
            @endif
        </ul>
    </div>

    <button wire:click="debug" class="mt-10 bg-orange-500 text-white px-4 rounded hover:bg-orange-600">DEBUG</button>


</div>

