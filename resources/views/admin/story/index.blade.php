@extends('layouts.app')

@section('template_title')
Личные истории
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">

                        <span id="card_title">
                            {{ __('Личные истории') }}
                        </span>

                        <div class="float-right">
                            <a href="{{ route('stories.create') }}" class="btn btn-primary btn-sm float-right"
                                data-placement="left">
                                {{ __('Создать новую историю') }}
                            </a>
                        </div>
                    </div>
                </div>
                @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
                @endif

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="thead">
                                <tr>
                                    <th>#</th>

                                    <th>Название</th>
                                    <th>Описание</th>
                                    <th>Картинка</th>

                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($stories as $story)
                                <tr>
                                    <td>{{ $story->id }}</td>

                                    <td>{{ \App\Models\Translate::whereId($story->title)->value('ru') }}</td>
                                    <td>{{ \App\Models\Translate::whereId($story->description)->value('ru') }}</td>
                                    <td>
                                        <img src="https://jaryk-back.test-nomad.kz/{{ $story->image }}" width="200px"
                                            height="100px">
                                    </td>

                                    <td>
                                        <form action="{{ route('stories.destroy',$story->id) }}" method="POST">
                                            {{-- <a class="btn btn-sm btn-primary "
                                                href="{{ route('spheres.show',$sphere->id) }}"><i
                                                    class="fa fa-fw fa-eye"></i></a>--}}
                                            <a class="btn btn-sm btn-success"
                                                href="{{ route('stories.edit',$story->id) }}"><i
                                                    class="fa fa-fw fa-edit"></i></a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"><i
                                                    class="fa fa-fw fa-trash"></i></button>
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
</div>
@endsection