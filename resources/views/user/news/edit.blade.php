@extends('layouts.app')
@section('title', 'Edit News')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/sweetalert2/sweetalert2.min.css') }}">
    {{-- tinymce --}}
    <script src="https://cdn.tiny.cloud/1/owfc6ejvogt649hiqn8o9zbwjaa2er9p72383jdf49t6kzlu/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>
@endsection

@section('page-header', 'Edit News')
@section('page-header-right')
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.news-page') }}">News</a></li>
            <li class="breadcrumb-item active">{{ __('Edit News') }}</li>
        </ol>
    </div>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.news-update', ['id' => $news->id]) }}" method="post" id="formContent"
                            enctype="multipart/form-data">
                            @csrf
                            @method('put')

                            <div class="col-md-12 mb-3">
                                <label class="form-label">News Title *</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror"
                                    name="title" value="{{ $news->title }}" required>
                                @error('title')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">News Content *</label>
                                <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="15">
                                    {!! $news->content !!}
                            </textarea>
                                @error('content')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <button type="button" class="btn btn-primary" id="btnSubmit">Save</button>
                                <a href="{{ route('admin.news-page') }}" class="btn btn-secondary">Cancel</a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/sweetalert2/sweetalert2.min.js') }}"></script>

    <script>
        var allowFormSubmit = true;
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelector("#btnSubmit").addEventListener("click", function() {
                tinymce.activeEditor.uploadImages().then(() => {
                    if (allowFormSubmit === true) {
                        document.querySelector('#formContent').submit();
                    } else {
                        allowFormSubmit = true;
                    }
                });
            });
        });

        function verifyIfJSON(string) {
            try {
                return (JSON.parse(string) && !!string)
            } catch (error) {
                return false;
            }
        }

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
            xhr.open('POST', "{{ route('admin.news-image-upload') }}");
            var token = '{{ csrf_token() }}';
            xhr.setRequestHeader("X-CSRF-Token", token);

            xhr.upload.onprogress = (e) => {
                progress(e.loaded / e.total * 100);
            };

            xhr.onload = () => {
                if (verifyIfJSON(xhr.responseText) === false) {
                    allowFormSubmit = false;
                    return reject({
                        message: 'Please make sure to select valid image.',
                        remove: true
                    });
                }

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

            allowFormSubmit = true;
            const formData = new FormData();
            formData.append('file', blobInfo.blob(), blobInfo.filename());
            xhr.send(formData);
        });

        tinymce.init({
            selector: '#content',
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
@endsection
