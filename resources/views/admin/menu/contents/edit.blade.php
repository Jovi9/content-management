<x-app-layout>
    @if ($subMenu != 'none')
        @section('title', 'Edit ' . ucwords($subMenu) . ' Contents')
    @else
        @section('title', 'Edit ' . ucwords($menu) . ' Contents')
    @endif
    @section('styles')
        {{-- tinymce --}}
        <script src="https://cdn.tiny.cloud/1/owfc6ejvogt649hiqn8o9zbwjaa2er9p72383jdf49t6kzlu/tinymce/6/tinymce.min.js"
            referrerpolicy="origin"></script>
    @endsection

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @if ($subMenu != 'none')
                {{ __('Edit content of ') . ucwords($subMenu) }}
            @else
                {{ __('Edit content of ') . ucwords($menu) }}
            @endif
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class=" overflow-hidden shadow-sm sm:rounded-lg">
                <div class=" text-gray-900 p-6 bg-white">
                    <form action="{{ route('user.contents-update', ['id' => Crypt::encrypt($content->id)]) }}"
                        method="post" id="formContent">

                        @csrf
                        @method('put')

                        <input type="hidden" name="main_menu" value="{{ $menu }}">
                        @if ($subMenu != 'none')
                            <input type="hidden" name="sub_menu" value="{{ $subMenu }}">
                        @endif
                        <div>
                            <x-input-label for="title" :value="__('Title')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title"
                                value="{{ $content->title }}" required autofocus />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="content" :value="__('Content')" />
                            <textarea name="content" id="content" rows="15"
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full">
                            {!! $content->content !!}
                            </textarea>
                            <x-input-error :messages="$errors->get('content')" class="mt-2" />
                        </div>

                        <div class="mt-4 flex gap-2">
                            <button type="button" id="btnSubmit"
                                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Save') }}
                            </button>
                            @if ($subMenu != 'none')
                                @if ($fromContent == true)
                                    <a class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150"
                                        href="{{ route('user.contents-index') }}">
                                        {{ __('Cancel') }}
                                    </a>
                                @else
                                    <a class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150"
                                        href="{{ route('user.show-content-sub', ['menu' => $menu, 'sub_menu' => $subMenu]) }}">
                                        {{ __('Cancel') }}
                                    </a>
                                @endif
                            @else
                                @if ($fromContent == true)
                                    <a class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150"
                                        href="{{ route('user.contents-index') }}">
                                        {{ __('Cancel') }}
                                    </a>
                                @else
                                    <a class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150"
                                        href="{{ route('user.show-content-main', ['menu' => $menu]) }}">
                                        {{ __('Cancel') }}
                                    </a>
                                @endif
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelector("#btnSubmit").addEventListener("click", function() {
                tinymce.activeEditor.uploadImages().then(() => {
                    document.querySelector('#formContent').submit();
                });
            });
        });

        const image_upload_handler = (blobInfo, progress) => new Promise((resolve, reject) => {
            const max_size = 104857600; //100MB
            if (blobInfo.blob().size > max_size) {
                return reject({
                    message: 'File is too big!',
                    remove: true
                });
            }

            const xhr = new XMLHttpRequest();
            xhr.withCredentials = false;
            @if ($subMenu != 'none')
                xhr.open('POST',
                    "{{ route('user.img-upload', ['subMenu' => $subMenu]) }}");
            @else
                xhr.open('POST', "{{ route('user.img-upload', ['menu' => $menu]) }}");
            @endif
            var token = '{{ csrf_token() }}';
            xhr.setRequestHeader("X-CSRF-Token", token);

            xhr.upload.onprogress = (e) => {
                progress(e.loaded / e.total * 100);
            };

            xhr.onload = () => {
                if (xhr.status === 403) {
                    reject({
                        message: 'HTTP Error: ' + xhr.status,
                        remove: true
                    });
                    return;
                }

                if (xhr.status < 200 || xhr.status >= 300) {
                    reject('HTTP Error: ' + xhr.status);
                    return;
                }

                const json = JSON.parse(xhr.responseText);

                if (!json || typeof json.location != 'string') {
                    reject('Invalid JSON: ' + xhr.responseText);
                    return;
                }

                resolve(json.location);
            };

            xhr.onerror = () => {
                reject('Image upload failed due to a XHR Transport error. Code: ' + xhr.status);
            };

            const formData = new FormData();
            formData.append('file', blobInfo.blob(), blobInfo.filename());

            xhr.send(formData);
        });

        tinymce.init({
            selector: 'textarea#content',
            plugins: 'autolink charmap emoticons image link lists searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter linkchecker permanentpen advtable editimage tableofcontents footnotes autocorrect typography inlinecss',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
            removed_menuitems: 'newdocument',
            menubar: false,
            branding: false,
            automatic_uploads: false,
            block_unsupported_drop: true,
            file_picker_types: 'image',
            images_upload_handler: image_upload_handler,
        });
    </script>

    @if ($errors->get('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Failed to process request.',
                text: 'Something went wrong, please try again.',
                allowOutsideClick: false
            });
        </script>
    @endif

</x-app-layout>
