@extends('layouts.app-form')

@section('template_title')
    Create Course
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">Create Course</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('courses.store') }}"  role="form" enctype="multipart/form-data">
                            @csrf

                            @include('admin.course.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
