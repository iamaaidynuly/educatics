@extends('layouts.app')

@section('template_title')
    Курсы
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Курсы') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('courses.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                  {{ __('СОЗДАТЬ НОВЫЙ') }}
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
										<th>Сфера</th>
										<th>Очередь</th>
										<th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($courses as $course)
                                        <tr>
                                            <td>{{ $course->id }}</td>

											<td>{{ App\Models\Translate::whereId($course->title)->value('ru') }}</td>
											<td>{{ App\Models\Translate::whereId($course->description)->value('ru') }}</td>
                                            @if($course->sphere_id == 2)
                                                <td>Склонность к работе с людьми</td>
                                            @elseif($course->sphere_id == 3 )
                                                <td>Сфера умственного труда</td>
                                            @elseif($course->sphere_id == 4)
                                                <td>Склонность к техническим</td>
                                            @elseif($course->sphere_id == 5)
                                                <td>Склонность к материальным</td>
                                            @else
                                                <td>Сфера не выбрана</td>
                                            @endif
                                            <td>
                                                {{$course->queue}}
                                            </td>
                                            <td>
                                                <a class="btn btn-sm btn-info" href="{{route('course-seo', $course->id)}}">Настроить SEO</a>
                                            </td>
                                            <td>
                                                <form action="{{ route('courses.destroy',$course->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('courses.show',$course->id) }}"><i class="fa fa-fw fa-eye"></i></a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('courses.edit',$course->id) }}"><i class="fa fa-fw fa-edit"></i></a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-center">
                                {{ $courses->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
