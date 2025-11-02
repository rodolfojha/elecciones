<x-layouts.app title="{{ $course->title }}">
    <div class="py-6">
        <div class="mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-6 flex justify-between items-start">
                <div class="flex-1">
                    <div class="flex items-center space-x-3 mb-2">
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $course->title }}</h1>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                            {{ $course->status === 'published' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : '' }}
                            {{ $course->status === 'draft' ? 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200' : '' }}
                            {{ $course->status === 'archived' ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' : '' }}
                        ">
                            {{ $course->status_label }}
                        </span>
                    </div>
                    @if($course->description)
                        <p class="text-gray-600 dark:text-gray-400">{{ $course->description }}</p>
                    @endif
                    <div class="mt-2 flex items-center space-x-4 text-sm text-gray-500 dark:text-gray-400">
                        <span><i class="fa-solid fa-user mr-1"></i>{{ $course->creator->name }}</span>
                        <span><i class="fa-solid fa-calendar mr-1"></i>{{ $course->created_at->format('d/m/Y') }}</span>
                        @if($course->duration_minutes)
                            <span><i class="fa-solid fa-clock mr-1"></i>{{ $course->duration_minutes }} minutos</span>
                        @endif
                    </div>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('courses.edit', $course) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md transition-colors">
                        <i class="fa-solid fa-edit mr-2"></i>
                        Editar
                    </a>
                    <form action="{{ route('courses.destroy', $course) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Estás seguro de eliminar este curso y todos sus materiales?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-md transition-colors">
                            <i class="fa-solid fa-trash mr-2"></i>
                            Eliminar
                        </button>
                    </form>
                    <a href="{{ route('courses.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-md transition-colors">
                        <i class="fa-solid fa-arrow-left mr-2"></i>
                        Volver
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="mb-6 bg-green-100 dark:bg-green-900/30 border border-green-400 dark:border-green-600 text-green-700 dark:text-green-400 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Upload Material Form -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow border border-gray-200 dark:border-gray-700 p-6 mb-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                    <i class="fa-solid fa-cloud-upload mr-2 text-blue-600"></i>
                    Subir Material
                </h2>
                <form action="{{ route('courses.materials.upload', $course) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Título del Material <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="title" 
                                id="title" 
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                placeholder="Ej: Lección 1 - Introducción"
                                required
                            >
                        </div>
                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Tipo de Material <span class="text-red-500">*</span>
                            </label>
                            <select 
                                name="type" 
                                id="type"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                required
                            >
                                <option value="">Seleccionar tipo</option>
                                <option value="video">📹 Video</option>
                                <option value="pdf">📄 PDF</option>
                                <option value="image">🖼️ Imagen</option>
                                <option value="document">📋 Documento</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Descripción (Opcional)
                        </label>
                        <textarea 
                            name="description" 
                            id="description" 
                            rows="2"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                            placeholder="Breve descripción del material..."
                        ></textarea>
                    </div>
                    <div class="mb-4">
                        <label for="file" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Archivo <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="file" 
                            name="file" 
                            id="file"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                            required
                        >
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            Tamaño máximo: 100MB
                        </p>
                    </div>
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md transition-colors">
                        <i class="fa-solid fa-upload mr-2"></i>
                        Subir Material
                    </button>
                </form>
            </div>

            <!-- Materials List -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow border border-gray-200 dark:border-gray-700">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                        <i class="fa-solid fa-folder-open mr-2 text-blue-600"></i>
                        Materiales del Curso ({{ $course->materials->count() }})
                    </h2>
                </div>

                @if($course->materials->count() > 0)
                    <div class="p-6">
                        <div class="space-y-4">
                            @foreach($course->materials as $material)
                                <div class="flex items-start space-x-4 p-4 bg-gray-50 dark:bg-gray-900/50 rounded-lg border border-gray-200 dark:border-gray-700">
                                    <!-- Icon -->
                                    <div class="flex-shrink-0">
                                        <div class="w-12 h-12 rounded-lg bg-{{ $material->type_color }}-100 dark:bg-{{ $material->type_color }}-900/30 flex items-center justify-center">
                                            <i class="{{ $material->type_icon }} text-{{ $material->type_color }}-600 text-xl"></i>
                                        </div>
                                    </div>

                                    <!-- Content -->
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-start justify-between">
                                            <div class="flex-1">
                                                <h3 class="text-sm font-medium text-gray-900 dark:text-white">
                                                    {{ $material->title }}
                                                </h3>
                                                @if($material->description)
                                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                                        {{ $material->description }}
                                                    </p>
                                                @endif
                                                <div class="flex items-center space-x-4 mt-2 text-xs text-gray-500 dark:text-gray-400">
                                                    <span><i class="fa-solid fa-file mr-1"></i>{{ $material->file_name }}</span>
                                                    <span><i class="fa-solid fa-weight-hanging mr-1"></i>{{ $material->formatted_size }}</span>
                                                    <span class="px-2 py-0.5 rounded-full bg-{{ $material->type_color }}-100 text-{{ $material->type_color }}-800 dark:bg-{{ $material->type_color }}-900/30 dark:text-{{ $material->type_color }}-200">
                                                        {{ $material->type_label }}
                                                    </span>
                                                </div>
                                            </div>
                                            
                                            <!-- Actions -->
                                            <div class="flex space-x-2 ml-4">
                                                @if($material->type === 'image')
                                                    <a href="{{ Storage::url($material->file_path) }}" target="_blank" class="inline-flex items-center px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white text-xs font-medium rounded-md transition-colors">
                                                        <i class="fa-solid fa-eye mr-1"></i>
                                                        Ver
                                                    </a>
                                                @elseif($material->type === 'video')
                                                    <a href="{{ Storage::url($material->file_path) }}" target="_blank" class="inline-flex items-center px-3 py-1.5 bg-purple-600 hover:bg-purple-700 text-white text-xs font-medium rounded-md transition-colors">
                                                        <i class="fa-solid fa-play mr-1"></i>
                                                        Reproducir
                                                    </a>
                                                @else
                                                    <a href="{{ Storage::url($material->file_path) }}" target="_blank" class="inline-flex items-center px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium rounded-md transition-colors">
                                                        <i class="fa-solid fa-download mr-1"></i>
                                                        Descargar
                                                    </a>
                                                @endif
                                                
                                                <form action="{{ route('courses.materials.delete', [$course, $material]) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Eliminar este material?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white text-xs font-medium rounded-md transition-colors">
                                                        <i class="fa-solid fa-trash mr-1"></i>
                                                        Eliminar
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="p-12 text-center">
                        <i class="fa-solid fa-folder-open text-gray-400 text-5xl mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No hay materiales aún</h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            Comienza subiendo videos, PDFs o imágenes para este curso
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts.app>

