<div>
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalAddMainMenu">
        Add New Menu</button>

    <table class="table table-responsive-sm" id="">
        <thead>
            <tr>
                <th scope="col">Menu Name</th>
                <th scope="col">URI</th>
                <th scope="col">Sub Menu</th>
                <th scope="col">Status</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ __('Home') }}</td>
                <td><a href="{{ route('public-home') }}" target="_blank">
                        <div>
                            {{ __('/') }}
                        </div>
                    </a>
                </td>
                <td>{{ __('None') }}</td>
                <td>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="" checked disabled>
                        <label class="form-check-label" for="}">
                            {{ __('Enabled') }}
                        </label>
                    </div>
                </td>
                <td></td>
            </tr>
            @if ($mainMenus)
                @foreach ($mainMenus as $mainMenu)
                    <tr>
                        <td>{{ ucwords($mainMenu['mainMenu']) }}</td>
                        <td><a href="{{ route('public-show', ['main' => $mainMenu['URI']]) }}" target="_blank">
                                <div>
                                    {{ '/' . $mainMenu['URI'] }}
                                </div>
                            </a>
                        </td>
                        <td>
                            @if (strtolower($mainMenu['mainMenu']) === 'about')
                                {{ __('None') }}
                            @else
                                @if ($mainMenu['hasSubMenu'])
                                    <button class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#modalAddSubMenu"
                                        wire:click="addSubMenu('{{ $mainMenu['id'] }}')"><i class="fa fa-plus"></i> Add
                                        Sub
                                        Menu</button>
                                    <button class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#modalViewSubMenu"
                                        wire:click="viewSubMenus('{{ $mainMenu['id'] }}')"><i class="fa fa-eye"></i>
                                        View
                                        Sub Menu</button>
                                @else
                                    <button class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#modalAddSubMenu"
                                        wire:click="addSubMenu('{{ $mainMenu['id'] }}')"><i class="fa fa-plus"></i> Add
                                        Sub
                                        Menu</button>
                                @endif
                            @endif
                        </td>
                        <td>
                            @if (strtolower($mainMenu['mainMenu']) === 'about')
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="" checked disabled>
                                    <label class="form-check-label" for="}">
                                        {{ __('Enabled') }}
                                    </label>
                                </div>
                            @else
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="{{ $mainMenu['mainMenu'] }}"
                                        @if ($mainMenu['isEnabled']) checked @endif
                                        wire:click="toggleStatus('{{ $mainMenu['id'] }}')">
                                    <label class="form-check-label" for="{{ $mainMenu['mainMenu'] }}">
                                        @if ($mainMenu['isEnabled'])
                                            {{ __('Enabled') }}
                                        @else
                                            {{ __('Disabled') }}
                                        @endif
                                    </label>
                                </div>
                            @endif
                        </td>
                        <td>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalEditMainMenu"
                                wire:click="edit('{{ $mainMenu['id'] }}')"><i class="fa fa-edit"></i> Edit
                                Menu</button>
                            <a href="{{ route('admin.contents-create', ['main' => $mainMenu['URI']]) }}"
                                class="btn btn-primary"><i class="fa fa-plus"></i> Add Content</a>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

    <div wire:ignore.self class="modal fade" id="modalAddMainMenu" tabindex="-1" role="dialog"
        aria-labelledby="modalAddMainMenu" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><strong>Add Main Menu</strong></h5>
                </div>
                <form action="javascript:void(0)" wire:submit.prevent="store" method="post" novalidate>
                    @csrf

                    <div class="modal-body text-left">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label">Menu Name *</label>
                                <input type="text" class="form-control @error('mainMenu') is-invalid @enderror"
                                    required wire:model.lazy="mainMenu">
                                @error('mainMenu')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button"
                            wire:click="closeModal('#modalAddMainMenu')">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="modalEditMainMenu" tabindex="-1" role="dialog"
        aria-labelledby="modalEditMainMenu" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><strong>Edit Main Menu</strong></h5>
                </div>
                <form action="javascript:void(0)" wire:submit.prevent="update" method="post" novalidate>
                    @csrf
                    @method('patch')

                    <div class="modal-body text-left">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label">Menu Name *</label>
                                <input type="text" class="form-control @error('mainMenu') is-invalid @enderror"
                                    required wire:model.lazy="mainMenu">
                                @error('mainMenu')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button"
                            wire:click="closeModal('#modalEditMainMenu')">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- submenu --}}
    <div wire:ignore.self class="modal fade" id="modalViewSubMenu" tabindex="-1" role="dialog"
        aria-labelledby="modalViewSubMenu" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><strong>Sub Menu of {{ $mainMenuName }}</strong></h5>
                </div>
                <div class="modal-body text-left">
                    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalAddSubMenu"
                        wire:click="addSubMenu('{{ $mainMenuID }}')"><i class="fa fa-plus"></i> Add New Sub
                        Menu</button>

                    <table class="table table-responsive-sm" id="">
                        <thead>
                            <tr>
                                <th scope="col">Sub Menu</th>
                                <th scope="col">URI</th>
                                <th scope="col">Status</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($subMenus)
                                @foreach ($subMenus as $subMenu)
                                    <tr>
                                        <td>{{ ucwords($subMenu['subMenu']) }}</td>
                                        <td>
                                            <a href="{{ route('public-show', ['main' => $subMenu['mainURI'] . '/' . $subMenu['subURI']]) }}"
                                                target="_blank">
                                                <div>
                                                    {{ '/' . $subMenu['mainURI'] . '/' . $subMenu['subURI'] }}
                                                </div>
                                            </a>
                                        </td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox"
                                                    id="{{ $subMenu['subMenu'] }}"
                                                    @if ($subMenu['isEnabled']) checked @endif
                                                    wire:click="toggleSubMenuStatus('{{ $subMenu['id'] }}')">
                                                <label class="form-check-label" for="{{ $subMenu['subMenu'] }}">
                                                    @if ($subMenu['isEnabled'])
                                                        {{ __('Enabled') }}
                                                    @else
                                                        {{ __('Disabled') }}
                                                    @endif
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <button class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#modalEditSubMenu"
                                                wire:click="editSubMenu('{{ $subMenu['id'] }}')"><i
                                                    class="fa fa-edit"></i> Edit Sub Menu</button>
                                            <a href="{{ route('admin.contents-create', ['main' => $subMenu['mainURI'] . '/' . $subMenu['subURI']]) }}"
                                                class="btn btn-primary"><i class="fa fa-plus"></i> Add Content</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button"
                        wire:click="closeModal('#modalViewSubMenu')">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="modalAddSubMenu" tabindex="-1" role="dialog"
        aria-labelledby="modalAddSubMenu" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><strong>Add Sub Menu for {{ $mainMenuName }}</strong></h5>
                </div>
                <form action="javascript:void(0)" wire:submit.prevent="storeSubMenu" method="post" novalidate>
                    @csrf

                    <div class="modal-body text-left">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label">Sub Menu Name *</label>
                                <input type="text" class="form-control @error('subMenu') is-invalid @enderror"
                                    required wire:model.lazy="subMenu">
                                @error('subMenu')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button"
                            wire:click="closeModal('#modalAddSubMenu')">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="modalEditSubMenu" tabindex="-1" role="dialog"
        aria-labelledby="modalEditSubMenu" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><strong>Edit Sub Menu of {{ $mainMenuName }}</strong></h5>
                </div>
                <form action="javascript:void(0)" wire:submit.prevent="updateSubMenu" method="post" novalidate>
                    @csrf
                    @method('patch')

                    <div class="modal-body text-left">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label">Sub Menu Name *</label>
                                <input type="text" class="form-control @error('subMenu') is-invalid @enderror"
                                    required wire:model.lazy="subMenu">
                                @error('subMenu')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button"
                            wire:click="closeModal('#modalEditSubMenu')">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
