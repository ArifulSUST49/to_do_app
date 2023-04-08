<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("Welcome to Dashboard. You can add to do from here!") }}
                    <x-primary-button type="button" id="addTodoItem" class="ml-3" style="float: right !important; margin-top: -5px;">
                        Add Todo
                    </x-primary-button>
                </div>
            </div>

            @if($errors->any()) 
                <div class="flex items-center bg-blue-500 text-red-100 text-sm font-bold px-4 py-3" role="alert" style="
                    color: white;
                    background: red;
                    border-radius: 5px;
                ">
                    <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M12.432 0c1.34 0 2.01.912 2.01 1.957 0 1.305-1.164 2.512-2.679 2.512-1.269 0-2.009-.75-1.974-1.99C9.789 1.436 10.67 0 12.432 0zM8.309 20c-1.058 0-1.833-.652-1.093-3.524l1.214-5.092c.211-.814.246-1.141 0-1.141-.317 0-1.689.562-2.502 1.117l-.528-.88c2.572-2.186 5.531-3.467 6.801-3.467 1.057 0 1.233 1.273.705 3.23l-1.391 5.352c-.246.945-.141 1.271.106 1.271.317 0 1.357-.392 2.379-1.207l.6.814C12.098 19.02 9.365 20 8.309 20z"></path></svg>
                    <div>Error to save todo! &nbsp;</div>
                    <div>
                        {!! implode(' ', $errors->all('<div>:message</div>')) !!}
                    </div>
                </div>
            @endif

            @if (\Session::has('success'))
                <div class="flex items-center bg-blue-500 text-red-100 text-sm font-bold px-4 py-3" role="alert" style="
                    color: white;
                    background: green;
                    border-radius: 5px;
                ">
                    <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M12.432 0c1.34 0 2.01.912 2.01 1.957 0 1.305-1.164 2.512-2.679 2.512-1.269 0-2.009-.75-1.974-1.99C9.789 1.436 10.67 0 12.432 0zM8.309 20c-1.058 0-1.833-.652-1.093-3.524l1.214-5.092c.211-.814.246-1.141 0-1.141-.317 0-1.689.562-2.502 1.117l-.528-.88c2.572-2.186 5.531-3.467 6.801-3.467 1.057 0 1.233 1.273.705 3.23l-1.391 5.352c-.246.945-.141 1.271.106 1.271.317 0 1.357-.392 2.379-1.207l.6.814C12.098 19.02 9.365 20 8.309 20z"></path></svg>
                    <div>{!! \Session::get('success') !!}</div>
                </div>
            @endif
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 dark:text-gray-100" style="margin-top: 25px;">            
            <div class="flex flex-wrap">
                <div class="relative flex-grow max-w-full flex-1 px-4">
                    <div class="relative flex flex-col min-w-0 rounded break-words border bg-white border-1 border-gray-300">
                        <div class="py-3 px-6 mb-0 bg-gray-200 border-b-1 border-gray-300 text-gray-900 font-bold">
                            Todo Items
                        </div>
                        <div class="flex-auto p-6">
                            <ul class="pl-4 text-slate-900 mi-list">
                                @foreach($pendingTodos as $todo)
                                    <li class="list-item">
                                        <h6><a href="#" class="showTodo" data-value="{{ $todo->title }}" data-target="todoDescription-{{ $todo->id }}"><strong>{{ $todo->title }}</strong></a></h6>
                                        <input type="hidden" value="{{ $todo->description }}" id="todoDescription-{{ $todo->id }}"/>
                                        <form action="{{ route('todo.update', $todo->id) }}" method="post" style="margin-left: 10px;margin-top: -5px;">
                                            @csrf
                                            {{ method_field('PUT') }}
                                            <x-primary-button class="completeTodo" style="background: rgb(14, 165, 233); color: #fff;padding:5px;">
                                                <svg xmlns="http://www.w3.org/2000/svg" style="filter: invert(1);" x="0px" y="0px"
                                                    width="20" height="20"
                                                    viewBox="0 0 32 32">
                                                    <path d="M 16 3 C 8.800781 3 3 8.800781 3 16 C 3 23.199219 8.800781 29 16 29 C 23.199219 29 29 23.199219 29 16 C 29 14.601563 28.8125 13.207031 28.3125 11.90625 L 26.6875 13.5 C 26.886719 14.300781 27 15.101563 27 16 C 27 22.101563 22.101563 27 16 27 C 9.898438 27 5 22.101563 5 16 C 5 9.898438 9.898438 5 16 5 C 19 5 21.695313 6.195313 23.59375 8.09375 L 25 6.6875 C 22.699219 4.386719 19.5 3 16 3 Z M 27.28125 7.28125 L 16 18.5625 L 11.71875 14.28125 L 10.28125 15.71875 L 15.28125 20.71875 L 16 21.40625 L 16.71875 20.71875 L 28.71875 8.71875 Z"></path>
                                                </svg>
                                            </x-primary-button>

                                            <x-primary-button type="button" class="updateTodo" data-value="{{ $todo->title }}" data-target="todoDescription-{{ $todo->id }}" value="{{ route('todo.update', $todo->id) }}" style="margin-top: -5px;padding:5px; background: #373737;">
                                                <img style="filter: invert(1); width: 20px;" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAqElEQVR4nO3VsQmDQBSH8a/MCCEr2FpkiKTRSYT0udJhostYO0JCNjAIOXiNpwT/Hob74LX+uHeikNp5FfACOiDfCnXAYOYNnGPAHs9j4Z0KcjP4U4H6h4fwSoWGcKdG/dRrQktRGe4WoOPcE/pLab3D371IYxnQzqCrfpFsly1PajvGQH0n4GrWLlnvAbgF7lx2p6X67zLVw9zj1Mkl9UADFN+1p/bfBzGDmEoMcDCcAAAAAElFTkSuQmCC">
                                            </x-primary-button>

                                            <x-danger-button type="button" class="deleteTodo" value="{{ route('todo.destroy', $todo->id) }}" style="margin-top: -5px;padding:5px;">
                                                <img style="filter: invert(1); width: 20px;" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAv0lEQVR4nO2VXQrCMBAGxwtalZY86NkVLP6hN6hQCaQgJdXdsFHEDOQt+02TbBooFP6JBrgBB2ChqFsCJ+AK1FrpLBT2YXSAE9S5MHeo8xlqLk8BEvlY6sc5RbyKBE3JY9IuZCRRRwLvwGbUC7E561SpRJ5N+m4rpUdhvvJsK5XKs0qZONNYw31E2ueUu280V/Piykjuubl0wFxeGfwyfYaa1uCR2KeIjwbPos9QU4Uv3iq3zM/dhdp5irhQ+E0ekyummbane5EAAAAASUVORK5CYII=">
                                            </x-danger-button>
                                        </form>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="relative flex-grow max-w-full flex-1 px-4">
                    <div class="relative flex flex-col min-w-0 rounded break-words border bg-white border-1 border-gray-300">
                        <div class="py-3 px-6 mb-0 bg-gray-200 border-b-1 border-gray-300 text-gray-900 font-bold">
                            Completed Todo Items
                        </div>
                        <div class="flex-auto p-6">
                            <ul class="pl-4 text-slate-900 mi-list">
                                @foreach($doneTodos as $todo)
                                    <li class="list-item">
                                        <h6 style="text-decoration: line-through;"><a href="#" class="showTodo" data-value="{{ $todo->title }}" data-target="todoDoneDescription-{{ $todo->id }}"><strong>{{ $todo->title }}</strong></a></h6>
                                        <input type="hidden" value="{{ $todo->description }}" id="todoDoneDescription-{{ $todo->id }}"/>
                                        <x-danger-button type="button" class="deleteTodo" value="{{ route('todo.destroy', $todo->id) }}" style="margin-left: 10px;margin-top: -5px;padding:5px;">
                                            <img style="filter: invert(1); width: 20px;" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAv0lEQVR4nO2VXQrCMBAGxwtalZY86NkVLP6hN6hQCaQgJdXdsFHEDOQt+02TbBooFP6JBrgBB2ChqFsCJ+AK1FrpLBT2YXSAE9S5MHeo8xlqLk8BEvlY6sc5RbyKBE3JY9IuZCRRRwLvwGbUC7E561SpRJ5N+m4rpUdhvvJsK5XKs0qZONNYw31E2ueUu280V/Piykjuubl0wFxeGfwyfYaa1uCR2KeIjwbPos9QU4Uv3iq3zM/dhdp5irhQ+E0ekyummbane5EAAAAASUVORK5CYII=">
                                        </x-danger-button>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div id="ex1" class="modal">
            <form action="{{ route('todo.store') }}" method="post">
                @csrf
                <label class="block">
                    <span class="block text-sm font-medium text-slate-700">Todo Title</span>
                    <input class="border w-100 px-3 py-2 bg-white border shadow-sm border-slate-300 placeholder-slate-400 disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 focus:outline-none focus:border-sky-500 focus:ring-sky-500 block w-full rounded-md sm:text-sm focus:ring-1 invalid:border-pink-500 invalid:text-pink-600 focus:invalid:border-pink-500 focus:invalid:ring-pink-500 disabled:shadow-none" placeholder="Enter title here..." required name="title"/>
                </label>

                <br/>

                <label class="block">
                    <span class="block text-sm font-medium text-slate-700">Todo Description</span>
                    <textarea rows="10" class="border w-100 block p-2.5 w-full text-sm rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Enter description here..." name="description" required></textarea>
                </label>

                <x-primary-button class="mt-3" style="float: right;">
                    {{ __('Save') }}
                </x-primary-button>
            </form>
        </div>

        <div id="ex1Update" class="modal">
            <form action="#" method="post">
                @csrf
                {{ method_field('PUT') }}   
                <label class="block">
                    <span class="block text-sm font-medium text-slate-700">Todo Title</span>
                    <input id="todoEditTitle" class="border w-100 px-3 py-2 bg-white border shadow-sm border-slate-300 placeholder-slate-400 disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 focus:outline-none focus:border-sky-500 focus:ring-sky-500 block w-full rounded-md sm:text-sm focus:ring-1 invalid:border-pink-500 invalid:text-pink-600 focus:invalid:border-pink-500 focus:invalid:ring-pink-500 disabled:shadow-none" placeholder="Enter title here..." required name="title"/>
                </label>

                <br/>

                <label class="block">
                    <span class="block text-sm font-medium text-slate-700">Todo Description</span>
                    <textarea id="todoEditDescription" rows="10" class="border w-100 block p-2.5 w-full text-sm rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Enter description here..." name="description" required></textarea>
                </label>

                <x-primary-button class="mt-3" style="float: right;">
                    {{ __('Update') }}
                </x-primary-button>
            </form>
        </div>

        <div id="ex1Show" class="modal">
            <form action="#" disabled>
                <label class="block">
                    <h5 id="showTodoTitle" style="font-weight: bold;"></h5>
                </label>

                <br/>

                <label class="block">
                    <p id="showTodoDescription"></p>
                </label>
            </form>
        </div>

        <div id="deleteTodo" class="modal">
            <form action="" method="post">
                @csrf
                {{ method_field('DELETE') }}


                <h5>Do you really want to delete the Todo?</h5>
                <a type="button" rel="modal:close" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150 mt-3" style="float: right; margin-left: 10px;">
                    {{ __('Cancel') }}
                </a>

                <x-danger-button class="mt-3" style="float: right;">
                    {{ __('Delete') }}
                </x-danger-button>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function(){
            $("#addTodoItem").on('click', function(){
                $("#ex1").modal({
                    fadeDuration: 300
                });
            });

            $('button.deleteTodo').on('click', function(){
                $("#deleteTodo > form").attr('action', $(this).val());
                $("#deleteTodo").modal({
                    fadeDuration: 300
                });
            });
            
            $('button.updateTodo').on('click', function(){
                $("#ex1Update > form").attr('action', $(this).val());
                let title = $(this).data('value');
                let descriptionId = $(this).data('target');
                let description = $("#"+descriptionId).val();

                $('#todoEditTitle').val(title);
                $('#todoEditDescription').html(description);

                $("#ex1Update").modal({
                    fadeDuration: 300
                });
            });

            $('.showTodo').on('click', function(){
                let title = $(this).data('value');
                let descriptionId = $(this).data('target');
                let description = $("#"+descriptionId).val();
                
                $('#showTodoTitle').html(title);
                $('#showTodoDescription').html(description);
                $("#ex1Show").modal({
                    fadeDuration: 300
                });
            });
        });
    </script>
</x-app-layout>
