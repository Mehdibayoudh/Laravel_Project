@extends('layouts_Admin.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card my-4">
            <!-- Add Event Button -->
            <div class="d-flex justify-content-end">
            </div>

            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                    <h6 class="text-white text-capitalize ps-3">Ressources Table</h6>
                </div>
            </div>

            <div class="card-body px-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Title</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">type</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">status</th>
                                <th class="text-secondary opacity-7"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($Ressources as $r)
                            <tr>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{ $r->titre }}</h6>
                                            <img style="width: 100px;" src="{{ asset('storage/' . $r->image) }}" alt="{{ $r->titre }}" style="width: 100%; height: auto;">
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p class="text-xs font-weight-bold mb-0">{{ $r->type }}</p>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <span class="text-secondary text-xs font-weight-bold">{{ $r->disponibilité }}</span>
                                </td>
                                <td class="align-middle">
                                    <form action="{{ route('ressourceadmin.destroy', $r->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this ressource?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="border:none; background:#ff003e; padding: 10px; border-radius: 100%; margin-left: 5px;">
                                            <i class="fa fa-trash" style="color: white; margin-left: 10px; margin-right: 10px;"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection