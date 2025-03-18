@extends('layouts.admin')

@section('content')
<form action="{{ url('/admin/landing') }}" method="POST">
    @csrf
    @foreach($sections as $section)
        <h3>{{ ucfirst($section->section_name) }}</h3>
        <textarea name="sections[{{ $section->id }}]" rows="5">{{ $section->content }}</textarea>
        <label>
            <input type="checkbox" name="is_active[{{ $section->id }}]" {{ $section->is_active ? 'checked' : '' }}>
            Aktif
        </label>
        <hr>
    @endforeach
    <button type="submit">Simpan</button>
</form>
@endsection
