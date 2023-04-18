<div>
    <table class="table table-responsive-sm" id="">
        <thead>
            <tr>
                <th scope="col">Main Menu</th>
                <th scope="col">Sub Menu</th>
                <th scope="col">URI</th>
                <th scope="col">Title</th>
                <th scope="col">Date Created</th>
                <th scope="col">Date Modified</th>
                <th scope="col">User</th>
                <th scope="col">Status</th>
                <th scope="col">Visibility</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @if ($contents)
                @foreach ($contents as $content)
                    <tr>
                        <td>{{ $content['mainMenu'] }}</td>
                        <td>{{ $content['subMenu'] }}</td>
                        <td>
                            @if (strtolower($content['subMenu']) === 'none')
                                <a href="{{ route('public-show', ['main' => $content['mainURI']]) }}" target="_blank">
                                    <div>
                                        {{ '/' . $content['mainURI'] }}
                                    </div>
                                </a>
                            @else
                                <a href="{{ route('public-show', ['main' => $content['mainURI'] . '/' . $content['subURI']]) }}"
                                    target="_blank">
                                    <div>
                                        {{ '/' . $content['mainURI'] . '/' . $content['subURI'] }}
                                    </div>
                                </a>
                            @endif
                        </td>
                        <td>{{ $content['title'] }}</td>
                        <td>{{ $content['created_at'] }}</td>
                        <td>{{ $content['updated_at'] }}</td>
                        <td>{{ $content['user'] }}</td>
                        <td>{{ ucwords($content['status']) }}</td>
                        <td>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="{{ $content['id'] }}"
                                    @if ($content['isVisible']) checked @endif
                                    wire:click="toggleVisibility('{{ $content['id'] }}')">
                                <label class="form-check-label" for="{{ $content['id'] }}">
                                    @if ($content['isVisible'])
                                        {{ __('Visible') }}
                                    @else
                                        {{ __('Hidden') }}
                                    @endif
                                </label>
                            </div>
                        </td>
                        <td>
                            @if (strtolower($content['status']) === 'pending')
                                <button class="btn btn-primary" wire:click="approveContent('{{ $content['id'] }}')"><i
                                        class="fa fa-check"></i></button>
                            @endif
                            <a href="{{ route('admin.contents-edit', ['id' => $content['id'], 'requestFrom' => 'manage-contents']) }}"
                                class="btn btn-primary"><i class="fa fa-edit"></i></a>
                            <button class="btn btn-danger"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
