<x-layouts.app title="Cursos">
    <div class="py-6">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="mb-6 flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Gestión de Cursos</h1>
                    <p class="text-gray-600 dark:text-gray-400">Administra los cursos y materiales de capacitación</p>
                </div>
                <a href="{{ route('courses.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md transition-colors">
                    <i class="fa-solid fa-plus mr-2"></i>
                    Crear Curso
                </a>
            </div>

            @if(session('success'))
                <div class="mb-6 bg-green-100 dark:bg-green-900/30 border border-green-400 dark:border-green-600 text-green-700 dark:text-green-400 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if($courses->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($courses as $course)
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-lg transition-shadow">
                            <!-- Thumbnail -->
                            <div class="h-48 bg-gradient-to-br from-blue-500 to-purple-600 relative">
                                @if($course->thumbnail)
                                    <img src="{{ Storage::url($course->thumbnail) }}" alt="{{ $course->title }}" class="w-full h-full object-cover">
                                @else
                                    <div class="flex items-center justify-center h-full">
                                        <i class="fa-solid fa-graduation-cap text-white text-6xl opacity-50"></i>
                                    </div>
                                @endif
                                <!-- Status Badge -->
                                <span class="absolute top-3 right-3 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $course->status === 'published' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $course->status === 'draft' ? 'bg-gray-100 text-gray-800' : '' }}
                                    {{ $course->status === 'archived' ? 'bg-red-100 text-red-800' : '' }}
                                ">
                                    {{ $course->status_label }}
                                </span>
                            </div>

                            <!-- Content -->
                            <div class="p-5">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2 line-clamp-2">
                                    {{ $course->title }}
                                </h3>
                                
                                @if($course->description)
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 line-clamp-2">
                                        {{ $course->description }}
                                    </p>
                                @endif

                                <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400 mb-4">
                                    <div class="flex items-center">
                                        <i class="fa-solid fa-file mr-1"></i>
                                        <span>{{ $course->materials_count }} materiales</span>
                                    </div>
                                    @if($course->duration_minutes)
                                        <div class="flex items-center">
                                            <i class="fa-solid fa-clock mr-1"></i>
                                            <span>{{ $course->duration_minutes }} min</span>
                                        </div>
                                    @endif
                                </div>

                                <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-700">
                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                        Por {{ $course->creator->name }}
                                    </div>
                                    <div class="flex space-x-2">
                                        <a href="{{ route('courses.show', $course) }}" class="inline-flex items-center px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium rounded-md transition-colors">
                                            <i class="fa-solid fa-eye mr-1"></i>
                                            Ver
                                        </a>
                                        <a href="{{ route('courses.edit', $course) }}" class="inline-flex items-center px-3 py-1.5 bg-gray-600 hover:bg-gray-700 text-white text-xs font-medium rounded-md transition-colors">
                                            <i class="fa-solid fa-edit mr-1"></i>
                                            Editar
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $courses->links() }}
                </div>
            @else
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow border border-gray-200 dark:border-gray-700 p-12">
                    <div class="text-center">
                        <i class="fa-solid fa-graduation-cap text-gray-400 text-6xl mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No hay cursos creados</h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-6">
                            Comienza creando tu primer curso de capacitación
                        </p>
                        <a href="{{ route('courses.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md transition-colors">
                            <i class="fa-solid fa-plus mr-2"></i>
                            Crear Primer Curso
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-layouts.app>

