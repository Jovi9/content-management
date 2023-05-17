<div>
    <table class="table table-responsive-sm" id="">
        <thead>
            <tr>
                <th scope="col">Image</th>
                <th scope="col">Title</th>
                <th scope="col">Date Deleted</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @if ($news)
                @foreach ($news as $new)
                    <tr>
                        <td>
                            <img src="{{ Storage::url($new['image']) }}" alt="Image" class="img-fluid" width="250">
                        </td>
                        <td>{{ $new['title'] }}</td>
                        <td>{{ $new['deleted_at'] }}</td>
                        <td>
                            <button class="btn btn-primary"
                                wire:click="restoreSeleted('{{ $new['id'] }}')">Restore</button>
                            <button class="btn btn-danger" wire:click="deleteSelected('{{ $new['id'] }}')">Permanent
                                Delete</button>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
