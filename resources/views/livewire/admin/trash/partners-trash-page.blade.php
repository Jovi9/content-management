<div>
    <table class="table table-responsive-sm" id="">
        <thead class="table-dark">
            <tr>
                <th scope="col">Name</th>
                <th scope="col">URL</th>
                <th scope="col">Logo</th>
                <th scope="col">Date Deleted</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @if ($partners)
                @foreach ($partners as $key => $partner)
                    <tr>
                        <td>
                            {{ $partner['name'] }}
                        </td>
                        <td>
                            <a href="{{ $partner['URL'] }}">{{ $partner['URL'] }}</a>
                        </td>
                        <td>
                            <img src="{{ Storage::url($partner['image']) }}" alt="Logo" class="img-fluid"
                                width="250">
                        </td>
                        <td>
                            {{ $partner['deleted_at'] }}
                        </td>
                        <td>
                            <button class="btn btn-primary"
                                wire:click="restoreSeleted('{{ $partner['id'] }}')">Restore</button>
                            <button class="btn btn-danger" wire:click="deleteSelected('{{ $partner['id'] }}')">Permanent
                                Delete</button>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
