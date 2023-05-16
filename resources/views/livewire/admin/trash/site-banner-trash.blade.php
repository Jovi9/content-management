<div>
    <table class="table table-responsive-sm" id="">
        <thead class="table-dark">
            <tr>
                <th scope="col">Title</th>
                <th scope="col">Short Description</th>
                <th scope="col">Image</th>
                <th scope="col">Date Deleted</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @if ($banners)
                @foreach ($banners as $banner)
                    <tr>
                        <td>{{ ucwords($banner['title']) }}</td>
                        <td>{{ $banner['shortDesc'] }}</td>
                        <td>
                            <img src="{{ Storage::url($banner['image']) }}" alt="Image" class="img-fluid"
                                width="250">
                        </td>
                        <td>{{ $banner['deleted_at'] }}</td>
                        <td>
                            <button class="btn btn-primary"
                                wire:click="restoreSeleted('{{ $banner['id'] }}')">Restore</button>
                            <button class="btn btn-danger" wire:click="deleteSelected('{{ $banner['id'] }}')">Permanent
                                Delete</button>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
