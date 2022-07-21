<div class="box box-info padding-1">
    <div class="box-body">
        <div class="form-group">
            <label for="ru">RU</label>
            <textarea type="text" class="ckeditor form-control" id="ru" name="ru" placeholder="Введите название:">
                {{isset($aboutU->description) ? \App\Models\Translate::where('id', $aboutU->description)->value('ru') : ''}}
            </textarea>
            @if($errors->has('ru'))
                <span class="text-danger">{{$errors->first('ru')}}</span>
            @endif
        </div>
        <div class="form-group">
            <label for="ru">KZ</label>
            <textarea type="text" class="ckeditor form-control" id="ru" name="kz" placeholder="Введите название:">
                 {{isset($aboutU->description) ? \App\Models\Translate::where('id', $aboutU->description)->value('kz') : ''}}
            </textarea>
            @if($errors->has('ru'))
                <span class="text-danger">{{$errors->first('kz')}}</span>
            @endif
        </div>
        <div class="form-group">
            <label for="ru">EN</label>
            <textarea type="text" class="ckeditor form-control" id="ru" name="en" placeholder="Введите название:">
                 {{isset($aboutU->description) ? \App\Models\Translate::where('id', $aboutU->description)->value('en') : ''}}
            </textarea>
            @if($errors->has('ru'))
                <span class="text-danger">{{$errors->first('en')}}</span>
            @endif
        </div>
    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">Принять</button>
    </div>
</div>
