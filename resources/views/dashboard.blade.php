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
                                        <h6><strong>{{ $todo->title }}</strong></h6>
                                        <p>{{ $todo->description }}</p>
                                        <br/>

                                        <form action="{{ route('todo.update', $todo->id) }}" method="post">
                                            @csrf
                                            {{ method_field('PUT') }}
                                            <x-primary-button class="completeTodo" style="background: rgb(14, 165, 233); color: #fff;">Done</x-primary-button>
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
                                        <h6 style="text-decoration: line-through;"><strong>{{ $todo->title }}</strong></h6>
                                        <p style="text-decoration: line-through;">{{ $todo->description }}</p>
                                        <br/>
                                        <x-danger-button type="button" class="deleteTodo" value="{{ route('todo.destroy', $todo->id) }}">Delete</x-primary-button>
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
        });
    </script>
</x-app-layout>
