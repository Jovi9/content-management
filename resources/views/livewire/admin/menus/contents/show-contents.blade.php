<div>
    <div class="row gap-2 mb-3">
        <div class="col-md-2">
            @if ($subURI === 'none')
                <a href="{{ route('admin.contents-create', ['main' => $mainURI]) }}" class="btn btn-primary"><i
                        class="fa fa-plus"></i> Add New Content</a>
            @else
                <a href="{{ route('admin.contents-create', ['main' => $mainURI . '/' . $subURI]) }}"
                    class="btn btn-primary"><i class="fa fa-plus"></i> Add New Content</a>
            @endif
        </div>
        <div class="col-md-2">
            @livewire('admin.menus.contents.manage-content-arrangement', ['mainURI' => $mainURI, 'subURI' => $subURI])
        </div>
    </div>
    <table class="table table-responsive-sm" id="">
        <thead>
            <tr>
                <th scope="col">Title</th>
                <th scope="col">URI</th>
                <th scope="col">Date</th>
                <th scope="col">User</th>
                <th scope="col">Status</th>
                <th scope="col">Arrangement</th>
                <th scope="col">Visible To Home</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @if ($contents)
                @foreach ($contents as $content)
                    <tr>
                        <td>{{ ucwords($content['title']) }}</td>
                        <td>
                            @if (strtolower($subURI) === 'none')
                                <a href="{{ route('public-show', ['main' => $mainURI]) }}#{{ strtolower(str_replace(' ', '-', $content['title'])) }}"
                                    target="_blank">
                                    <div>
                                        {{ '/' . $mainURI }}
                                    </div>
                                </a>
                            @else
                                <a href="{{ route('public-show', ['main' => $mainURI . '/' . $subURI]) }}#{{ strtolower(str_replace(' ', '-', $content['title'])) }}"
                                    target="_blank">
                                    <div>
                                        {{ '/' . $mainURI . '/' . $subURI }}
                                    </div>
                                </a>
                            @endif
                        </td>
                        <td>Date Created: {{ $content['created_at'] }} <br>
                            Date Updated: {{ $content['updated_at'] }}
                        </td>
                        <td>Created By:
                            {{ ucwords($content['created_by']->firstName . ' ' . $content['created_by']->lastName) }}
                            <br>
                            Updated By:
                            {{ ucwords($content['updated_by']->firstName . ' ' . $content['updated_by']->lastName) }}
                        </td>
                        <td>{{ ucwords($content['status']) }}</td>
                        <td>{{ $content['arrangement'] }}</td>
                        <td>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="{{ $content['id'] }}"
                                    @if ($content['isVisibleHome']) checked @endif
                                    wire:click="showToHome('{{ $content['id'] }}')">
                                <label class="form-check-label" for="{{ $content['id'] }}">
                                    @if ($content['isVisibleHome'])
                                        {{ __('Enabled') }}
                                    @else
                                        {{ __('Disabled') }}
                                    @endif
                                </label>
                            </div>
                        </td>
                        <td>
                            <a href="{{ route('admin.contents-edit', ['id' => $content['id']]) }}"
                                class="btn btn-primary"><i class="fa fa-edit"></i></a>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
