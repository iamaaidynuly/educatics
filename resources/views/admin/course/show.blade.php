@extends('layouts.app-form')

@section('template_title')
    {{ $course->name ?? 'Show Course' }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Course</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('courses.index') }}"> Back</a>
                        </div>
                    </div>

{{--                    <div class="card-body">--}}
{{--                        <ul class="nav nav-pills">--}}
{{--                            <li class="nav-item"><a class="nav-link active" href="#en" data-toggle="tab">Английский</a></li>--}}
{{--                            <li class="nav-item"><a class="nav-link" href="#ru" data-toggle="tab">Русский</a></li>--}}
{{--                            <li class="nav-item"><a class="nav-link" href="#kz" data-toggle="tab">Казахский</a></li>--}}
{{--                        </ul>--}}

{{--                        <div class="form-group">--}}
{{--                            <strong>Title:</strong>--}}
{{--                            {{ $course->title }}--}}
{{--                        </div>--}}
{{--                        <div class="form-group">--}}
{{--                            <strong>Description:</strong>--}}
{{--                            {{ $course->description }}--}}
{{--                        </div>--}}
{{--                        <div class="form-group">--}}
{{--                            <strong>Price:</strong>--}}
{{--                            {{ $course->price }}--}}
{{--                        </div>--}}
{{--                        <div class="form-group">--}}
{{--                            <strong>Certificate:</strong>--}}
{{--                            {{ $course->certificate }}--}}
{{--                        </div>--}}

{{--                    </div>--}}
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">
                                <div class="row">
                                    <div class="col-12 col-sm-4">
                                        <div class="info-box bg-light">
                                            <div class="info-box-content">
                                                <span class="info-box-text text-center text-muted">Цена</span>
                                                <span class="info-box-number text-center text-muted mb-0">{{$course->price}}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="info-box bg-light">
                                            <div class="info-box-content">
                                                <span class="info-box-text text-center text-muted">Количество студентов</span>
                                                <span class="info-box-number text-center text-muted mb-0">123</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="info-box bg-light">
                                            <div class="info-box-content">
                                                <span class="info-box-text text-center text-muted">Количество уроков</span>
                                                <span class="info-box-number text-center text-muted mb-0">123</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <h4>Данные по курсу</h4>
                                        <div class="post">
                                            <div class="user-block">
                                                <span class="username"><a href="#">На английском</a></span>
                                            </div>

                                            <p>
                                                {{\App\Models\Translate::whereId($course->title)->value('en')}}
                                            </p>
                                            <p>
                                                {{\App\Models\Translate::whereId($course->description)->value('en')}}
                                            </p>
                                        </div>

                                        <div class="post">
                                            <div class="user-block">
                                                <span class="username"><a href="#">На русском</a></span>
                                            </div>

                                            <p>
                                                {{\App\Models\Translate::whereId($course->title)->value('ru')}}
                                            </p>
                                            <p>
                                                {{\App\Models\Translate::whereId($course->description)->value('ru')}}
                                            </p>
                                        </div>

                                        <div class="post">
                                            <div class="user-block">
                                                <span class="username"><a href="#">На казахском</a></span>
                                            </div>

                                            <p>
                                                {{\App\Models\Translate::whereId($course->title)->value('kz')}}
                                            </p>
                                            <p>
                                                {{\App\Models\Translate::whereId($course->description)->value('kz')}}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2">
                                <h3 class="text-primary"><i class="fas fa-paint-brush"></i>{{\App\Models\Translate::whereId($course->title)->value('ru')}}</h3>
                                <p class="text-muted"> {{\App\Models\Translate::whereId($course->description)->value('ru')}}</p>
                                <br>
                                <div class="text-muted">
                                    <p class="text-sm">Категории</p>
                                        @foreach($intros as $intro)
                                            <b class="d-block">{{\App\Models\Translate::whereId($intro->title)->value('ru')}}</b>
                                        @endforeach
                                </div>
                                <h5 class="mt-5 text-muted">Project files</h5>
                                <ul class="list-unstyled">
                                    <li>
                                        <a href="" class="btn-link text-secondary"><i class="far fa-fw fa-file-word"></i> {{$course->certificate}}</a>
                                    </li>
                                </ul>
                                <div class="text-center mt-5 mb-3">
                                    <a href="#" class="btn btn-sm btn-primary">Добавить файлы</a>
                                    <a href="{{route('course-intros.show', $course->id)}}" class="btn btn-sm btn-info">Категории</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
