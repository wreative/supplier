@extends('layouts.default')
@section('title', __('pages.title').__(' | Master Satuan'))
@section('titleContent', __('Satuan'))
@section('breadcrumb', __('Master'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Satuan') }}</div>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <a href="{{ route('createUnits') }}" class="btn btn-icon icon-left btn-primary">
            <i class="far fa-edit"></i>{{ __(' Tambah Satuan') }}</a>
    </div>
    <div class="card-body">
        <table class="table-striped table" id="units" width="100%">
            <thead>
                <tr>
                    <th class="text-center">
                        {{ __('NO') }}
                    </th>
                    <th>{{ __('Nama') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($units as $number => $u)
                <tr>
                    <td class="text-center">
                        {{ $number+1 }}
                    </td>
                    <td>{{ $u->name }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
@section('script')
<script src="{{ asset('pages/units/units.js') }}"></script>
@endsection